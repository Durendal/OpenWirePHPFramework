<?php


namespace Libraries;

use \Framework as Framework;

class webot extends Framework
{
    private $ref;
    private $agent;
    private $timeout;
    private $cook;
    private $curl;
    private $proxy;
    private $credentials;
    // Specifies if parse $this->INCLudes the delineator
    private $EXCL;
    private $INCL;
    // Specifies if parse returns the text $this->BEFORE or $this->AFTER the delineator
    private $BEFORE;
    private $AFTER;

    protected $framework, $name, $description;
    
    //initiate bot properties
    public function __construct($framework, $proxy='', $credentials='')
    {
		$this->framework = $framework;
                $this->name = 'webot';
                $this->description = 'Library to provide generic text manipulation and encoding functions';
		$this->proxy = $proxy;//set proxy
		$this->timeout = 30;//set Timeout for curl requests
		$this->ref = 'http://www.reddit.com/';//set default referer
		$this->agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0';//set default agent
		$this->cook = 'cookies.txt';//set cookie file
		$this->curl = $this->setupCURL($this->proxy);//initiate curl
		$this->EXCL = true;
		$this->INCL = false;
		$this->BEFORE = true;
		$this->AFTER = false;
		$this->credentials = $credentials;//set credentials for proxy
   	 
    }
    
    // Gets the contents of $url and returns the result
    public  function curl_get_contents($url, $ref='')
    {
		if($ref == '')
		{
			$ref = $url;
		}
		$ch = $this->curl;
		$agen = $this->agent;
		$hd = array("Connection: Keep-alive", "Keep-alive: 300", "Expect:", "Referer: $ref", "User-Agent: $agen");
		$c  = curl_setopt($ch, CURLOPT_URL, $url);
		$c  = curl_setopt($ch, CURLOPT_POST, 0);
		$c  = curl_setopt($ch, CURLOPT_HTTPHEADER, $hd);
		$x  = curl_exec($ch);
		//$g['data'] = $x;
		return $x;
    }
    
    // Posts $pdata to $purl and returns the result
    public function curl_post_contents($purl, $pdata, $ref='')
    {
		if($ref == '')
		{
			$ref = $purl;
		}
		$ch = $this->curl;
		$agen = $this->agent;
		$hd = array("Connection: Keep-alive", "Keep-alive: 300", "Expect:", "Referer: $ref", "User-Agent: $agen");
		$c  = curl_setopt($ch, CURLOPT_URL, $purl);
		$c  = curl_setopt($ch, CURLOPT_POST, 1);
		$c  = curl_setopt($ch, CURLOPT_POSTFIELDS, $pdata);
		$c  = curl_setopt($ch, CURLOPT_HTTPHEADER, $hd);
		$x  = curl_exec($ch);
		$c  = curl_setopt($ch, CURLOPT_POST, 0);
		//$g['data'] = $x;
		return $x;
    }
    
    // Sets up cURL, enables keep-alive, spoofs referer
    private  function setupCURL($py=null, $type='http', $port=8080)
    {
		$ck = $this->cook;
		$hd = array("Connection: Keep-alive", "Keep-alive: 300", "Expect:");
		$ch = curl_init();
		//$py = $this->proxy;
		if($py)
		{
			if($type == 'http')
			{
				
				$c = curl_setopt($ch, CURLOPT_PROXY, $py);
				$c = curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
				$c = curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				print("Using Proxy: $py\n");
			}
			else if($type == 'socks')
			{
				$proxy = explode(":", $py);
				$ip = $proxy[0];
				$port = $proxy[1];
				$c = curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
				$c = curl_setopt($ch, CURLOPT_PROXY, $ip);
				$c = curl_setopt($ch, CURLOPT_PROXYPORT, $port);
				$c = curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
				$c = curl_setopt($ch, CURLOPT_HTTPAUTH, 8);
				$c = curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
				$c = curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->credentials);
				print("Using Proxy: $ip:$port\n");
			}
			else
			{
				print "Unsupported Proxy type submitted. Terminating...\n";
				die();
			}
			
		}
		$c = curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$c = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 5);
		$c = curl_setopt($ch, CURLOPT_HEADER, 1);
		$c = curl_setopt($ch, CURLOPT_COOKIEJAR, $ck);
		$c = curl_setopt($ch, CURLOPT_COOKIEFILE, $ck);
		$c = curl_setopt($ch, CURLOPT_HTTPHEADER, $hd);
		return $ch;
    }
    
    private function split_string($string, $delineator, $desired, $type)
	{
		// Case insensitive parse, convert string and delineator to lower case
		$lc_str = strtolower($string);
		$marker = strtolower($delineator);
    
		// Return text $this->BEFORE the delineator
		if($desired == $this->BEFORE)
		{
			if($type == $this->EXCL)  // Return text ESCL of the delineator
				$split_here = strpos($lc_str, $marker);
			else           	// Return text $this->INCL of the delineator
				$split_here = strpos($lc_str, $marker)+strlen($marker);
   	 
			$parsed_string = substr($string, 0, $split_here);
		}
		// Return text $this->AFTER the delineator
		else
		{
			if($type==$this->EXCL)	// Return text ESCL of the delineator
				$split_here = strpos($lc_str, $marker) + strlen($marker);
			else           	// Return text $this->INCL of the delineator
				$split_here = strpos($lc_str, $marker) ;
   	 
			$parsed_string =  substr($string, $split_here, strlen($string));
		}
		return $parsed_string;
	}
    
    public function return_between($string, $start, $stop, $type)
	{
		$temp = $this->split_string($string, $start, $this->AFTER, $type);
		return $this->split_string($temp, $stop, $this->BEFORE, $type);
	}
    
    function parse_array($string, $beg_tag, $close_tag)
	{
		preg_match_all("($beg_tag(.*)$close_tag)siU", $string, $matching_data);
		return $matching_data[0];
	}
    
    public function get_attribute($tag, $attribute)
	{
		// Use Tidy library to 'clean' input
		$cleaned_html = $this->tidy_html($tag);
    	// Remove all line feeds from the string
		$cleaned_html = str_replace("\r", "", $cleaned_html);   
		$cleaned_html = str_replace("\n", "", $cleaned_html);
		// Use return_between() to find the properly quoted value for the attribute
		return $this->return_between($cleaned_html, strtoupper($attribute)."=\"", "\"", $this->EXCL);
	}
    
    public function remove($string, $open_tag, $close_tag)
	{
		// Get array of things that should be removed from the input string
		$remove_array = $this->parse_array($string, $open_tag, $close_tag);
    
		// Remove each occurrence of each array element from string;
		for($xx=0; $xx<count($remove_array); $xx++)
			$string = str_replace($remove_array, "", $string);
    
		return $string;
	}
    
    public function tidy_html($input_string)
	{
		// Detect if Tidy is in configured
		if( function_exists('tidy_get_release') )
		{
			// Tidy for PHP version 4
			if(substr(phpversion(), 0, 1) == 4)
        	{
				tidy_setopt('uppercase-attributes', TRUE);
				tidy_setopt('wrap', 800);
				tidy_parse_string($input_string);       	 
				$cleaned_html = tidy_get_output();  
        	}
			// Tidy for PHP version 5
			if(substr(phpversion(), 0, 1) == 5)
			{
				$config = array(
                'uppercase-attributes' => true,
                'wrap'             	=> 800);
				$tidy = new tidy;
				$tidy->parseString($input_string, $config, 'utf8');
				$tidy->cleanRepair();
				$cleaned_html  = tidy_get_output($tidy);  
			}
    	}
		else
		{
			// Tidy not configured for this computer
			$cleaned_html = $input_string;
    	}
		return $cleaned_html;
	}

    public function validateURL($url)
    {
		$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
		return preg_match($pattern, $url);
    }
}


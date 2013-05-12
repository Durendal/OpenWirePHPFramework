<?php
/*
Admin Finder
Version: 1.0 
Author: Logic
Date: May 12, 2013
*/
namespace aux;
use \Framework as Framework;
 


class adminfinder extends Framework {
 
	protected $framework, $name, $description, $variables, $type, $language;

	public function __construct($framework) 
	{
	   
		$this->framework = $framework;
		$this->name = 'Admin Finder';
		$this->description = 'Simple Port Scanner';
	    $this->variables = array(
	        'searchtype' => array('required' => false, 'description' => 'Set the search type (robots.txt, phpinfo, phpmyadmin)', 'default' => 'robots'),
	        'language' => array('required' => false, 'description' => 'Set the lang to search for (php, asp, cfm, aspx, jsp, htm, html, shtml, cgi, js', 'default' => 'PHP'),

	    );
	   
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDesc()
	{
		return $this->description;
	}

	public function getVars()
	{
		return $this->variables;
	}

	private function loadModule()
	{
		$this->setModule(1, $this->module_name);
	}

	private function installModule()
	{
		$this->addModule($this->module_name);
		$this->loadModule();
	}

	public function check()
	{
		print "\n\n\t[*] Detecting Search Type";
		if ($this->searchtype == 'robots') {
			print "\n\t[*] Search Type Detected as Robots.txt";
			$type = "Robots";
		}
		else if ($this->searchtype == 'phpinfo') {
			print "\n\t[*] Search Type Detected as PHP Info";
			$type = "phpinfo";
		}
		else if ($this->searchtype == 'phpmyadmin') {
			print "\n\t[*] Search Type Detected as PHPMYADMIN";
			$type = "phpmyadmin";
		}



		print "\n\n\t[*] Detecting LANG Type";
		if ($this->language == 'shtml') {
			print "\n\t[*] LANG Type Detected as SHTML\n";
			$language = ".shtml";
		}
		else if ($this->language == 'asp') {
			print "\n\t[*] LANG Type Detected as ASP\n";
			$language = ".asp";
		}
		else if ($this->language == 'aspx') {
			print "\n\t[*] LANG Type Detected as ASPX\n";
			$language = ".aspx";
		}
		else if ($this->language == 'cfm') {
			print "\n\t[*] LANG Type Detected as CFM\n";
			$language = ".cfm";
		}
		else if ($this->language == 'cgi') {
			print "\n\t[*] LANG Type Detected as CGI\n";
			$language = ".cgi";
		}
		else if ($this->language == 'js') {
			print "\n\t[*] LANG Type Detected as JS\n";
			$language = ".js";
		}
		else if ($this->language == 'jsp') {
			print "\n\t[*] LANG Type Detected as JSP\n";
			$language = ".jsp";
		}
		else if ($this->language == 'htm') {
			print "\n\t[*] LANG Type Detected as HTM\n";
			$language = ".htm";
		}
		else if ($this->language == 'html') {
			print "\n\t[*] LANG Type Detected as HTML\n";
			$language = ".html";
		}
		else {
			print "\n\t[*] LANG Type Detected as PHP\n";
			$language = ".php";
		}


	}

	public function exploit()
	{
		
		$this->run();
			
		return 1;
	}

	public function post()
	{
		print "This module does not support post Exploit\n";

		return 0;
	}

	public function run()
	{



	}
}
?>

<?php
	 
	 
	namespace Core;
	use \Framework as Framework;
	

class modules extends Framework {
		 
		protected $framework, $name, $description;
		private $module, $defaultVariables, $modType;
	   
		public function __construct($framework)
		{
			$this->framework = $framework;
			$this->name = "modules";
			$this->description = "Module functions";
			$this->base_path = $this->framework->base;
			$this->defaultVariables = array(
			'target' => array('required' => true, 'description' => 'The target host (ex. www.google.com)', 'match' => self::regexURL),
	);
            $this->modType = null;
		}

// Start Module Functions
protected function preloadModules()
{
    $modtypes = array("aux", "exploit", "payload");
    foreach($modtypes as $type)
    {
        $this->modtype = $type;
        $files = glob("{$this->base_path}/modules/$type/*.php");
        foreach ($files as $file) require_once $file;
    }
	return true;
}





protected function verifyModule()
{
	if (!is_object($this->module)) {
		echo $this->framework->libs['colours']->cstring("\n\n\tNo Module Defined\n\n", "blue");
		return false;
	}
	return true;
}



protected function loadModule($module)
{
	
	

	if (!file_exists("{$this->framework->base}/modules/".$this->modType."/{$module}.php")) {
			echo $this->framework->libs['colours']->cstring("\n\n\t[ ", "white");
			echo $this->framework->libs['colours']->cstring("*", "red");
			echo $this->framework->libs['colours']->cstring(" ] ", "white");
			echo $this->framework->libs['colours']->cstring("{$module} is not a valid module\n\n", "blue");
			return false;
	}
	$this->module = null;
	require_once "{$this->framework->base}/modules/".$this->modType."/{$module}.php";
	$class = "\\".ucfirst($this->modType)."\\{$module}";
	$this->module = new $class($this->framework);

	if (!is_object($this->module)) {
			echo $this->framework->libs['colours']->cstring("\n\n\t[ ", "white");
			echo $this->framework->libs['colours']->cstring("*", "red");
			echo $this->framework->libs['colours']->cstring(" ] ", "white");
			echo $this->framework->libs['colours']->cstring("Error loading module {$module}\n\n", "blue");
			return false;
	}   
	$vars = $this->module->getVars();
	$this->variables = array_merge($this->defaultVariables, $vars);
			echo $this->framework->libs['colours']->cstring("\n\n\t[ ", "white");
			echo $this->framework->libs['colours']->cstring("*", "green");
			echo $this->framework->libs['colours']->cstring(" ] ", "white");
			echo $this->framework->libs['colours']->cstring($this->module->getName()."loaded\n\n", "green");
			return true;
}

protected function listModules()
{
        $type = $this->modType;
	$this->preloadModules();
	$classes = get_declared_classes();
	foreach ($classes as $class) {
            
			preg_match('#('.$type.'\\\.*)#', $class, $matches);
			if (empty($matches[1])) continue;
			$module = new $matches[1]($this);
			$name = $module->getName();
			$desc = $module->getDesc();
			echo $this->framework->libs['colours']->cstring("\n\n\t\t\tOpenWire Framework\n", "blue");
			echo $this->framework->libs['colours']->cstring("\t  List of all Exploit Modules\n\n", "purple");
			echo $this->framework->libs['colours']->cstring("\t{$name} ", "white");
			echo $this->framework->libs['colours']->cstring("- {$desc}\n\n", "blue");
			unset($module);
	}
	return true;
}


protected function listType()
{
	return $this->modType;
}

public function setModType($type)
{
	switch($type)
	{
		case 'aux':
			$this->modType = 'aux';
			break;

		case 'exploit':
			$this->modType = 'exploit';
			break;

		case 'payload':
			$this->modType = 'payload';
			break;

		default:
			$this->modType = null;
			return false;
	}
	return true;
}


// End Module Functions

//  Start Variable Functions
protected function verifyVariables()
{
    foreach ($this->variables as $key => $data) {
            if ($data['required'] && empty($this->module->$key)) {
                    echo $this->framework->libs['colours']->cstring("\n\tMissing required variable: ", "blue");
                    echo $this->framework->libs['colours']->cstring("{$key}\n\n", "red");
                    return false;
            }
            if (!$data['required'] && empty($this->module->$key)) {
                    $this->module->$key = $this->variables[$key]['default'];
            }
    }
    return true;
}

public function showVariables()
{
    if(!$this->verifyModule()) return false;
    $this->verifyVariables();
    
    foreach($this->variables as $key => $variable)
    {
        $required = ($variable['required'] ? '*' : ' ');
        echo $this->framework->libs['colours']->cstring("\t{$required} ", "red");
        echo $this->framework->libs['colours']->cstring("{$key}", "white");
        echo " => ";
        if(isset($this->module->$key))
            echo $this->framework->libs['colours']->cstring($this->module->$key."", "green");
        else
            echo $this->framework->libs['colours']->cstring("default", "blue");
        echo " => ";
        echo $this->framework->libs['colours']->cstring("{$variable['description']}\n", "purple");
    }
        echo $this->framework->libs['colours']->cstring("\n\n\t*", "red");
        echo $this->framework->libs['colours']->cstring(" = ", "white");
        echo $this->framework->libs['colours']->cstring("required\n\n", "blue");
}

private function variableExists($variable)
{
    $exists = in_array($variable, array_keys($this->variables));
    return $exists;
}

public function setValue($variable, $value)
{
    if (!$this->verifyModule()) return false;
    if (!$this->variableExists($variable)) {
            echo "OpenWire: Variable {$variable} doesn't exist\n";
            return false;
    }

    $this->module->$variable = $value;
    echo $this->framework->libs['colours']->cstring("\n\n\t${variable} set as ", "white");
    echo $this->framework->libs['colours']->cstring("${value}\n\n", "blue");
    return true;
}
// End Variable Functions

public function getModule()
{
    $mod = $this->module;
    return $mod;
}
}
?>

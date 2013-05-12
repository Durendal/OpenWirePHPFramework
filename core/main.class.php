<?php
 
 
namespace Core;
use \Framework as Framework;


class main extends Framework {
     
    protected $framework, $name, $description;

    public function __construct($framework)
    {
	   $this->framework = $framework;
       $this->name = "main";
       $this->description = "Main framework functions";
    }


    public function outputHeader()
    {

       $this->framework->clearScreen();

       echo "\n";
       echo $this->framework->libs['colours']->cstring("\t  _|_|                                  _|          _|  _|                     \n", "purple");
       echo $this->framework->libs['colours']->cstring("\t_|    _|  _|_|_|      _|_|    _|_|_|    _|          _|      _|  _|_|    _|_|   \n", "purple");
       echo $this->framework->libs['colours']->cstring("\t_|    _|  _|    _|  _|_|_|_|  _|    _|  _|    _|    _|  _|  _|_|      _|_|_|_| \n", "purple");
       echo $this->framework->libs['colours']->cstring("\t_|    _|  _|    _|  _|        _|    _|    _|  _|  _|    _|  _|        _|       \n", "purple");
       echo $this->framework->libs['colours']->cstring("\t  _|_|    _|_|_|      _|_|_|  _|    _|      _|  _|      _|  _|          _|_|_| \n", "purple");
       echo $this->framework->libs['colours']->cstring("\t          _|                                                                   \n", "purple");
       echo $this->framework->libs['colours']->cstring("\t          _|                                                                   \n\n", "purple");
       echo $this->framework->libs['colours']->cstring("\t                           ~  OpenWire Framework ~            \n", "blue");
       echo $this->framework->libs['colours']->cstring("Current Status: ", "white");
       echo $this->framework->libs['colours']->cstring("BETA\n", "blue");
       echo $this->framework->libs['colours']->cstring("Current Version: ", "white");
       echo $this->framework->libs['colours']->cstring("1.1.0\n\n\n", "blue");

       return true;
    }

    public function showUsage()
    {

       echo "\n\n";
       echo $this->framework->libs['colours']->cstring(" \t            OpenWire Framework\n", "blue");
       echo $this->framework->libs['colours']->cstring("\t List of commands and description of usage\n\n\n", "purple");

       echo $this->framework->libs['colours']->cstring(" \thelp", "white");
       echo $this->framework->libs['colours']->cstring("                        - Display this list\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tclear/cls", "white");
       echo $this->framework->libs['colours']->cstring("                   - Clears the Screen\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tlibs", "white");
       echo $this->framework->libs['colours']->cstring("                        - List current libraries\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tbanner", "white");
       echo $this->framework->libs['colours']->cstring("                      - Displays the Banner\n\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tshow/list exploits", "white");
       echo $this->framework->libs['colours']->cstring("          - List current exploit modules\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tshow/list payloads", "white");
       echo $this->framework->libs['colours']->cstring("          - List current payload modules\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tshow/list aux", "white");
       echo $this->framework->libs['colours']->cstring("               - List current auxiliary modules\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tshow/list variables", "white");
       echo $this->framework->libs['colours']->cstring("         - Show the global and exploit specific variables\n\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tuse/load exploit <exploit>", "white");
       echo $this->framework->libs['colours']->cstring("  - Load an exploit module\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tuse/load payload <payload>", "white");
       echo $this->framework->libs['colours']->cstring("  - Load a payload module\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tuse/load aux <aux>", "white");
       echo $this->framework->libs['colours']->cstring("          - Load an auxiliary module\n\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tset <variable> <value>", "white");
       echo $this->framework->libs['colours']->cstring("      - Set a variable to value (ex. target host)\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tshow variables", "white");
       echo $this->framework->libs['colours']->cstring("              - Show the global and exploit specific variables\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tview", "white");
       echo $this->framework->libs['colours']->cstring("                        - Show currently set variable values\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \tcheck", "white");
       echo $this->framework->libs['colours']->cstring("                       - Check if the target is vulnerable to currently loaded exploit\n", "blue");

       echo $this->framework->libs['colours']->cstring(" \texploit", "white");
       echo $this->framework->libs['colours']->cstring("                     - Run the currently loaded exploit module\n\n", "blue");

       return true;
    }
}
?>

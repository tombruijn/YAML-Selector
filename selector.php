<?php
/*
Yaml Selector. Simple level selection class for YAML files.
@version 0.0.2
@author Tom de Bruijn <tom@newanz.com>
@link 
@copyright Copyright 2010 Tom de Bruijn
@license http://www.opensource.org/licenses/mit-license.php MIT License

@resource Using Spyc library by Chris Wanstrath and Vlad Andersen.
@link http://code.google.com/p/spyc/
*/
class YamlSelector{
	private $data = array(); #Used to store the entire selected YAML file.
	private $setting = array("type"=>"array"); #Settings for return values.
	static $variables = array(); #Very rapidly changing values here.
	/*
	__construct
	@param String Optional $file = Path to the YAML file you want to load.
	@param Boolean Optional (Default: FALSE) $object = Return results as object or not? (Only usefull for selecting a level with children.)
	*/
	function __construct($file=false,$object=false){
		require_once("spyc.php");
		if($object==true){
			$this->setting["type"] = "object";
		}
		if(!empty($file)){
			$this->loadFile($file);
		}
	}
	/*
	loadFile
	Loads the YAML file in the object.
	@param String $file = Path to the YAML file you want to load.
	*/
	function loadFile($file){
		$this->data = Spyc::YAMLLoad($file);
	}
	/*
	get
	@param String $selector = Preformatted key for the selection of a YAML variable.
		Examples:
			- firstlevel
			- firstlevel.secondlevel
			- firstlevel.secondlevel.thirdlevel
	@param Array $variables = Keys are name of the variables in the YAML variable. Array values are what they will be replaces with.
	@return mixed; String/Array, depending on the selection level.
	*/
	function get($selector,$variables=array()){
		$keys = explode(".",$selector);
		$var = $this->data;
		foreach($keys as $key){
			$v = $this->returnValue($var,$key);
			$var = $v;
		}
		if($this->setting["type"]=="object"){
			$var = (object)$var;
		}
		if(is_string($var) && !empty($variables)){
			$var = $this->parseVariables($var,$variables);
		}
		return $var;
	}
	/*
	returnValue
	Searches for a key in an array and returns the value of that key in that array when it is found.
	Private method
	@param Array $var = Array with variables.
	@param String $key = Key in the array.
	@return: mixed; String, Array or Boolean (FALSE).
	*/
	private function returnValue($var,$key){
		if(array_key_exists($key,$var)){
			return $var[$key];
		}else{
			return false;
		}
	}
	/*
	parseVariables
	
	Private method
	@param Array $var = Array with variables.
	@param String $key = Key in the array.
	@return: mixed; String.
	*/
	private function parseVariables($var,$variables){
		self::$variables = $variables; //Egh...
		return preg_replace_callback("#{{(.*?)}}#is",
			create_function('$string','return YamlSelector::$variables[$string[1]];')
		,$var);
	}
}
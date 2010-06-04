<?php
/*
Yaml Selector. Simple level selection class for YAML files.
@version 0.0.6
@date 2010-06-04
@author Tom de Bruijn <tom@newanz.com>
@link: http://newanz.com, http://github.com/Newanz/YAML-Selector
@copyright Copyright 2010 Tom de Bruijn
@license http://www.opensource.org/licenses/mit-license.php MIT License

@resource Using Spyc library by Chris Wanstrath and Vlad Andersen.
@link http://code.google.com/p/spyc/
*/
class YamlSelector{
	private $data = array(); #Used to store the entire selected YAML file.
	private $setting = array("file"=>FALSE,"errors"=>FALSE,"type"=>"array"); #Settings for return values.
	static $variables = array(); #Very rapidly changing values here.
	/*
	__construct
	@param String Optional $file = Path to the YAML file you want to load.
	@param Boolean Optional (Default: FALSE) $object = Return results as object or not? (Only usefull for selecting a level with children.)
	@param Boolean $errors = TRUE: show errors. FALSE: no errors.
	*/
	function __construct($file=FALSE,$object=FALSE,$errors=FALSE){
		require_once("spyc.php");
		$this->setting["file"] = $file;
		$this->returnObject($object);
		$this->setErrors($errors);
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
		$this->setting["file"] = $file;
		$this->data = Spyc::YAMLLoad($file);
	}
	/*
	setErrors
	Set errors on or off for this class.
	@param Boolean $mode = TRUE: show errors. FALSE: no errors.
	*/
	function setErrors($mode=TRUE){
		if(is_bool($mode)){
			$this->setting["errors"] = $mode;
		}
	}
	/*
	returnObject
	@param Boolean $mode = TRUE: show errors. FALSE: no errors.
	*/
	function returnObject($mode=TRUE){
		$this->setting["type"] = "array";
		if($mode===TRUE){
			$this->setting["type"] = "object";
		}
	}
	/*
	convertToObject
	Private method
	@param Array $array = The array you want to convert
	*/
	private function convertToObject($array){
		$obj = new stdClass();
		if(is_array($array)){
			foreach($array as $k=>$v){
				if(is_array($v)){
					$obj->$k = $this->convertToObject($v);
				}else{
					$obj->$k = $v;
				}
			}
		}
		return $obj;
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
	function get($selector,$variables=FALSE){
		$keys = explode(".",$selector);
		$var = $this->data;
		foreach($keys as $key){
			if(is_array($var)){
				$var = $this->returnValue($var,$key);
			}else{
				return "<strong>Error:</strong> No level, <strong>".$selector."</strong> -&gt; <strong>".$key."</strong>, found in YAML file <strong>".realpath($this->setting["file"])."</strong>.<br/>";
			}
		}
		if($this->setting["type"]=="object"){
			$var = $this->convertToObject($var);
		}
		if(is_string($var) && isset($variables)){
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
		if(@array_key_exists($key,$var)){
			return $var[$key];
		}else{
			if($this->setting["errors"]){
				return "<strong>Error:</strong> No key, <strong>".$key."</strong>, found at this level in YAML file <strong>".realpath($this->setting["file"])."</strong>.<br/>";
			}
			return FALSE;
		}
	}
	/*
	parseVariables
	Replaces variable names ( {{name}} ) with the given replacement values.
	Private method
	@param Array $var = Array with variables.
	@param String $key = Key in the array.
	@return: mixed; String.
	*/
	private function parseVariables($var,$variables){
		self::$variables = $variables; //Egh...
		return preg_replace_callback("#{{(.*?)}}#is",
			function($s){
				return is_array(YamlSelector::$variables) ? (array_key_exists($s[1],YamlSelector::$variables) ? YamlSelector::$variables[$s[1]] : $s[0]) : YamlSelector::$variables; 
			}
		,$var);
	}
}
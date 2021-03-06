# YAML Selector

YAML variable selector for PHP. It support deep level selection and variable replacements.

## Project details

* Author: Tom de Bruijn - Newanz.com (<http://newanz.com>)
* Version: 0.0.8
* More details at: <http://github.com/Newanz/YAML-Selector>

## Requirements

* PHP: Version 5.3+
* PHP Spyc library (included)

## Installation

* Download/Unpack the YAML-Selector project.
* Move the "yaml_selector" directory to your project.
* Prepare a YAML file. Tutorial: <http://yaml.kwiki.org/?YamlInFiveMinutes>
* In your PHP project use the following code:
* Code:
	
		<?php
		require_once("yaml_selector/yaml_selector.php");
		$yaml = new YamlSelector("yourfile.yaml");

* What to do from there is your choice! See the examples below to see how YAML Selector works!

## Usage

See/run the index.php file for more information about it's usage, but in short:

### YAML example file

	keyname: Some variable
	firstlevel:
		secondlevel: Deep nested variable.
	variable:
		one: Hello {{name}}!
		two: Hello {{name}}! You have a message: {{someinfo}}

### YAML Selector demo code

	<?php
	require_once("yaml_selector/yaml_selector.php");
	$yaml = new YamlSelector("example_file.yaml");
	echo $yaml->get("keyname");
	echo $yaml->get("firstlevel.secondlevel");
	echo $yaml->get("variable.one","your name");
	echo $yaml->get("variable.two",array("name"=>"your name","someinfo"=>"Another variable"));
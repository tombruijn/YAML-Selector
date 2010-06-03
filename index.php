<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<title>YAML Selector examples</title>
	<style type='text/css'>
		body{
			margin: 10px;
			font-family: Arial, Verdana;
			font-size: 90%;
			background-color: #eee;
		}
		p,pre{
			margin: 0 0 5px 0;
		}
		
		h1,h2,h3,h4{
			margin: 0 0 5px 0;
		}
		h1{
			font-size: 20px;
			color: #00a2ff;
			border-bottom: 1px solid #00a2ff;
		}
		h2{
			font-size: 16px;
			color: #FF8A00;
			border-bottom: 1px solid #FF8A00;
		}
		h3{
			font-size: 14px;
			color: #6CADC0;
			border-bottom: 1px solid #6CADC0;
		}
		h4{
			font-size: 12px;
			color: #323232;
		}
		.content{
			margin-right: 350px;
			min-width: 500px;
		}
		.block{
			margin-bottom: 10px;
			padding: 10px;
			background-color: #FFF;
			border: 1px solid #CCC;
			border-radius: 10px;
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
		}
		.side{
			position: fixed;
			top: 10px;
			right: 10px;
			float: right;
			width: 330px;
		}
		.example{
			margin-left: 20px;
			margin-right: 20px;
			margin-bottom: 10px;
			padding: 10px 10px 10px 10px;
			background-color: #FFF;
			border: 1px solid #CCC;
			border-radius: 10px;
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
		}
		.example code{
			display: block;
			margin-bottom: 10px;
			overflow: auto;
		}
	</style>
</head>
<body>
<?php
require_once("yaml_selector.php");
$i = new YamlSelector("data.yaml");
$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);
echo "
<div class='side'>
	<div class='block'>
		<h2>Example file</h2>
		".highlight_file("example_file.yaml",TRUE)."
	</div>
	<div class='block'>
		<h2>3rd party library</h2>
		<h3>".$i->get("yaml.library.name")."</h3>
		<p>".$i->get("yaml.library.description")."</p>
		<p>Spyc authors:<ul>";
		$authors = $i->get("yaml.library.author");
		foreach($authors as $k=>$v){
			echo "<li>".$k." (".$v["email"].")</li>";
		}
		echo "</ul></p>
		<p>Link: ".$i->get("yaml.library.link")."</p>
	</div>
</div>

<div class='content'>
<div class='block'>
	<h1>".$i->get("yaml.selector.name")."</h1>
	<p>".$i->get("yaml.selector.description")."</p>
	<h2>Details</h2>
	<p>Version: ".$i->get("yaml.selector.version")."</p>
	<p>Last updated: ".$i->get("yaml.selector.date.updated")."</p>
	<p>Author: ".$i->get("yaml.selector.author")." - ".$i->get("yaml.selector.company")."</p>
	<p>Copyright: ".$i->get("yaml.selector.copyright")."</p>
	<p>Github: ".$i->get("yaml.selector.git")."</p>
</div>

<div class='block'>
	<h3>Example inviroment</h3>
	<p>These variables will be avaliable to the example codes. See more about configuration below the examples.</p>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'require_once("yaml_selector.php");'."\n".
	'$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);',TRUE)."
</div>

<div class='block'>
	<h2>Usage examples</h2>
</div>

<div class='example'>
	<h3>First level selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("version");',TRUE)."
	<h4>Result</h4>
	".$yaml->get("version")."
</div>

<div class='example'>
	<h3>Second level selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("request.time");',TRUE)."
	<h4>Result</h4>
	".$yaml->get("request.time")."
</div>

<div class='example'>
	<h3>Third level selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("setting.date.format");',TRUE)."
	<h4>Result</h4>
	".$yaml->get("setting.date.format")."
</div>

<div class='example'>
	<h3>Array selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'print_r($yaml->get("page"));',TRUE)."
	<h4>Result</h4><pre>";
	print_r($yaml->get("page"));
echo "</pre></div>

<div class='example'>
	<h3>Single variable insertion</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'echo $yaml->get("variable.one","Tom"); #Strings only works when there is only one variable'."\n".
	'echo $yaml->get("variable.one",array("name"=>"Michael")); #Replacement by variable name',TRUE)."
	<h4>Result</h4>";
	echo $yaml->get("variable.one","Tom")."<br/>";
	echo $yaml->get("variable.one",array("name"=>"Michael"));
echo "</div>

<div class='example'>
	<h3>Multiple variable insertion</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'echo $yaml->get("variable.two",array("name"=>"Tom","difference"=>"three days"));'."\n".
	'echo $yaml->get("variable.two",array("name"=>"Michael")); #Skipping {{difference}}',TRUE)."
	<h4>Result</h4>";
	echo $yaml->get("variable.two",array("name"=>"Tom","difference"=>"three days"))."<br/>";
	echo $yaml->get("variable.two",array("name"=>"Michael"));
echo "</div>

<div class='example'>
	<h3>Intentional errors - Keys don't exist</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'echo $yaml->get("request.date"); #This key doesn\'t exist'."\n".
	'echo $yaml->get("request.time.something"); #This level doesn\'t exists',TRUE)."
	<h4>Result</h4>";
	echo $yaml->get("request.date");
	echo $yaml->get("request.time.something");
echo "</div>

<div class='block'>
	<h2>Configuration</h2>
</div>

<div class='example'>
	<h3>Multiple level return</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n#Second parameter (Boolean) sets the return type. TRUE = Object, FALSE = Array\n".
	'$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);'."\n\n".
	
	'$yaml->returnObject(TRUE); #Set the return type to object'."\n".
	'print_r($yaml->get("page"));'."\n\n".
	
	'$yaml->returnObject(FALSE); #Set the return type to array'."\n".
	'print_r($yaml->get("page"));'."\n",TRUE)."
	<h4>Result</h3>";
	$yaml->returnObject(TRUE);
	echo "#Switch to Object<pre>";
	print_r($yaml->get("page"));
	echo "</pre>#Switch to Array<pre>";
	$yaml->returnObject(FALSE);
	print_r($yaml->get("page"));
	echo "</pre>";
echo "</div>

<div class='example'>
	<h3>Errors On/Off</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE); #Third parameter (Boolean) turns errors on/off'."\n".
	'$yaml->setErrors(TRUE); #Turns errors on'."\n".
	'$yaml->setErrors(FALSE); #Turns errors off',TRUE)."
</div>

</div>
</body>
</html>";
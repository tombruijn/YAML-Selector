<?php
require_once("selector.php");
echo "<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<title>Yaml Selector examples</title>
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
		}
	</style>
</head>
<body>";
$i = new YamlSelector("data.yaml");
$yaml = new YamlSelector("example_file.yaml");
echo "
<div class='side'>
	<div class='block'>
		<h2>Example file</h2>
		".highlight_file("example_file.yaml",true)."
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
	<p>Author: ".$i->get("yaml.selector.author")." - ".$i->get("yaml.selector.company")."</p>
	<p>Copyright: ".$i->get("yaml.selector.copyright")."</p>
	<p>Github: ".$i->get("yaml.selector.git")."</p>
</div>
<div class='block'>
	<h2>Usage examples</h2>
</div>

<div class='example'>
	<h3>Example inviroment</h3>
	<p>These variables will be avaliable to the example codes.</p>
	<h4>Code</h4>
	".highlight_string("<?php\n".'$yaml = new YamlSelector("example_file.yaml");',true)."
</div>

<div class='example'>
	<h3>First level selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("version");',true)."
	<h4>Result</h4>
	".$yaml->get("version")."
</div>

<div class='example'>
	<h3>Second level selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("request.time");',true)."
	<h4>Result</h4>
	".$yaml->get("request.time")."
</div>

<div class='example'>
	<h3>Third level selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("setting.date.format");',true)."
	<h4>Result</h4>
	".$yaml->get("setting.date.format")."
</div>

<div class='example'>
	<h3>Array selection</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'print_r($yaml->get("page"));',true)."
	<h4>Result</h4><pre>";
	print_r($yaml->get("page"));
echo "</pre></div>

<div class='example'>
	<h3>Single variable insertion - method one</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("variable.one","Tom");',true)."
	<h4>Result</h4>";
	echo $yaml->get("variable.one","Tom");
echo "</div>

<div class='example'>
	<h3>Single variable insertion - method two</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("variable.one",array("name"=>"Tom"));',true)."
	<h4>Result</h4>";
	echo $yaml->get("variable.one",array("name"=>"Tom"));
echo "</div>

<div class='example'>
	<h3>Multiple variable insertion</h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".'echo $yaml->get("variable.two",array("name"=>"Tom","difference"=>"three days"));',true)."
	<h4>Result</h4>";
	echo $yaml->get("variable.two",array("name"=>"Tom","difference"=>"three days"));
echo "</div>

</div>
</body>
</html>";
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
		}
		p,pre{
			margin: 0px;
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
			margin-right: 360px;
			min-width: 500px;
			background-color: #FFF;
		}
		.example_file{
			position: fixed;
			top: 10px;
			right: 10px;
			float: right;
			width: 330px;
			padding: 10px;
			background-color: #FFF;
			border: 1px solid #CCC;
		}
		.example{
			margin-bottom: 10px;
			padding: 10px 10px 10px 10px;
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
$yaml = new YamlSelector("data.yaml");
echo "<div class='example_file'>
	<h2>Example file</h2>
	".highlight_file("example_file.yaml",true)."
</div>
<div class='content'>
<h1>".$yaml->get("yaml.selector.name")."</h1>
<p>".$yaml->get("yaml.selector.description")."</p>
<h2>Usage</h2>";
$examples = $yaml->get("yaml.selector.example");
foreach($examples as $example){
	echo "<div class='example'><h3>".$example["name"]."</h3>";
	echo "<h4>Code</h4>";
	highlight_string("<?php\n".$example["code"]);
	echo "<h4>Result</h4>";
	echo "<p>".$example["result"]."</p></div>";
}
$e = new YamlSelector("example_file.yaml");
echo "<h2>3rd party library</h2>";
echo "<h3>".$yaml->get("yaml.library.name")."</h3>";
echo "<p>Spyc authors:<ul>";
$authors = $yaml->get("yaml.library.author");
foreach($authors as $k=>$v){
	echo "<li>".$k." (".$v["email"].")</li>";
}
echo "</ul></p>
</div>
</body>
</html>";
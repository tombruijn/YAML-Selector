<?php
require_once("selector.php");
echo "<html>
<head>
	<title>Yaml Selector examples</title>
	<style type='text/css'>
		body{
			margin: 10px;
		}
		p,pre{
			margin: 0px;
		}
		
		h1,h2,h3,h4{
			margin: 0;
		}
	</style>
</head>
<body>";
$yaml = new YamlSelector("data.yaml");
echo "<h1>".$yaml->get("yaml.selector.name")."</h1>";
echo "<p>".$yaml->get("yaml.selector.description")."</p>";
echo "<h2>Usage</h2>";
echo "<h3>Example file</h3>";
highlight_file("example_file.yaml");
$examples = $yaml->get("yaml.selector.example");
foreach($examples as $example){
	echo "<h3>".$example["name"]."</h3>";
	echo "<h4>Code</h4>";
	highlight_string("<?php\n".$example["code"]);
	echo "<h4>Result</h4>";
	echo "<p>".$example["result"]."</p>";
}
$e = new YamlSelector("example_file.yaml");
echo "<h2>3rd party library</h2>";
echo "<h3>".$yaml->get("yaml.library.name")."</h3>";
echo "<p>Spyc authors:<ul>";
$authors = $yaml->get("yaml.library.author");
foreach($authors as $k=>$v){
	echo "<li>".$k." (".$v["email"].")</li>";
}
echo "</ul></p>";
echo "<body></html>";
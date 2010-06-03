<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<title>YAML Selector examples</title>
	<style type='text/css'>
		body{
			margin: 10px 25px 10px 25px;
			font-family: Arial, Verdana;
			font-size: 90%;
			background-color: #eee;
		}
		p,pre{
			margin: 0 0 5px 0;
		}
		ul{
			margin: 0;
			padding: 0 0 0 20px;
			list-style-type: disc;
		}
		h1,h2,h3,h4{
			margin: 0 0 5px 0;
		}
		h1{
			font-size: 24px;
			color: #00a2ff;
			border-bottom: 1px solid #00a2ff;
		}
		h2{
			font-size: 18px;
			color: #FF8A00;
			border-bottom: 1px solid #FF8A00;
		}
		h3{
			font-size: 16px;
			color: #6CADC0;
			border-bottom: 1px solid #6CADC0;
		}
		h4{
			font-size: 12px;
			color: #323232;
		}
		.content{
			margin-right: 370px;
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
			right: 25px;
			float: right;
			width: 330px;
		}
		.example{
			margin-left: 40px;
			margin-right: 40px;
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
require_once("yaml_selector/yaml_selector.php");
$i = new YamlSelector("data.yaml");
$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);
echo "
<div class='side'>
	<div class='block'>
		<h2>Contents</h2>
		<ul>
			<li><a href='#installation'>Installation</a></li>
			<li><a href='#environment'>Example environment</a></li>
			<li><a href='#examples'>Examples</a>
				<ul>
					<li><a href='#example-single'>First level selection</a></li>
					<li><a href='#example-multiple'>Multiple depth selection</a></li>
					<li><a href='#example-array'>Array selection</a></li>
					<li><a href='#example-variable-single'>Single variable insertion</a></li>
					<li><a href='#example-variable-multiple'>Multiple variable insertion</a></li>
					<li><a href='#example-errors'>Intentional errors</a></li>
				</ul>
			</li>
			<li><a href='#config'>Configuration</a>
				<ul>
					<li><a href='#config-returntype'>Multiple level return type</a></li>
					<li><a href='#config-errors'>Errors</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class='block'>
		<h2>Example file</h2>
		".highlight_file("example_file.yaml",TRUE)."
	</div>
	<div class='block'>
		<h2>3rd party library</h2>
		<h3>".$i->get("yaml.library.name")."</h3>
		<p>".$i->get("yaml.library.description")."</p>
		<p>Spyc authors:</p><ul>";
		$authors = $i->get("yaml.library.author");
		foreach($authors as $k=>$v){
			echo "<li>".$k." (".$v["email"].")</li>";
		}
		echo "</ul>
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
	<h2><a id='installation'>Installation</a></h2>
	<ol>
		<li>Download/Unpack the YAML-Selector project.</li>
		<li>Move the \"yaml_selector\" directory to your project.</li>
		<li>Prepare a YAML file.</li>
		<li>In your PHP project use the following code:</li>
	</ol>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'require_once("yaml_selector.php");'."\n".
	'$yaml = new YamlSelector("yourfile.yaml");',TRUE)."<br/>
	<br/>
	<p>What to do from there is your choice! See the examples below to see how YAML Selector works!</p>
</div>

<div class='block'>
	<h2><a id='examples'>Usage examples</a></h2>
	<p>See what functions are available in the YAML Selector class and what they return.</p>
</div>

<div class='block'>
	<h3><a id='environment'>Example environment</a></h3>
	<p>These variables will be avaliable to the example codes. The contents of the example file the code below loads is available to your right. See more about configuration below the examples.</p>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'require_once("yaml_selector.php");'."\n".
	'$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);',TRUE)."
</div>

<div class='example'>
	<h3><a id='example-single'>First level selection</a></h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
		'echo $yaml->get("version");'
	,TRUE)."
	<h4>Result</h4>
	".$yaml->get("version")."
</div>

<div class='example'>
	<h3><a id='example-multiple'>Multiple depth selection</a></h3>
	<p>Use dots to indicate the next level: levelone.leveltwo.levelthree.level#</p>
	<h4>Code</h4>
	".highlight_string("<?php\n".
		'echo $yaml->get("request.time");'."\n".
		'echo $yaml->get("setting.date.format");'."\n"
	,TRUE)."
	<h4>Result</h4>
	".$yaml->get("request.time")."<br/>
	".$yaml->get("setting.date.format")."<br/>
</div>

<div class='example'>
	<h3><a id='example-array'>Array selection</a></h3>
	<p>Return multiple levels. They will be returned as array on default. See the configuration section for more options.</p>
	<h4>Code</h4>
	".highlight_string("<?php\n".'print_r($yaml->get("page"));',TRUE)."
	<h4>Result</h4><pre>";
	print_r($yaml->get("page"));
echo "</pre></div>

<div class='example'>
	<h3><a id='example-variable-single'>Single variable insertion</a></h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'echo $yaml->get("variable.one","Tom"); #Strings only works when there is only one variable'."\n".
	'echo $yaml->get("variable.one",array("name"=>"Michael")); #Replacement by variable name',TRUE)."
	<h4>Result</h4>";
	echo $yaml->get("variable.one","Tom")."<br/>";
	echo $yaml->get("variable.one",array("name"=>"Michael"));
echo "</div>

<div class='example'>
	<h3><a id='example-variable-multiple'>Multiple variable insertion</a></h3>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'echo $yaml->get("variable.two",array("name"=>"Tom","difference"=>"three days"));'."\n".
	'echo $yaml->get("variable.two",array("name"=>"Michael")); #Skipping {{difference}}',TRUE)."
	<h4>Result</h4>";
	echo $yaml->get("variable.two",array("name"=>"Tom","difference"=>"three days"))."<br/>";
	echo $yaml->get("variable.two",array("name"=>"Michael"));
echo "</div>

<div class='example'>
	<h3><a id='example-errors'>Intentional errors - Keys don't exist</a></h3>
	<p>See the configuration section for more options.<p>
	<h4>Code</h4>
	".highlight_string("<?php\n".
	'echo $yaml->get("request.date"); #This key doesn\'t exist'."\n".
	'echo $yaml->get("request.time.something"); #This level doesn\'t exists',TRUE)."
	<h4>Result</h4>";
	echo $yaml->get("request.date");
	echo $yaml->get("request.time.something");
echo "</div>

<div class='block'>
	<h2><a id='config'>Configuration</a></h2>
	<p>Configure the YAML Selector class to your needs.</p>
</div>

<div class='example'>
	<h3><a id='config-returntype'>Multiple level return type</a></h3>
	<h4>Code</h4>
	".highlight_string("<?php\n#Second parameter (Boolean) sets the return type. TRUE = Object, FALSE = Array\n".
	'$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);'."\n\n".
	
	'$yaml->returnObject(TRUE); #Set the return type to object'."\n".
	'print_r($yaml->get("page"));'."\n\n".
	
	'$yaml->returnObject(FALSE); #Set the return type to array'."\n".
	'print_r($yaml->get("page"));'."\n",TRUE)."
	<h4>Result return type object</h4>";
	$yaml->returnObject(TRUE);
	echo "<pre>";
	print_r($yaml->get("page"));
	echo "</pre><h4>Result return type array</h4><pre>";
	$yaml->returnObject(FALSE);
	print_r($yaml->get("page"));
	echo "</pre>";
echo "</div>

<div class='example'>
	<h3><a id='config-errors'>Errors On/Off</a></h3>
	<h4>Code</h4>
	".highlight_string("<?php\n#Third parameter (Boolean) turns errors on/off\n".
	'$yaml = new YamlSelector("example_file.yaml",FALSE,TRUE);'."\n".
	'$yaml->setErrors(TRUE); #Turns errors on'."\n".
	'$yaml->setErrors(FALSE); #Turns errors off',TRUE)."
</div>

</div>
</body>
</html>";
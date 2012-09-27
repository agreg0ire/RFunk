<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>arbrowser</title>
<link type="text/css" rel="stylesheet" href="RFunk.css">
</head>

<h1>arbrowser</h1>
<code><b>string</b> arbrowser( [<b>string</b> root_dir ])</code>
<h2>Description</h2>

This method allows to deploy a  tree type explorer. <br /> 
Indentation related algorithm FILES / FOLDERS OR FILES / FILE is handled automatically by the UL and LI tags. <br /> 
<br /> 
<b> Warning </b>, you must manage yourself changing statements of UL block by playing on their display properties via a JavaScript function <br /> 
You also make the images "+" and "-" corresponds to the state or not deployed to a folder. <br /> 
By default the method deploys the menu from the current directory.
<h2>Example</h2>
<div class="doc-source">
<pre><code>

$o_rfunk=new RFunk;
	
$s_menu_arborescent=$o_rfunk-&gt;();



</code></pre>
</div>
<hr style="margin-top:1.5em">
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>

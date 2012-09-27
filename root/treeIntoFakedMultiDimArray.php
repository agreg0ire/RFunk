<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>treeIntoFakedMultiDimArray</title>
<link type="text/css" rel="stylesheet" href="RFunk.css">
</head>

<h1>treeIntoFakedMultiDimArray</h1>
<code><b>mixed</b> treeIntoFakedMultiDimArray( [<b>string</b> root_dir])</code>
<h2>Description</h2>
This "strange" method (its finality)
returns a multidimensional array corresponding to the tree of your folders / files <br /> 
To do this, a pseudo array is constructed in a string which is then evaluated with the eval(); funk internally before being returned. <br /> 
The method starts from the execution directory by default.

<h2>Example</h2>
<div class="doc-source">
<pre><code>

$o_rfunk = new RFunk;

if(is_array($m_output = @$o_rfunk-&gt;()))
{

	echo $o_rfunk-&gt;($m_output);


}else{ echo 'There were no files and subfolders from the directory of execution! '; }


</code></pre>
</div>
<hr style="margin-top:1.5em" />
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>
	
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>dump</title>
<link type="text/css" rel="stylesheet" href="RFunk.css">
</head>
<h1>dump</h1>
<code><b>string</b> dump( <b>var</b>)</code>
<h2>Description</h2>

This method is a mixture (improved) functions var_dump () and print_r (); 
<br /> 

- It provides a classification for color depending on the type of
variable. <br /> 
- It manages indentation for ul and li foreach multidimensional array found<br /> 
- Each array is clickable  to show or hide its content. <br /> 
<br /> 
Unlike var_dump () and print_r (), the function returns a string 
but without displaying it, <br /> 
it is therefore up to you to display it!

<h2>Exemple</h2>
<div class="doc-source">
<pre><code>

$a_test=array('pouet',1,false,array('test',2,true),'fin');

echo $o_rfunk-&gt;($a_test);

</code></pre>
</div>
<h2>Voir</h2>

<a href="treeIntoFakedMultiDimArray.htm">treeIntoFakedMultiDimArray()</a>

<hr style="margin-top:1.5em">
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>
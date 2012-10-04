<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>simpleRSort</title>
<link type="text/css" rel="stylesheet" href="RFunk.css" />
</head>

<h1>simpleRSort</h1>
<code><b>mixed</b> simpleRSort( <b>array</b> disordered_haystack)</code>
<h2>Description</h2>

This method is the last one made in date. <br /> <br /> 

This is a simplified alias of the php native sort(); funk. <br /> 
But it handles imbricated array and output them in an other one.<br /> 
<br /> 
The method dies if it finds identic values in a same array, it does not handle float values but round them by default.<br /> 
It does not handle objects type variables and resources.

<h2>Example</h2>
<div class="doc-source">
<pre><code>

$o_rfunk = new RFunk;

echo $o_rfunk-&gt;dump($o_rfunk-&gt;simpleRSort($o_rfunk-&gt;treeIntoFakedMultiDimArray()));

</code></pre>
</div>



<hr style="margin-top:1.5em"/>
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>

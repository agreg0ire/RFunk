<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>xmlRParse</title>
<link type="text/css" rel="stylesheet" href="RFunk.css">
</head>

<h1>xmlRParse</h1>
<code><b>mixed</b> xmlRParse( <b>string</b> path_to_an_xml_file)</code>
<h2>Description</h2>

This method displays the structure of any xml tree in a html view. <br /> 
It manages those possible structures of nodes: <br /> 
- Empty and without attributes <br /> 
- With children and with attributes <br /> 
- Empty with attributes <br /> 
- With children and no attributes <br /> <br /> 

As the signature of the method uses 2 internal parameters (one for the path pointing to the xml, the second pass for each new child node), <br /> 
  you need to shut up the warning when calling the method! <br /> 
The method returns a string of character if all went well or false, if the xml is malformed! 

<h2>Example</h2>
<div class="doc-source">
<pre><code>

$o_rfunk = new RFunk;

if(is_string($m_output = @$o_rfunk-&gt;xmlRParse('some_file.xml')))
{
	echo $m_output;

}else{ echo 'Check your XML structure!'; }


</code></pre>
</div>
<hr style="margin-top:1.5em" />
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>delEmptyDirs</title>
<link type="text/css" rel="stylesheet" href="RFunk.css" />
</head>
<?php include('../easyTrad/headerTrad.php'); ?>
<h1>delEmptyDirs</h1>
<code><b>mixed</b> delEmptyDirs( [, <b>string</b> root_dir ])</code>
<h2>Description</h2>
Remove all empty folders from the directory specified in the parameter of the method. 
<br /> <br /> 
This method internally call getDirsPaths (); and then rmParentDir (); to delete empty folders <br /> 
which can be themselves in empty folders! 

<h2>Example</h2>
<div class="doc-source">
<pre><code>$o_rfunk-&gt;delEmptyDirs(getcwd());</code></pre>
</div>
is preferable to
<div class="doc-source">
<pre><code>$o_rfunk-&gt;delEmptyDirs('.');</code></pre>
</div>
or to

<div class="doc-source">
<pre><code>$o_rfunk-&gt;delEmptyDirs();</code></pre>
</div>

<h2>See</h2>
<a href="getFilesPaths.htm">getFilesPaths()</a> <a href="rmParentDir.htm">rmParentDir()</a>.
<hr style="margin-top:1.5em"/>
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>

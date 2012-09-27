<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>joinFilesInOneFolder</title>
<link type="text/css" rel="stylesheet" href="RFunk.css">
</head>

<h1>joinFilesInOneFolder</h1>
<code><b>mixed</b> joinFilesInOneFolder(<b>string</b> root_dir , <b>string</b> dest_dir [, <b>boolean</b> cut ] )</code>
<h2>Description</h2>

Join all files from a tree to a single destination directory. 
<br /> 
Make sure your paths pointing to directories of valid! 
<br /> <br /> 
By default the method moves the files because to give you an idea: <br /> <br /> 
PHP <b> takes about 10 seconds to copy a 100 MB file while it is almost instantaneous 
move a file of that weight </b> 
<br /> <br /> 
If one or more copies, displacement fails an array with the path of each file in error will be returned 
otherwise TRUE is returned. <br /> 

<h2>Example</h2>
<div class="doc-source">
<pre><code>

$m_retour=$o_rfunk-&gt;joinFilesInOneFolder('c;\documents and settings\pouet\bureau',getcwd().RFunk::DS.'dir_dest', false);

if(is_bool($m_retour))
{
	echo 'The joinning of your files has worked well';
	
}elseif(is_array($m_retour))
{
	echo 'Attention';

	foreach($m_retour as $i_key => $s_value)
	{
		echo '&lt;br /&gt;This file could not have been copied or moved =&gt; '.$s_value;
	}
}
</code></pre>
</div>
<h2>See</h2>
<a href="separateFilesByMaxSize.htm">separateFilesByMaxSize()</a>
<hr style="margin-top:1.5em">
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>

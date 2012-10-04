<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>translateBigText</title>
<link type="text/css" rel="stylesheet" href="RFunk.css" />
</head>

<h1>delEmptyDirs</h1>
<code><b>mixed</b> translateBigText( <b>string</b> text_src, <b>integer</b> limit_text_char, <b>string</b> acronym_language)</code>
<h2>Description</h2>

This method is the last one made in date. It translate an english text to another language * <br />
Each paramater is obligatory<br /><br />
The methods internally stripslashes if MGC are on, replace all spaces (\s) and replace special chars<br />
like \r\n and "&". So you don't need to do it before calling the funk.<br /><br />
Namely that the method uses the google translation API in order to make the translation which has
a limit of 1960 characters (approximately) for one translated text.<br />
So if the length exceed the limit, the funk splits the text and recursively handle the next sections...<br />

You can immediately try this method because this is the one used if you try to translate this page !!!
<br /><br />

* Attention : cyrillic and asiatic alphabet are not handled !

<h2>Example</h2>
<div class="doc-source">
<pre><code>

$o_rfunk = new RFunk(100);

echo $o_rfunk->translateBigText($_POST['s_the_string'], 1950, 'fr');

</code></pre>
</div>


<h2>See</h2>
<a href="getFilesPaths.htm">getFilesPaths()</a> <a href="rmParentDir.htm">rmParentDir()</a>.
<hr style="margin-top:1.5em"/>
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>

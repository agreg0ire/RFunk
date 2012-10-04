<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Manuel de r&eacute;f&eacute;rence de RFunk</title>
<link type="text/css" rel="stylesheet" href="RFunk.css">
<style>
#main_top{ width:1200px; }

#left_top{ width:400; float:left;}

#right_top{ width:795; float:left; padding-top:100px; }
</style>
</head>
<div id="main_top">

	<div id="left_top">
		<h1>RFunk Class (requires &gt;=Php5)</h1>
		<br />
		<br />
		<h2><u>Constants</u></h2>
		<a href="DS.htm">RFunk::DS</a> - alias of DIRECTORY_SEPARATOR<br />
		<a href="RN.htm">RFunk::RN</a> - New line character <br /> 

		<h2><u>Properties</u></h2>

		<a href="i_diviseur_mo.htm">i_diviseur_mo</a> - octet to mega-octet conversion

		<h2><u>Private Methods</u></h2>

		<a href="indent.htm">indent</a> - repeats a given character<br>
		<a href="strrchr2.htm">strrchr2</a> - adaptation of strrchr();<br>
	</div>
	
	<div id="right_top">
		<h2><u>Public Methods</u></h2>
<?php

include('../RFunk.php');
 
$o_rfunk = new RFunk;

foreach(get_class_methods(get_class($o_rfunk)) as $i_key => $s_method_name):

	
	if(file_exists($s_method_name.'.php'))
	{
		echo '<br /> <a href="'.$s_method_name.'.php">'.$s_method_name.'</a>';
		
	}else echo '<br /> <a href="'.$s_method_name.'.htm">'.$s_method_name.'</a>';

endforeach; 

?>
		<br />
	</div>
<a href="#" onclick="document.getElementById('pate').style.display='block';"> Display the class !</a>
<div id="pate" style="display: none;">
<br />
<br />
<?php highlight_file('../RFunk.php'); ?>
</div>
</div>
</body>
</html>
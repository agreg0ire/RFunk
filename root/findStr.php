<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="../easyTrad/translationFunk.js" ></script>
<title>findStr</title>
<link type="text/css" rel="stylesheet" href="RFunk.css" />
</head>
<h1>findStr</h1>
<code><b>mixed</b>	 findStr( <b>string</b> root_dir ,  <b>string</b> searched_pattern <b>array</b> ext_ascii_files ,[, <b>boolean</b> casse_sensitive [, <b>boolean</b> num_line [, <b>boolean</b> by_regexp ]]])</code>
<h2>Description</h2>

Performs a string search  specified by "searched_pattern" in the file extensions "ext_ascii_files. 
<br /> 
If there were a matching word, a multidimensional array is returned containing all of the line with the words in bold. 
<br /> 
If nothing is found, FALSE is returned. 
<br /> 
<br /> 
<b> Warning </b> The third parameter must be an array or an error will be generated. <br /> 
In addition, the separator character point of the file name and extension should not be included in the extension. 
<br /> 
<br /> 
The method performs a search by default case insensitive. 
<br /> 
<br /> 
If the character is found, the line number in the file may be indicated. <br /> 
You can first call <b> getAllExts ();</b> to know what file extensions are present 
from your folder directory. <br /> 
<br /> <br /> 
For obvious HTML displaying reasons,  "&gt; &lt;" tags embedded in html, xml and php or the syntax of mail, will be replaced by underscores "_". 
<br /> 
<br /> 
Finally, <b> any  JOKER string  </b> of regular expressions: *, (,) [,], |, ^,?, \, $, (,), # ,., - <br /> 
will be escaped when preg_replace () internally if you selected a search by RegExp. <br /> 
Nonethelses it is up to you to escape when they come from just outside if the search does not come through <br /> 
regular expression, and thus have no bad surprise!
<h2>Example</h2>
<div class="doc-source">
<pre><code>

if(isset($_POST['sub']))
{
	$s_double_antislash=str_replace('\\', str_repeat('\\', 2), $_POST['searched_pattern']);
									
	$a_jokers_chars=array('*','(',')','[',']','+','|','^','?','$','-','.', '{','}','#');
								
	$a_escape_jokers=array('\*','\(','\)','\[','\]','\+','\|','\^','\?','\$','\-','\.','\{','\}','\#');
												
	$s_clean_metacar=str_replace($a_jokers_chars,$a_escape_jokers, $s_double_antislash);
	
	
	
	$m_retour=$o_rfunk->findStr2($s_del_last_slash, $s_clean_metacar, array('xml,'txt','csv','php'));
									
	if(is_array($m_retour))
	{
		$i_count_total_results=0;
	
		echo '&lt;u&gt;Temps de la recherche : '.(time() - $i_time_exec).' seconde(s)&lt;u&gt;';
	
	
		foreach($mda_with_num_line as $s_key => $a_value):
		
			echo 'Voici le(s) résultat(s) trouvé(s) pour le fichier =>'.$s_key;
			
				foreach($a_value as $i_key => $s_value):
				
					$i_count_total_results++;
				
					echo '&lt;br /&gt;Ligne '.$i_key.' '.$s_value;
					
				endforeach;
		
		
		endforeach;	
		
		echo '&lt;br /&gt;Nombre total de lignes où il y a eu un ou plusieurs résultats : '.$i_count_total_results.'';
		
										
	}elseif(is_bool($m_retour))
	{ 
										
		echo 'La recherche n a donné aucun résultat.'; 
									
									
	}else{ echo 'VALEUR DE RETOUR IMPEVUE'; }
	
	


}
</code></pre>
</div>
<font color="green">Batch equivalent.</font>

<div class="doc-source">
<pre><code>

for /R "c:\wamp\www\test" %%s in (*.txt *.xml *.html *.php *.js *.css) do findstr /I /N "function"  %%s 

</code></pre>
</div>
<h2>Voir</h2>
<a href="getAllExts.htm">getAllExts()</a>
<a href="getFilesPaths.htm">getFilesPaths()</a>

<hr style="margin-top:1.5em">
<div style="text-align:center"><a href="index.php">Index</a></div>
</body>
</html>

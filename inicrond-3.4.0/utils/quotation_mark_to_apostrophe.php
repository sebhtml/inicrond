<?php
//$Id: quotation_mark_to_apostrophe.php 143 2006-08-17 22:34:17Z sebhtml $

//this script will find a string in quotation marks and  will convert it to a string in apostrophe



function modify_stuff($dir)
{
global $_OPTIONS, $words_to_replace;

echo "opendir $dir"."\n";
$fp = openDir($dir);
	echo "readdir $dir"."\n";
	while($fichier = readDir($fp))
	{
	
		if(is_file($dir."/".$fichier) AND
		!is_dir($dir."/".$fichier) AND
		$fichier != "grep_php" AND
		//$fichier != "options_inc.php" AND
		
		//$fichier != "insert.sql" AND
		//$fichier != "create.sql" AND
		//$fichier != "drop.sql" AND
		$fichier != "tables.php" AND
		
		$fichier != ".." AND
		$fichier != "." AND
		$fichier != ".directory" AND
		//$fichier != "CVS" AND//I can not edit CVS files.
		fileSize($dir."/".$fichier) != 0
		  )
		{
		echo "opening in r ".$dir."/".$fichier."-"."\n";
		$fp2 = fopen($dir."/".$fichier, "r");
	echo "fread ".$dir."/".$fichier."\n";
		$contenu = fread($fp2, fileSize($dir."/".$fichier));
		echo "closing ".$dir."/".$fichier."\n";
		fclose($fp2);
		
		
		 
		//////////////////////////////////////////////


/*
characters in a string : a-zA-Z0-9_-/ \.
*/
$contenu = preg_replace(
	'/"([a-zA-Z0-9_\-\.\/?&=]+)"/',
	'\'$1\'',
	$contenu
	);


				
				
				/////////////////////////////////////////////
		
		echo "opening in w+ ".$dir."/".$fichier."\n";
		$fp2 = fopen($dir."/".$fichier, "w+");
		
		echo "writing ".$dir."/".$fichier."\n";
		fwrite($fp2, $contenu);
	echo "closing ".$dir."/".$fichier."\n";
		fclose($fp2);
		}
		elseif(is_dir($dir."/".$fichier ) AND
		$fichier != ".." AND 
		$fichier != "." 
		)
		{
		modify_stuff($dir."/".$fichier);//appele récursif...
		//echo $dir."/".$fichier."\n";
		}
	}
	echo "closing ".$dir."\n";
closeDir($fp);	

}


//$count = 0;

modify_stuff("src");




?>
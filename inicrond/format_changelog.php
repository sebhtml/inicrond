<?php

/*
2005-06-29  sebhtml

	* The online marks string have been updated.

*/
	
//this script remove transform the thing...
	
//use this way : format_changelog.php  <filename>

//the string is saved in changelog.
/*
foreach($argv AS $key => $argument)
{
	if($argument == "--input")
	{
	$file = $argv[$key+1];
	
	}


}*/

$file= 'ChangeLog';

$fp = fopen($file, 'r');
$content = fread($fp, filesize($file));
fclose($fp);

/*
firest replace the date to the star by the author name.
*/

$content = preg_replace(
"/[0-9]{4}-[0-9]{2}-[0-9]{2}[ ]{2}([a-zA-Z0-9]+)\n\n\t\*/Ums",
"$1",
$content
);

//then, swtich the name and the string...
//the name is the first word...


$content = preg_replace(
"/^([a-z0-9]+) (.+)$/Ums",
"* $2 ($1)",
$content
);

//replace double line break by one.
$content = preg_replace(
"/\n\n/Ums",
"\n",
$content
);

$fp = fopen($file.'.txt', 'w');
fwrite($fp, $content);
fclose($fp);

?>

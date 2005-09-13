<?php
//$Id$

/*
//---------------------------------------------------------------------
//

//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisvert

http://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

//
//---------------------------------------------------------------------
*/
foreach($argv AS $key => $argument)
{
	if($argument == "--string" AND
	isset($argv[$key+1])
	)
	{
	$new_string = $argv[$key+1];
	
	}
	elseif($argument == "--help")
	{
	echo "
ARGUMENTS

--string <string_to_Add>

--help
";
	exit();
	}


}

if(!isset($new_string))
{
die("please use --help or --string");
}
$dir_to_open = ".";

$fp = openDir($dir_to_open);

while($lang = readDir($fp))
{
$lang_file = $lang."/lang.php";

	if(is_file($lang_file))//add it in here
	{
	$content = file_get_contents($lang_file);
	
	$content = preg_replace(
	"/\?>$/",
	"\$_LANG[\"$new_string\"] = \"$new_string\";//to translate\n?>",
	$content);
	
	file_put_contents($lang_file, $content);//write it down.
	}

}
?>
<?php
error_reporting(E_ALL^E_NOTICE);
//$Id$
 

/*
//---------------------------------------------------------------------
//
//

//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------
*/
/*
inicrond
Copyright (C) 2004  Sebastien Boisvert

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
*/
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', "");

session_start();

$_SESSION['language'] = 'en-ca';

include __INICROND_INCLUDE_PATH__."modules/admin/includes/languages/".$_SESSION['language'].'/lang.php';//language.
include __INICROND_INCLUDE_PATH__.'includes/languages/'.$_SESSION['language'].'/lang.php';//language.


if(!$_GET['language'])//choose the lamnguage
{
include __INICROND_INCLUDE_PATH__."includes/etc/compiled/available_langs.php";
	
echo $_LANG['choose_the_language_for_the_installation']."<br />";
	foreach($_OPTIONS['languages'] AS $language)
	{
	echo "<a href=\"?language=$language\">$language</a><br />";
	}
}
else
{

$_SESSION['language'] = $_GET['language'];

include __INICROND_INCLUDE_PATH__."modules/admin/includes/languages/".$_SESSION['language'].'/lang.php';//language.
include __INICROND_INCLUDE_PATH__.'includes/languages/'.$_SESSION['language'].'/lang.php';//language.



include __INICROND_INCLUDE_PATH__."includes/etc/files.php";

include __INICROND_INCLUDE_PATH__."includes/functions/file_functions.php";





if(is_file($_OPTIONS["file_path"]["db_config"]))
{
die($_LANG['already_installed']);
exit();
}

//--------------------------------
// Install
//-----------------------------------
/*
* add $_OPTIONS["sql_server_port"]
* add $_OPTIONS['sql_server_persistency']
*/
$install_values = array(
'sql_server_name' => ":/var/run/mysql/mysql.sock",
'sql_user_name' => "sebhtml",
'sql_user_password' => "sebhtml",
'sql_database_name' => "inicrond",
'table_prefix' => "ooo_",
'SGBD' => "MySQL",
'sql_server_persistency' => "TRUE",
'usr_name' => "root",
'usr_password' => "",
'usr_email' => "root@localhost.localdomain"
);


if(!isset($_POST["submit"]))//show the form
{

echo "<form method=\"POST\"><p align=\"center\">
<table border =\"1\" >";

  $keys = array_keys($install_values);

  $count_keys = count($keys);

  	for($i=0;$i< $count_keys;$i++)
  	{
     echo "<tr><td bgcolor=\"#adefbc\"  align=\"center\" >".$_LANG[$keys[$i]]."</td/><td bgcolor=\"#bdefbc\"><input type=\"text\" name=\"".$keys[$i]."\"  value=\"".$install_values[$keys[$i]]."\" /></td></tr>";
	}

	echo "<tr><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"submit\"  value=\"".$_LANG['validate']."\" />	  </td></tr></table></p></form>" ;
}
else
{

echo "<b>".$_LANG['post_installation_message']."</b>";
//-------------------------
//variables de session
//-----------------------

  $keys = array_keys($install_values);

$config_content = "<?php

if(__INICROND_INCLUDED__)
{

";


for($i = 0 ; $i < 6 ; $i ++)//mysql server, mysql user, mysql password, mysql database, mysql prefix, SGBD
{

 $config_content .= "\$_OPTIONS['".$keys[$i]."'] = '".$_POST[$keys[$i]]."';\n";
}
for($i = 6 ; $i < 7 ; $i ++)//mysql server, mysql user, mysql password, mysql database, mysql prefix, SGBD
{

 $config_content .= "\$_OPTIONS['".$keys[$i]."'] = ".$_POST[$keys[$i]].";\n";
}
$config_content .= "
}

?>";

USER_file_put_contents($_OPTIONS["file_path"]["db_config"], $config_content);


//-----------------------------
//Inclusions
//------------------------
include "includes/functions/sql_file_parser.function.php" ;

//--------------------------
//inclusion
//----------------------------

include "modules/admin/includes/kernel/update_config.php";//cr�r les fichiers.

echo $module_content;//contenu.

include "includes/kernel/db_init.php";

$AVAILABLE_SQL_FILES = array(
"drop.sql", 
"create.sql", 
"insert.sql");

foreach($AVAILABLE_SQL_FILES AS $file_name)
{
echo "<table bgcolor=\"#DFDFFE\" width=\"100%\"><tr><td><br />$file_name<br />";

$fp = openDir($_OPTIONS["file_path"]["mod_dir"]);

	while($module_name = readDir($fp))
	{

echo "<table bgcolor=\"#FEFDEF\" width=\"100%\"><tr><td>";


	$module_path = "modules/$module_name";
	$sql_path = "$module_path/sql";

echo $sql_path."<br />";

	if(is_dir("modules/$module_name") AND
	is_dir($sql_path))
	{
echo "<table bgcolor=\"#ADEFDF\" width=\"100%\"><tr><td>";

		$file_path = "$sql_path/".$_OPTIONS['SGBD']."/".$file_name;

			if(is_file($file_path) )
			//droping is not functionnal...
			{
		echo "<table bgcolor=\"#EEEDEF\" width=\"100%\"><tr><td>";
			echo sprintf($_LANG["file_path_was_found"], $file_path)."<br />";
			
		
			$sql = USER_file_get_contents($file_path);
		


			$sql = trim($sql);			
						
			foreach($_OPTIONS['tables'] AS $key => $value)
			{
				
				if($file_name == "create.sql")
				{
			 $sql = preg_replace(
			"/CREATE( |\n)+TABLE( |\n)+".$key."( |\n)+/m",
			 "CREATE TABLE ".$_OPTIONS['table_prefix'].$value, 
			 $sql);
			 
			  $sql = preg_replace(
			"/CREATE( |\n)+TABLE( |\n)+`".$key."`( |\n)+/m",
			 "CREATE TABLE `".$_OPTIONS['table_prefix'].$value."`", 
			 $sql);
			
			  	}
				elseif($file_name == "insert.sql")
				{
			 
			 $sql = preg_replace(
			 "/INSERT( |\n)+INTO( |\n)+".$key."( |\n)+/m",
			 "INSERT INTO ".$_OPTIONS['table_prefix'].$value,
			  $sql);
			  
			   $sql = preg_replace(
			 "/INSERT( |\n)+INTO( |\n)+`".$key."`( |\n)+/m",
			 "INSERT INTO `".$_OPTIONS['table_prefix'].$value."`",
			  $sql);
			  	}
			}

			$sql = preg_replace("/#.{0,}\n/", "", $sql);//remove the remarks
			$sql = sql_parser_split_queries($sql);
			
			
				foreach($sql AS $query)
				{
			echo "<table bgcolor=\"#ABCDFF\" width=\"100%\"><tr><td>";
			
			$inicrond_db->Execute($query);
			echo nl2br($query);
			echo "</td></tr></table><br />";	
				}	

			echo "</td></tr></table>";
			}
			
		echo "</td></tr></table>";	
		}
		
	
echo "</td></tr></table>";
	}
	
	
closeDir($fp);


echo "</td></tr></table>";
}

//add the administrator...
	include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["sql_tables"] ;
	//insert l'utilisateur
	$query = "INSERT INTO
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']." 
	(
	usr_name,
	usr_md5_password,

	usr_add_gmt_timestamp,
	usr_email,
	SUID,
	usr_activation
	)
	VALUES
	(
	'".$_POST['usr_name']."',
	'".md5($_POST['usr_password'])."',

	".mktime().",
	'".$_POST['usr_email']."',
	'1',
	'1'
	)
	;";

	$inicrond_db->Execute($query);

	
 
 
echo $_LANG['installation_completed'] ."<br />";








}

}//end of the else for session language checking.


?>

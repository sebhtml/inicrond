<?php
//$Id$
/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : crÃ©aer le fichier config_inc.php et fait des query sql pour initialiser
le site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
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
$_OPTIONS["INCLUDED"] = 1;

include "includes/etc/files.php";

if(!is_file($_OPTIONS["file_path"]["db_config"]) OR TRUE)
{

	



//-------------------------
//demarrage de la session
//--------------------------

//--------------------------------
// Install
//-----------------------------------
$txt_install = array(
"sql_server_name" => "Serveur",
"sql_user_name" => "Utilisateur",
"sql_user_password" => "Mot de passe",
"sql_database_name" => "Base",
"table_prefix" => "Pr&eacute;fixe des tables",
"SGBD" => "SGBD",
"addr" => "adresse virtuelle"
);


$install_values = array(
"sql_server_name" => "darkstar",
"sql_user_name" => "root",
"sql_user_password" => "",
"sql_database_name" => "inicrond",
"table_prefix" => "OOO_",
"SGBD" => "mysql",
"addr" => "http://darkstar/html/inicrond-2.19.9"
);


if(!isset($_POST["submit"]))
{




echo "<form method=\"POST\">
<table border =\"0\" >
  <tbody>";

  $keys = array_keys($txt_install);

  $count_keys = count($keys);

  	for($i=0;$i< $count_keys;$i++)
  	{
     echo "<tr> <td >".$txt_install[$keys[$i]]."<td /><td ><input type=\"text\" name=\"$keys[$i]\"  value=\"".$install_values[$keys[$i]]."\" /><td /> </tr>";
	}

	echo " <tr>
      <td colspan=\"2\">	  <input type=\"submit\" name=\"submit\"  value=\"ok\" />	  </td>
	 </tr>
   </tbody>
	</table  >
</form>" ;
}
else
{
//-------------------------
//variables de session
//-----------------------


$config_content = "<?php

if(isset(\$_OPTIONS[\"INCLUDED\"]))
{

";

$keys = array_keys($txt_install);

  $count_keys = count($keys);

  for($i=0;$i< $count_keys;$i++)
  {
     $config_content .= "\$_OPTIONS[\"".$keys[$i]."\"] = \"".$_POST[$keys[$i]]."\";
";
}



$config_content .= "
}

?>";


$fp = fopen($_OPTIONS["file_path"]["db_config"],"w+");
fwrite($fp, $config_content);
fclose($fp);


//-----------------------------
//Inclusions
//------------------------
include("includes/func/sql_file_parser.function.php");

//--------------------------
//inclusion
//----------------------------

include "includes/kernel/update_config.php";//créer les fichiers.

include "includes/kernel/db_init.php";

$sql_files = array(
"drop.sql", 
"create.sql", 
"insert.sql");

foreach($_OPTIONS["modules_dir"] AS $module_name)
{
echo "<br />";
echo "<table bgcolor=\"#DFDFFE\" width=\"100%\"><tr><td>";

echo "<table bgcolor=\"#FFDFFF\" width=\"100%\"><tr><td>";
echo "installing module \"$module_name\" [OK]<br />";
echo "</td></tr></table>";

	$module_path = "modules/$module_name";
	$sql_path = "$module_path/sql";
	
echo "<table bgcolor=\"#FEFDEF\" width=\"100%\"><tr><td>";
	if(is_dir($sql_path))
	{

	echo "sql files detected... [OK]<br />";
	
	echo "loading table names... [OK]<br />";
		foreach($sql_files AS $file_name)
		{
		echo "<br />";
		echo "<table bgcolor=\"#EEEDEF\" width=\"100%\"><tr><td>";
		$file_path = "$sql_path/".$_OPTIONS["SGBD"]."/".$file_name;
		echo "looking for $file_path in the module dir... [OK]<br />";
		
			if(is_file($file_path))
			{

			echo "$file_path was found... [OK]<br />";
			
			$fp = fopen($file_path, "r");
			$sql = fread($fp, 65536);
			fclose($fp);


			$sql = trim($sql);			
						


			foreach($_OPTIONS["tables"] AS $key => $value)
			{
			$sql = preg_replace("/CREATE( |\n)+TABLE( |\n)+".$key."( |\n)+/mU",
			 "CREATE TABLE ".$_OPTIONS["table_prefix"].$value, 
			 $sql);
			 
			 $sql = preg_replace(
			 "/DROP( |\n)+TABLE( |\n)+IF( |\n)+EXISTS( |\n)+".$key."( |\n)+/mU",
			 "DROP TABLE IF EXISTS ".$_OPTIONS["table_prefix"].$value,
			  $sql);
			 
			 $sql = preg_replace("/INSERT( |\n)+INTO( |\n)+".$key."( |\n)+/mU",
			 "INSERT INTO ".$_OPTIONS["table_prefix"].$value,
			  $sql);
}

			$sql = sql_parser_split_queries($sql);
			
			
				foreach($sql AS $query)
				{
					
			echo "<br />";
			echo "<table bgcolor=\"#ABCDFF\" width=\"100%\"><tr><td>";
				echo nl2br($query);
			

			
				$mon_objet->query($query);
				echo "</td></tr></table>";	
				}	

			
			}
			else
			{
			echo "$file_path was not found... [OK]<br />";
			}
			echo "</td></tr></table>";	
		}
	
	

	}
	else
	{
	echo "no sql for this module [OK]<br />";
	}
	
	echo "</td></tr></table>";
echo "module \"$value\" installed [OK]<br />";

echo "</td></tr></table>";
}


 
 
echo "installation completed, check for error warnings... [OK]<br />";



}

}
?>

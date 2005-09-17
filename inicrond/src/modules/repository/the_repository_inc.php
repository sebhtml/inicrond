<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : le main du calendar
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


*/
include "modules/repository/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(isset($_OPTIONS["INCLUDED"]))//sécurité.
{


//titre
$module_title = retourner_titre(
array(
$_LANG["45"]["titre"]
)
, $_OPTIONS["separator"],
$_OPTIONS["titre"]);

if(!isset($_GET["path"]))
{
$_GET["path"] = "";

}


$module_content = "";
if(strstr($_GET["path"], ".."))
{
$module_content .= $_LANG["45"]["error"];
}
elseif(is_dir($_OPTIONS["repository_dir"]."/".$_GET["path"]))
{

	$dir_pointor = openDir($_OPTIONS["repository_dir"]."/".$_GET["path"]);

	$tableau = array();
	
	while($file = readDir($dir_pointor))
	{
	
	
		if($file != "." AND $file != "..")
		{
		
			$file2 = $_OPTIONS["repository_dir"]."/".$_GET["path"]."/".$file;
			//$module_content .= $file2."<br />";
			//$module_content .= $file."<br />";
			if(is_file($file2))
			{
			$tableau []= array(retournerHref(
			$_OPTIONS["addr"]."/"."$file2",
			$file));
			
			}
			elseif(is_dir($file2))
			{
			$tableau []= array(retournerHref("?module_id=45&path=".
			$_GET["path"]."/".$file,
			$file));
			}
			else
			{
			
			$module_content .= $file ;
			
			}
	
		}
	
	}
	
	//     /modules
	
	//echo $_GET["path"];
	
	 $tableau []= array(retournerHref("?module_id=45&path=".
			preg_replace("/\/[^\/]+$/", "", $_GET["path"]),
			"..") );
	
	$module_content .= retournerTableauXY($tableau);

}
else
{
$module_content .= $_LANG["45"]["error"];
$module_content .= "9";

}




}
			
			
		
?>
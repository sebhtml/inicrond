<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : les lien pour l'utilisateur
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
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

$layout_contenu = "";



//pas de session
if (!isset($_SESSION["sebhtml"]["usr_id"]))
{


include "includes/layout/login_inc.block.php";

$tableau = array(
7,//inscription
14//oublier password
);
	foreach($tableau AS $value)
	{
	$layout_contenu .= retournerHref("?module_id=$value", $_LANG["common"]["$value"]);
	$layout_contenu .= "<br />";
	}
}

//menu des membres en général
else
{
	
$layout_contenu .= retournerHref("?module_id=4&usr_id=".$_SESSION["sebhtml"]["usr_id"],
$_SESSION["sebhtml"]["usr_name"]);

	$layout_contenu .= "<br />";
	
	$layout_contenu .= retournerHref("?end&redirect=".
	base64_encode($_SERVER["QUERY_STRING"])."", $_LANG["common"]["3"]);
	$layout_contenu .= "<br />";

	//print_r($_SERVER);
	
	$layout_contenu .= retournerHref("?module_id=11", $_LANG["common"]["11"]);
	$layout_contenu .= "<br />";
		

	
	//menu des admins
	 if( is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet))
	{	
	//$layout_contenu .= "<br />";
		$layout_contenu .= "<br />";
		
	//$layout_contenu .= "<br />";
	//options
	$layout_contenu .= retournerHref("?module_id=34", $_LANG["common"]["34"]);
	
	$layout_contenu .= "<br />";
	//valider utilisateur
	$layout_contenu .= retournerHref("?module_id=9", $_LANG["common"]["9"]);
	$layout_contenu .= "<br />";
	//$layout_contenu .= retournerHref("back_up.php?mode_id=0", $_LANG["txt_inter"]["back_drop"]);
	//$layout_contenu .= "<br />";
	//$layout_contenu .= retournerHref("back_up.php?mode_id=1", $_LANG["txt_inter"]["back_delete"] );
		
	//$layout_contenu .= "<br />";
	//db_restore
	//$layout_contenu .= retournerHref("?module_id=19", "2");//echoLienModule(19);
	//online ppl
	//$layout_contenu .= "<br />";
	//$layout_contenu .= retournerHref("?module_id=29", $_LANG["modules/admin/set/visits_inc.php"]["titre"] );
	}//fin du menu des admins
}

?>

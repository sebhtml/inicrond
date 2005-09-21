<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : groupes
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
include "modules/groups/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}








$elements_titre = array(
$_LANG["21"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);
	
	if(is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet))
	{
//add groupe
	$module_content .= "<br />";
	$module_content .= retournerHref("?module_id=20&mode_id=0", $_LANG["20"]["add"] );
	}
			$queries["SELECT"] ++; // comptage
		
		$query = "SELECT 
		group_id, group_name
		 FROM 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
		  ORDER BY group_name ASC;";

		$query_result = $mon_objet->query($query);

		$tableau = array();
		
		$tableau []= array($_LANG["22"]["groupe"]);
		
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{
		$tableau []= array(retournerHref("?module_id=22&group_id=".$fetch_result["group_id"]."", 
		$fetch_result["group_name"]));
		/*
		$group_name = $fetch_result["group_name"];
		$group_id = $fetch_result["group_id"];
			*/	
		/*
		$module_content .= retournerHref("?module_id=22&group_id=$group_id", $group_name);
		*/
		//$module_content .= "<br />";
		}
		
		$module_content .= retournerTableauXY($tableau);
	


?>
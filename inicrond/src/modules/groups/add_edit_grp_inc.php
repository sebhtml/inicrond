<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : ajouter/éediter groupe
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

/*
0 : add
1 : edit

*/


else
{

	if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
	!isset($_GET["group_id"]) AND
				is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet)) //admin seulements.
	{

	

//-----------------------
// titre
//---------------------


$elements_titre = array(
		retournerHref("?module_id=21", $_LANG["21"]["titre"]),
		$_LANG["20"]["add"]);

$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


		if(!isset($_POST["envoi"]))
		{
		
		include "modules/groups/includes/forms/group_inc.form.php";
		}
		else
		{
		
			{


			$group_name = $_POST["group_name"];
			$usr_name = $_POST["usr_name"];
			//$queries["SELECT"] ++; // comptage
			//obtenir le id du chef
			$query = "SELECT 
			usr_id
			 FROM 
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." 
			 WHERE
			  usr_name='$usr_name'
			  ";
			
			$query_result = $mon_objet->query($query);

			$row_result = $mon_objet->num_rows($query_result);

			
			$fetch_result = $mon_objet->fetch_assoc($query_result);

			$mon_objet->free_result($query_result);

				if(!isset($fetch_result["usr_id"]))
				{
				$module_content .= $_LANG["20"]["missing_user"];
				}
				else
				{
			
						
			$query = "INSERT 
			INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]." 
			(group_name, description, usr_id) 
			VALUES 
			('".$_POST["group_name"]."',
			'".$_POST["description"]."',
			". $fetch_result["usr_id"]."
			
			)";

			if(!$query_result = $mon_objet->query($query))
			{
			die($query." ".$mon_objet->error());
			}

			$group_id = $mon_objet->insert_id();
	
			$query = "INSERT INTO
			".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"]." 
			(group_id, usr_id, usr_pending) 
			VALUES 
			($group_id,
			". $fetch_result["usr_id"]."
			, 0)";

				if(!$mon_objet->query($query))
				{
				die($mon_objet->error());
				}

			echo js_redir("?module_id=21"."");
			exit();
				}
			}
		}


	}
	elseif(isset($_GET["group_id"]) AND
	$_GET["group_id"] != "" AND
	(int) $_GET["group_id"] AND
	isset($_SESSION["sebhtml"]["usr_id"]) AND
	 is_leader($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet)//leader seulement.
	)//edit
	{

	
//-----------------------
// titre
//---------------------


	$query = "SELECT ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
	group_name,
	description
	 
	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".group_id=".$_GET["group_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".usr_id
	
	
	";
	
	$query_result = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	$mon_objet->free_result($query_result);
	
	//---------------------
		//TITRE
		//---------------

		$elements_titre = array(
		retournerHref("?module_id=21", $_LANG["21"]["titre"]),
		retournerHref("?module_id=22&group_id=".$_GET["group_id"], $fetch_result["group_name"]),
				
		
		$_LANG["20"]["edit"]
		);

		// titre
		$module_title = retourner_titre($elements_titre);


		$group_id = $_GET["group_id"];
	
		$query = "SELECT 
		group_name, 
		description, 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name

		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]." , ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
		WHERE 
		group_id=".$_GET["group_id"]."
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".usr_id
		";

		$query_result = $mon_objet->query($query);
		
		$fetch_result = $mon_objet->fetch_assoc($query_result);
		$mon_objet->free_result($query_result);

		
		if(isset($fetch_result["group_name"]))//le groupe existe.
		{
			if(!isset($_POST["envoi"]))//on affiche le formulaire
			{

		//pas de usr name	
		include "modules/groups/includes/forms/group_inc.form.php";
			}
			else
			{


			
			$query = "UPDATE
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]." 
			 SET 
			 group_name='".$_POST["group_name"]."',
			  description='".$_POST["description"]."'
			  WHERE
			   group_id=".$_GET["group_id"]."
			   ";

			$mon_objet->query($query);
//	$module_content .= $_LANG["15"]["enregistrer"];
		echo js_redir("?module_id=22&group_id=".$_GET["group_id"]."");
		exit();
			}

		}
	}

}
?>
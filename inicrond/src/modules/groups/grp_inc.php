<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : afficher groupe
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
//-------------------
// liste de liens
//--------------------
include "modules/groups/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

/*
0 : add
1 : edit

*/


elseif(isset($_GET["group_id"]) AND
$_GET["group_id"] != "" AND
(int) $_GET["group_id"]
)//
{


	
	
	
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
	
	


	if(isset($fetch_result["group_name"]))//le groupe existe...
	{
	


		//---------------------
		//TITRE
		//---------------

		$elements_titre = array(
		retournerHref("?module_id=21", $_LANG["21"]["titre"]),
		$fetch_result["group_name"]
		);

		// titre
		$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


		//pour les personne opnline seulement, demander de joindre...
		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		isset($_GET["mode_id"])
		)
		{

			
			 if($_GET["mode_id"] == 0  AND
			 !is_usr_pending($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet)
			 )//join
			{
			
			
			
			$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"]."
			(usr_id, group_id)
			VALUES
			(".$_SESSION["sebhtml"]["usr_id"].", 
			". $_GET["group_id"].");";

			 $mon_objet->query($query);
				
			}
			else if( $_GET["mode_id"] == 1 AND
			isset($_SESSION["sebhtml"]["usr_id"]) AND
			 is_leader($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet) 
			 )//valider
			{
			

			$query = "UPDATE
			".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"]."
			SET
			usr_pending=0
			WHERE
			usr_id=". $_GET["usr_id"]."
			AND
			group_id=".$_GET["group_id"].";";

				$query_result_2 = $mon_objet->query($query);
				
			}
			else if( $_GET["mode_id"] == 2  AND
				isset($_SESSION["sebhtml"]["usr_id"]) AND
			 is_leader($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet))//enlever
			{
		
			$query = "DELETE FROM
			".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"]."
			WHERE
			usr_id=".$_GET["usr_id"]."
			AND
			group_id=". $_GET["group_id"].";";

				$query_result_2 = $mon_objet->query($query);
				
			}

		}

		//-----------
		//contenu.
		//------
		
		//joindre
		
		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	!is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet) AND
		 !is_usr_pending($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet)
			  )//pas déjà dans le groupe
			{
			$module_content .= "<br />";
			$module_content .= retournerHref("?module_id=22&group_id=".$_GET["group_id"]."&mode_id=0", $_LANG["22"]["join"]);//
			}

		//le lien pour le edition

			if(isset($_SESSION["sebhtml"]["usr_id"]) AND
			 is_leader($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet)  )
			{
			

			$module_content .= "<br />";
			$module_content .= retournerHref("?module_id=20&group_id=". $_GET["group_id"]."", $_LANG["common"]["edit"]);//éditer
			}
			
		$tableau = array();
	
$colonne =  $fetch_result["group_name"];//la colonne pour le groupe.

	

$tableau []= array( $_LANG["22"]["groupe"], $colonne);




$tableau []= array( $_LANG["22"]["chef"],
retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"]));		
		
$tableau []= array( $_LANG["20"]["description"],
$fetch_result["description"] );		
		
				
			
			
			
			//membres
			$query = "SELECT ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
		FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"]."
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".usr_pending=0
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".group_id=".$_GET["group_id"]."
		";

		$query_result = $mon_objet->query($query);

		$membres_string = "";
		
		while($fetch_result=$mon_objet->fetch_assoc($query_result))
		{
		
		$membres_string .= retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], 
		$fetch_result["usr_name"]);

				if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
				 is_leader($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet) 
				 )
				{
					$membres_string .= " (";

				//le lien pour enlever
					$membres_string .= retournerHref("?module_id=22&mode_id=2&group_id=".$_GET["group_id"]."&usr_id=".$fetch_result["usr_id"], $_LANG["common"]["remove"]) ;;
					$membres_string .= ")";
				}

			$membres_string .= "<br />";
		}

		$mon_objet->free_result($query_result);

		$tableau []= array(	$_LANG["common"]["8"] ,
		$membres_string);	



		//membres en attente

		$membres_string = "";


			$query = "SELECT ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
		FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"]."
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".usr_pending=1
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".group_id=".$_GET["group_id"]."
		";

		$query_result = $mon_objet->query($query);
		$rows_result = $mon_objet->num_rows($query_result);

			if($rows_result != 0)
			{

				



				while($fetch_result=$mon_objet->fetch_assoc($query_result))
				{
				$membres_string .= retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"]);//le lien vers profile

					if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
					 is_leader($_SESSION["sebhtml"]["usr_id"], $_GET["group_id"], $mon_objet
					 ))
					{
					$membres_string .= " (";
					//le lien pour valider
					$membres_string .= retournerHref("?module_id=22&mode_id=1&group_id=".$_GET["group_id"]."&usr_id=".
					$fetch_result["usr_id"], $_LANG["22"]["validate"]) ;;

					$membres_string .= " - ";

					//le lien pour refuser
					$membres_string .= retournerHref("?module_id=22&mode_id=2&group_id=".
					$_GET["group_id"]."&usr_id=".
					$fetch_result["usr_id"], $_LANG["22"]["refuse"]) ;;
					$membres_string .= ")";
					}
				$membres_string .= "<br />";
				}

			$mon_objet->free_result($query_result);

				
				
				$tableau []= array(	$_LANG["22"]["pending"] ,
		$membres_string);
			}

			

		
		$module_content .= retournerTableauXY($tableau);//affiche le tableau.
	}
	

}


?>



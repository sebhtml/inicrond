<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : add/edit forum section
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
include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

else if(isset($_SESSION["sebhtml"]["usr_id"] ) AND
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet)) //admin seulement
{
/*
0 : new
1 : edit
*/


	if($_GET["mode_id"] == 0)
	{
		//-------------------
		// ajouter une section dans le forum
		//--------------------


//-----------------------
// titre
//---------------------
$module_title = retourner_titre(

array(
retournerHref("?module_id=23", $_LANG["common"]["23"]),
$_LANG["27"]["add"]
));
		

		if(!isset($_POST["envoi"]))
		{

		$forum_section_name = "";

		$fetch_result["order_id"] = "";
		
		include "modules/forum/includes/forms/section_inc.form.php";
		}
		elseif($_POST["forum_section_name"] != ""//changement de type
		)
		{





		$forum_section_name = filter($_POST["forum_section_name"]);

		
		$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
		(
		forum_section_name,
		order_id
		)
		VALUES
		(
		'$forum_section_name',
		"."0"."
		)";

			$mon_objet->query($query);
			
			
			
		$order_id = $mon_objet->insert_id();//le numéro de la discussion
			
			//---------------
			//met à jour le order by
			//-------------			
			
			$query = "UPDATE 
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
			SET
			order_id=$order_id
			WHERE
			
			forum_section_id=$order_id
			;";

				$mon_objet->query($query);
				
				
			echo js_redir("?module_id=23");
				exit();
		}
	}
	elseif($_GET["mode_id"] == 1 AND
	 isset($_GET["forum_section_id"]) AND
	 $_GET["forum_section_id"] != "" AND
	 (int) $_GET["forum_section_id"]
	 )
	{//éditer

	


		

		//--------------
		// existe-il ??
		//-------------

		$forum_section_id = $_GET["forum_section_id"];

		$query = "SELECT
		 forum_section_name
		 FROM
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]." 
		  WHERE 
		  forum_section_id=".$_GET["forum_section_id"]."";

		$query_result = $mon_objet->query($query);


		$num_row = $mon_objet->num_rows($query_result);

				$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);

		if($num_row == 1)//est-ce qu'elle existe ?
		{
		//-----------------------
// titre
//---------------------
$module_title = retourner_titre(
array(
retournerHref("?module_id=23", $_LANG["common"]["23"]),
$fetch_result["forum_section_name"],
$_LANG["27"]["edit"]));

			if(!isset($_POST["envoi"]))
			{
			$forum_section_name = $fetch_result["forum_section_name"];
		
			include "modules/forum/includes/forms/section_inc.form.php";
			}
			elseif($_POST["forum_section_name"] != ""  //changement de type
			)// on apporte les chagements
			{


			$forum_section_name = filter($_POST["forum_section_name"]);

		//$queries["UPDATE"] ++; // comptage
		
			$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
			SET
			forum_section_name='$forum_section_name'
			WHERE
			forum_section_id=$forum_section_id
			";

			$mon_objet->query($query);
			echo js_redir("?module_id=23");
			exit();
			}
		
		}

	}

}
?>



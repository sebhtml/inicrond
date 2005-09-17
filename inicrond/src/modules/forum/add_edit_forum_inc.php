<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : add/edit discussion
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


*/include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

else if(isset($_SESSION["sebhtml"]["usr_id"] ) AND 
is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND
 isset($_GET["mode_id"])
 
) //admin seulement
{
/*
0 : new
1 : edit
*/

	

	if($_GET["mode_id"] == 0 AND 
	isset($_GET["forum_section_id"]) AND
	$_GET["forum_section_id"] != "" AND
	(int) $_GET["forum_section_id"]
	)
	{
		//-------------------
		// ajouter une discussion
		//--------------------
	
		$forum_section_id = $_GET["forum_section_id"];

			$queries["SELECT"] ++; // comptage
			
		$query = "SELECT count(forum_section_id) 
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]." 
		WHERE 
		forum_section_id=$forum_section_id";

		$query_result = $mon_objet->query($query);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);
		
		if($fetch_result["count(forum_section_id)"] == 1)//est-ce que la section existe ?
		{
		
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

		
		//-----------------------
// titre
//---------------------
$module_title = retourner_titre(
array(
retournerHref("?module_id=23", $_LANG["common"]["23"]),
$fetch_result["forum_section_name"],
$_LANG["28"]["add"]
));
			



			if(!isset($_POST["envoi"]))
			{

			$forum_discussion_name = "";

			include "modules/forum/includes/forms/forum_inc.form.php";

			}
			else
			{






			$forum_discussion_name = filter($_POST["forum_discussion_name"]);
			$forum_discussion_description = filter($_POST["forum_discussion_description"]);
			$right_thread_start = $_POST["right_thread_start"];
			
$queries["INSERT"] ++; // comptage
				
			$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
			(
			forum_discussion_name,
			forum_discussion_description,
			forum_section_id,
			right_thread_start,
			right_thread_reply,
			order_id
			)
			VALUES
			(
			'$forum_discussion_name',
			'$forum_discussion_description',
			$forum_section_id,
			$right_thread_start,".
			$_POST["right_thread_reply"].",
			0
			)";

				if(!$mon_objet->query($query))
				{
				die($query." ".$mon_objet->error());
				}
			
			$order_id = $mon_objet->insert_id();//le numéro de la discussion
			
			//---------------
			//met à jour le order by
			//-------------			
			//*/$queries["UPDATE"] ++; // comptage
				
			$query = "UPDATE 
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
			SET
			order_id=$order_id
			WHERE
			
			forum_discussion_id=$order_id
			;";

				if(!$mon_objet->query($query))
				{
				die($query." ".$mon_objet->error());
				}
				
		echo js_redir("?module_id=23");
		exit();
			}
		
		}
	}
	elseif($_GET["mode_id"] == 1 AND 
	isset($_GET["forum_discussion_id"]) AND
	$_GET["forum_discussion_id"] != "" AND
	(int) $_GET["forum_discussion_id"]
	)//�itter une discussion
	{
/*



*/
	
//editer une discussion
$query = "SELECT
		 forum_section_name,
		 forum_discussion_name
		 FROM
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]." ,
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]." 
		  WHERE 
		  forum_discussion_id=".$_GET["forum_discussion_id"]."
		  AND
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"].".forum_section_id= ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]." .forum_section_id";

		$query_result = $mon_objet->query($query);


		$num_row = $mon_objet->num_rows($query_result);

				$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);

		
		//-----------------------
// titre
//---------------------
$module_title = retourner_titre(
array(
retournerHref("?module_id=23", $_LANG["common"]["23"]),
$fetch_result["forum_section_name"],
retournerHref("?module_id=24&forum_discussion_id=".$_GET["forum_discussion_id"], $fetch_result["forum_discussion_name"]),
$_LANG["28"]["edit"]
));
			
	
		//--------------
		// existe-il ??
		//-------------

		$forum_discussion_id = $_GET["forum_discussion_id"];
//$queries["SELECT"] ++; // comptage

		$query = "SELECT
		 forum_discussion_name, forum_discussion_description,
		 right_thread_start,
		 	right_thread_reply
		
		 FROM 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
		 WHERE 
		 forum_discussion_id=$forum_discussion_id";

		if(!$query_result = $mon_objet->query($query))
		{
		die($query." ".$mon_objet->error());
		}
		
		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);

			
			if(!isset($_POST["envoi"]))
			{
			$forum_discussion_name = $fetch_result["forum_discussion_name"];
			$forum_discussion_description = $fetch_result["forum_discussion_description"];
			$right_thread_start = $fetch_result["right_thread_start"];
			$right_thread_reply = $fetch_result["right_thread_reply"];
			
			include "modules/forum/includes/forms/forum_inc.form.php";
			
			//$module_content .= $_LANG["23"]["cbparser_info"];//information pour le bbcode
			}
			else // on apporte les chagements
			{

			$forum_discussion_name = filter($_POST["forum_discussion_name"]);
			$forum_discussion_description = filter($_POST["forum_discussion_description"]);
			$right_thread_start = $_POST["right_thread_start"];

			$queries["UPDATE"] ++; // comptage
			
			$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
			SET
			forum_discussion_name='$forum_discussion_name',
			forum_discussion_description='$forum_discussion_description',
			right_thread_start=$right_thread_start,
			right_thread_reply=".$_POST["right_thread_reply"]."
			
			
			WHERE
			forum_discussion_id=$forum_discussion_id
			";

			$mon_objet->query($query);
			
					echo js_redir("?module_id=23");
					exit();
			}
		
		

	}

}
?>



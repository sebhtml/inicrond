<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : formulaire edit/add discussion
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
if(isset($_OPTIONS["INCLUDED"]))
{


		$forum_sujet_id = $_GET["forum_sujet_id"];

		$query = "SELECT count(forum_sujet_id)
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		WHERE
		forum_sujet_id=$forum_sujet_id;";

		$query_result = $mon_objet->query($query);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);

		if($fetch_result["count(forum_sujet_id)"] == 1)//est-ce que le sujet existe
		{

			

//titre
$module_title = retourner_titre(
array(
$_LANG["26"]["titre"]
)
, $_OPTIONS["separator"], $_OPTIONS["titre"]);

			
			if(isset($_POST["sent"]) )
			{
				
				
				{
			
			$usr_id = $_SESSION["sebhtml"]["usr_id"];
			$forum_message_titre = filter($_POST["forum_message_titre"]);
			$forum_message_contenu = filter($_POST["forum_message_contenu"]);

			$forum_message_add_gmt_timestamp = gmmktime();
			$forum_message_edit_gmt_timestamp = gmmktime();

			$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
			(
			usr_id,
			forum_message_titre,
			forum_message_contenu,
			
			forum_message_add_gmt_timestamp,
			forum_message_edit_gmt_timestamp,
			forum_sujet_id
			)
			VALUES
			(
			$usr_id,
			'$forum_message_titre',
			'$forum_message_contenu',

			$forum_message_add_gmt_timestamp,
			$forum_message_edit_gmt_timestamp,
			$forum_sujet_id
			)
			;";

				if(!$mon_objet->query($query))
				{
				die($query." ".$mon_objet->error());
				}

			echo js_redir("?module_id=25&forum_sujet_id=".
			$_GET["forum_sujet_id"]
			);
			exit();
				}
			}
			else//le formulaire
			{
			$forum_message_titre = "";
			$forum_message_contenu = "";

			include "modules/forum/includes/forms/postit_inc.form.php";

			}
		}
		
}


?>

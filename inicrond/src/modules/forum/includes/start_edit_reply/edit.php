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


		$forum_message_id = $_GET["forum_message_id"];

		$query = "SELECT usr_id
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
		WHERE
		forum_message_id=$forum_message_id
		;";

		$query_result = $mon_objet->query($query);

		$rows_result = $mon_objet->num_rows($query_result);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);

		if($rows_result == 1 AND $_SESSION["sebhtml"]["usr_id"] == $fetch_result["usr_id"])
		//est ce que le massage existe ?
		//est-ce que le usr est valide ?
		{


	
//titre
$module_title = retourner_titre(
array(
$_LANG["15"]["edit"]
)
, $_OPTIONS["separator"], $_OPTIONS["titre"]);

		

			if(isset($_POST["sent"]) AND $_POST["forum_message_titre"] != "" AND $_POST["forum_message_contenu"] != "")
			{

			$forum_message_titre = filter($_POST["forum_message_titre"]);
			$forum_message_contenu = filter($_POST["forum_message_contenu"]);
			//$adresse_ip = $_SERVER["REMOTE_ADDR"];
			$forum_message_edit_gmt_timestamp = gmmktime();

			$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
			SET

			forum_message_titre='$forum_message_titre',
			forum_message_contenu='$forum_message_contenu',
		
			forum_message_edit_gmt_timestamp=$forum_message_edit_gmt_timestamp

			WHERE

			forum_message_id=$forum_message_id
			;";

				if(!$mon_objet->query($query))
				{
				die($query." ".$mon_objet->error());
				}

			echo js_redir("?module_id=25&forum_sujet_id=".
			message2sujet($_GET["forum_message_id"], $mon_objet)
			);
			exit();
			}
			else//le formulaire pour éditer
			{

		$query = "SELECT forum_message_titre, forum_message_contenu
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
		WHERE
		forum_message_id=$forum_message_id
		;";

		$query_result = $mon_objet->query($query);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);

			$forum_message_titre = $fetch_result["forum_message_titre"];
			$forum_message_contenu = $fetch_result["forum_message_contenu"];

			include "modules/forum/includes/forms/postit_inc.form.php";

			}
		}
}


?>

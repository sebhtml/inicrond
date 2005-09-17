<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : modétateurs pour discussions
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

if(isset($_OPTIONS["INCLUDED"])
)
{

	if(isset($_POST["envoi"]) AND//formulaire envoyé ??
	isset($_POST["forum_discussion_id"]) AND //demande-t-on quelque chose ?
	$_POST["forum_discussion_id"] != "" AND //pas de chaine vide
	(int) $_POST["forum_discussion_id"] //changement de type
	)//on analyse la demande
	{
	
	$sql = //chagement de discussion de tous les sujets
	"
	UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
	SET
	forum_discussion_id=".$_POST["forum_discussion_id"]."
	WHERE
	forum_discussion_id=".$_GET["forum_discussion_id"]."
	;";

	$sql_result = $mon_objet->query($sql);
	
	
	$sql = "
	DELETE
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	WHERE
	forum_discussion_id=".$_GET["forum_discussion_id"]."
	;";

	$sql_result = $mon_objet->query($sql);
	
	$module_content .= $_LANG["23"]["discussion_deleted"];

	
	}
	else//on montre le formulaire
	{
	
	$module_content .= $_LANG["23"]["where"];
		
		//---------------
		//la liste déroulante :::
		//----------------
		$module_content .= "<form method=\"POST\">
		<select name=\"forum_discussion_id\" >";
		
		$queries["SELECT"] ++; // comptage
			
		$query = "SELECT
		forum_discussion_id, forum_discussion_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
		ORDER BY forum_discussion_name ASC
		;";

		$query_result = $mon_objet->query($query);
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{
			if($fetch_result["forum_discussion_id"] != 
			$_GET["forum_discussion_id"])//on ne met pas la discussion courante
			{
		 	
			$module_content .=  "<OPTION VALUE=\"".
			$fetch_result["forum_discussion_id"]."\">".
			$fetch_result["forum_discussion_name"]."</OPTION>";
			}
		}

		$mon_objet->free_result($query_result);
		
		//fermeture du formulaire
		  $module_content .= "</select>
		  <input type=\"submit\"
		   name=\"envoi\" value=\"".$_LANG["txtBoutonForms"]["ok"]."\" />	
		   </form>";
		   
	}

}
?>


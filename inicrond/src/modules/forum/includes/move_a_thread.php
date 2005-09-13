<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir discussion
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
	
	if(!isset($_POST["envoi"]))//forumulaire
	{
	$module_content .= $_LANG["10"]["transfer_img"];
	
		//---------------
		//la liste déroulante :::
		//----------------
	include "modules/forum/includes/forms/move_thread.form.php";
		  
	}
	elseif(isset($_POST["forum_discussion_id"]) AND
	$_POST["forum_discussion_id"] != "" AND
	 (int) $_POST["forum_discussion_id"] AND
is_mod($_SESSION["sebhtml"]["usr_id"], $forum_discussion_id, $mon_objet)
	 )//changements
	{
	
	//$queries["UPDATE"] ++; // comptage
			
		$query = "
		UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		SET
		forum_discussion_id=".$_POST["forum_discussion_id"]."
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_sujet_id=".$_GET["forum_sujet_id"]."
		;";

		$query_result = $mon_objet->query($query);
		
	}
}


?>


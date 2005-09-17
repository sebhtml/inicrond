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
include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(isset($_OPTIONS["INCLUDED"]) AND
isset($_SESSION["sebhtml"]["usr_id"] ) AND 
is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet)//administrateurs seulements.
)
{
$elements_titre = array(
$_LANG["33"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	if(isset($_GET["forum_discussion_id"]) AND
	$_GET["forum_discussion_id"] != "" AND
	(int) $_GET["forum_discussion_id"]
	)
	{
		if(isset($_GET["group_id"]) AND
		$_GET["group_id"] != "" AND
		(int) $_GET["group_id"]
		)//enlève un modérateur
		{
		
		$queries["DELETE"] ++;

		$sql = "DELETE

		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"]."
		WHERE
		forum_discussion_id=". $_GET["forum_discussion_id"]."
		AND
		group_id=".$_GET["group_id"]."
		;";

		$query_result = $mon_objet->query($sql);
		
		}
		if(isset($_POST["group_id"]) AND
		$_POST["group_id"] != "" AND
		(int) 	$_POST["group_id"]
		)//ajoute un modérateur.
		{
		
		$queries["INSERT"] ++; // comptage
			
		$query = "INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"]."
		(group_id, forum_discussion_id)
		VALUES
		(
		".$_POST["group_id"].",
		".$_GET["forum_discussion_id"]."
		)
		;";
		
		
		$query_result = $mon_objet->query($query);
		
		}
		//-----------
		//formulaire pour ajouter un modérateur.
		//---------------
		
		$module_content .= "<form  method=\"POST\">

	";
	 $module_content .= "
     ".$_LANG["33"]["ajouter"]."";
	 //---------------
		//la liste déroulante :::
		//----------------
		
		$module_content .= "
		<select name=\"group_id\" >";
		
		$queries["SELECT"] ++; // comptage
			
		$query = "SELECT
		group_id, group_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
		ORDER BY 
		group_name
		 ASC
		;";
		
		
		$query_result = $mon_objet->query($query);
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{
			
		 				
			
			$module_content .=  "<OPTION VALUE=\"".
			$fetch_result["group_id"]."\">".
			$fetch_result["group_name"]."</OPTION>";
			
		}

		$mon_objet->free_result($query_result);
		
		//fermeture du formulaire
		  $module_content .= "</select>
		  ";
		   /*
	   <tr>
      <td >".$_LANG["28"]["right_thread_start"]."<td />
      <td ><input type=\"text\" name=\"right_thread_start\"  value=\"".
	  $right_thread_start."\" /><td />
	 </tr>
	 */
	 
	 $module_content .= "";
	 
       $module_content .= " <input type=\"submit\" name=\"envoi\" value=\"".$_LANG["txtBoutonForms"]["ok"]."\" />	 
</form>" ;

	//-------------
	//liste des modérateur actuels
	//---------
	
	$queries["SELECT"] ++;
	
	$sql = "SELECT
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".group_id, 
	group_name
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
	WHERE
	forum_discussion_id=". $_GET["forum_discussion_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].".group_id=	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".group_id
	;";
	
	if(!$query_result = $mon_objet->query($sql))
	{
	die($sql." ".$mon_objet->error());
	}
	
	//$module_content .= "<br />";
	
	$module_content .= $_LANG["33"]["enlever"];
	
		$module_content .= "<br />";
		
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{
		$module_content .= retournerHref("?module_id=33&forum_discussion_id=".	 $_GET["forum_discussion_id"].
		 "&group_id=".$fetch_result["group_id"]."", 
		$fetch_result["group_name"]);
		$module_content .= "<br />";//saut de ligne...
		}
		
	$mon_objet->free_result($query_result);
	
	}

}
?>


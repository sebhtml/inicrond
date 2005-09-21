<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : options
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
include "modules/admin/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(isset($_OPTIONS["INCLUDED"]) AND
isset($_SESSION["sebhtml"]["usr_id"]) AND //administrateurs seulements.
is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet)
)
{
$elements_titre = array(
$_LANG["34"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	if(!isset($_POST["envoi"]))//formulaire.
	{
	
	$sql = 
"SELECT 
titre,
separator,

news_forum_discussion_id,

 usr_time_decal, 
 language,

preg_email, 
preg_usr, 
preg_agent,
header_txt,
footer_txt

FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_options"]."
";

$query_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($query_result);


$mon_objet->free_result($query_result);

include "modules/admin/includes/forms/etc.form.php";

 

	}
	else//modifications
	{

	$sql = "
	UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_options"]."
	SET

news_forum_discussion_id=".$_POST["news_forum_discussion_id"].",
usr_time_decal=".$_POST["usr_time_decal"].",
preg_email='".$_POST["preg_email"]."',
preg_usr='".$_POST["preg_usr"]."',
preg_agent='".$_POST["preg_agent"]."',
language='".$_POST["language"]."',
titre='".$_POST["titre"]."',
separator='".$_POST["separator"]."',
header_txt='".($_POST["header_txt"])."',
footer_txt='".($_POST["footer_txt"])."'


  ";
  
  if(!$query_result = $mon_objet->query($sql))
  {
  die($sql." ".$mon_objet->error());
  }
  
  $module_content .= $_LANG["34"]["ok"];
	}
}
?>


<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/
define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "../../");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";
include "includes/languages/".$_SESSION["language"]."/lang.php";

include "includes/functions/conversion.function.php";

if(__INICROND_INCLUDED__ AND//sécurité
isset($_GET["test_id"]) AND//test_id au moins
$_GET["test_id"] != "" AND//pas de chaîne vide
(int) $_GET["test_id"] AND //changement de type
is_teacher_of_cours($_SESSION["usr_id"],test_2_cours($_GET["test_id"])) AND
($_GET["q_type"] == 0 OR $_GET["q_type"] == 1 OR $_GET["q_type"] == 2 OR $_GET["q_type"] == 3 )//le type existe ??
)
{

//get the courses _id
$query = "SELECT
cours_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"]."
WHERE 
test_id=".$_GET["test_id"]."

";

$rs = $inicrond_db->Execute($query);
  $fetch_result = $rs->FetchRow();
  

$query = "INSERT INTO
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
(
question_name, 
q_type,

cours_id
)
VALUES
(
\"\",

".$_GET["q_type"].",

".$fetch_result["cours_id"]."
)

";


$inicrond_db->Execute($query);	

$question_id = $inicrond_db->Insert_ID();	

  //insert the q_link.
$inicrond_db->Execute("  INSERT INTO
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["question_linking"]."
  
 (test_id, question_id, q_order_id)
 VALUES
 (".$_GET["test_id"].", ".$question_id.", $question_id);
   ");
   

include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

 js_redir("edit_a_test_GOLD.php?test_id=".$_GET["test_id"]);


}
?>

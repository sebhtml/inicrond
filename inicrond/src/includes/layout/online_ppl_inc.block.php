<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : personnes en lignes
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
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

//ajoute ou met à jour
//include "includes/pageLayout/visits_tracker_inc.php" ;

$layout_contenu = "";
	


//-----------------
//vérifier
//---------------


//-------------------
//afficher...
//---------------------

$tableau = array();

//

$query = "SELECT
 count(usr_id)
 FROM 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]."
 WHERE
 usr_id!=".$_OPTIONS["usr_id"]["nobody"]."
 AND
  is_online=1

 ;";

$query_result = $mon_objet->query($query);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

$tableau[] = array( $_LANG["txt_mod_count"]["membres"],$fetch_result["count(usr_id)"]);






//

$query = "SELECT
 count(usr_id)
 FROM 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]."
 WHERE
 usr_id=".$_OPTIONS["usr_id"]["nobody"]."
 AND

 is_online=1
 ;";

$query_result = $mon_objet->query($query);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

$tableau[] = array($_LANG["txt_mod_count"]["anonim"], $fetch_result["count(usr_id)"]);


$query = "SELECT count(usr_id)
 FROM 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]."
WHERE

 is_online=1
 ;";
 
$query_result = $mon_objet->query($query);

	
		
$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

$tableau[] = array($_LANG["txt_mod_count"]["total"], $fetch_result["count(usr_id)"]);



$layout_contenu .=  retournerTableauXY($tableau);

//----------------
//membres en ligne
//---------------

//
//

$query = "SELECT ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
 FROM 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
 WHERE 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].".usr_id
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].".usr_id!=".$_OPTIONS["usr_id"]["nobody"]."
AND
 
 is_online=1
 ;";//0 est le visiteur...

$query_result = $mon_objet->query($query);
$rows_result = $mon_objet->num_rows($query_result);

$string = "";

	if($rows_result != 0)
	{
	$string = "(";
	}

while($fetch_result = $mon_objet->fetch_assoc($query_result))
{
$string .= retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"]);
$string .= ", ";
}
$mon_objet->free_result($query_result);

if($rows_result != 0)
	{
	$string = substr($string, 0, strlen($string)-2);//enlève la dernière virgule
	$string .= ")";
	
	}




$layout_contenu .= $string;//affiche la liste des membres

?>

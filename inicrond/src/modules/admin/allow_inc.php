<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : gérer les utilisateurs
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
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}


	
else if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet))
{




		/*
		modes :

		0 : activer usr
		1 : ban usr
		2 : warn usr
		3 : unwarn
		*/

	//--------------------------


	//analyse la demande

	//activate
	if(isset($_GET['mode_id']) AND 
	isset($_GET['usr_id']) AND
	$_GET['usr_id'] != "" AND
	(int) $_GET['usr_id'] AND
	 $_GET['mode_id'] == 0)
	{


	$usr_id = $_GET["usr_id"];

	//
	
	$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." SET usr_activation=1 WHERE usr_id=$usr_id";

		if(!$mon_objet->query($query))
		{
		$module_content .= $_LANG["9"]["UtilisateurExistePas"] ;
		}

	}

	//ban
	else if(isset($_GET['mode_id']) AND isset($_GET['usr_id']) AND  $_GET['mode_id'] == 1)
	{


	$usr_id = $_GET["usr_id"];
//
	$query = "SELECT usr_deletable FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." WHERE usr_id=$usr_id";

	$query_result = $mon_objet->query($query);

	$result = $mon_objet->fetch_assoc($query_result);

	$mon_objet->free_result($query_result);

		if($result['usr_deletable'] == 0 )
		{
		$module_content .= $_LANG["9"]["UtilisateurExistePas"] ;
		}
		else
		{
		//
		
		$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." SET usr_activation=0, usr_ban_warning=0 WHERE usr_id=$usr_id";

		$mon_objet->query($query);
			
		//
		
		$query = "DELETE FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs WHERE usr_id=$usr_id";//enlève les entrée pour les groupes

		$mon_objet->query($query);
			
		}

		
	}

	//warn
	else if(isset($_GET['mode_id']) AND 
	isset($_GET['usr_id']) AND
	$_GET['usr_id'] != "" AND
	(int) $_GET['usr_id'] AND
	 $_GET['mode_id'] == 2)
	{

	$usr_id = $_GET["usr_id"];

	//
	
	$query = "SELECT usr_deletable FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." WHERE usr_id=$usr_id";

	$query_result = $mon_objet->query($query);

	$result = $mon_objet->fetch_assoc($query_result);

	$mon_objet->free_result($query_result);

		if($result['usr_deletable'] == 0 )
		{
		$module_content .= $_LANG["9"]["UtilisateurExistePas"] ;
		}
		else
		{
		//
		
		$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." SET usr_ban_warning=1 WHERE usr_id=$usr_id";

		$mon_objet->query($query);
		}

	}

	//unwarm
	elseif($_GET["mode_id"] == 3 AND
	isset($_GET["usr_id"]) AND
	$_GET["usr_id"] != "" AND
	(int) $_GET["usr_id"]
	)
	{

	$usr_id = $_GET["usr_id"];

	//
	
	$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." SET usr_ban_warning=0 WHERE usr_id=$usr_id";




		if(!$mon_objet->query($query))
		{
		$module_content .= $_LANG["9"]["UtilisateurExistePas"] ;
		}
	}

	
//-----------------------
// titre
//---------------------


$elements_titre = array($_LANG["common"]["9"]);

$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


	//banir

	function list_ban_warning_usrs($mon_objet)
	{
	
	 global $_OPTIONS;
	  global $mon_objet;
//

	$query = "SELECT usr_id, usr_name FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." WHERE usr_activation=1 AND usr_ban_warning=1;";

	$query_result = $mon_objet->query($query);

	$result = array();

		while($r = $mon_objet->fetch_assoc($query_result)) 
		{
		$result[] = $r;
		}

	$mon_objet->free_result($query_result);

	return $result;
	}

	$table = list_ban_warning_usrs($mon_objet);

	$count_table = count($table);

	if($count_table > 0)
	{
	$module_content .= $_LANG["9"]["ban"];
	$module_content .= "<br />";

		for($i=0;$i<$count_table;$i++)
		{
		$module_content .= retournerHref("?module_id=9&mode_id=1&usr_id=".$table[$i]['usr_id'], $table[$i]['usr_name']);
		$module_content .= "<br />";
		}

	}
	//avertir


	function list_not_warned_usr($mon_objet)
	{

 global $_OPTIONS;
	  global $mon_objet;
	$query = "SELECT usr_id, usr_name FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." WHERE  usr_activation=1 AND usr_ban_warning=0;";

	$query_result = $mon_objet->query($query);

	$result = array();

		while($r = $mon_objet->fetch_assoc($query_result)) 
		{
		$result[] = $r;
		}

	$mon_objet->free_result($query_result);

	return $result;
	}


	$table = list_not_warned_usr($mon_objet);

	$count_table = count($table);

	if($count_table > 0)
	{
	$module_content .= $_LANG["9"]["ban_warning"];
	$module_content .= "<br />";

		for($i=0;$i<$count_table;$i++)
		{
		$module_content .= retournerHref("?module_id=9&mode_id=2&usr_id=".$table[$i]['usr_id'], $table[$i]['usr_name']);
		$module_content .= "<br />";
		}
	}

	//activer


	function list_not_activated_usrs($mon_objet)
	{

// 
global $_OPTIONS;
	  global $mon_objet;

	$query = "SELECT usr_id, usr_name FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." WHERE usr_activation=0;";

	$query_result = $mon_objet->query($query);

	$result = array();

		while($r = $mon_objet->fetch_assoc($query_result)) 
		{
		$result[] = $r;
		}

	$mon_objet->free_result($query_result);

	return $result;
	}

	$table = list_not_activated_usrs($mon_objet);

	$count_table = count($table);

	if($count_table > 0)
	{
	$module_content .= $_LANG["9"]["activate"];
	$module_content .= "<br />";
		for($i=0;$i<$count_table;$i++)
		{
		$module_content .= retournerHref("?module_id=9&mode_id=0&usr_id=".$table[$i]['usr_id'], $table[$i]['usr_name']);
		$module_content .= "<br />";
		}

	}




	//unwarm
	$table = list_ban_warning_usrs($mon_objet);

	$count_table = count($table);

	if($count_table > 0)
	{
	$module_content .= $_LANG["9"]["unwarm"];
	$module_content .= "<br />";
		for($i=0;$i<$count_table;$i++)
		{
		$module_content .= retournerHref("?module_id=9&mode_id=3&usr_id=".$table[$i]['usr_id'], $table[$i]['usr_name']);
		$module_content .= "<br />";
		}

	}

}
?>



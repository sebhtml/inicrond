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
if(isset($_OPTIONS["INCLUDED"]))
{

//----------------
// ajouter
//---------------


$start_gmt = gmmktime();

$end_gmt = $start_gmt;



//$php_session_id = session_id();

//$usr_id = isset($_SESSION["sebhtml"]["usr_id"]) ? $_SESSION["sebhtml"]["usr_id"] : $_OPTIONS["usr_id"]["nobody"];



//
/*
$query = "SELECT 
session_id
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]." 
WHERE 
php_session_id='". session_id()."'
AND
usr_id=".$usr_id."
AND
is_online=1

;";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);
*/
//inclue les  donnees de validation
//include "includes/donnees/donnees_validation_inc.php";

	if(!isset($_SESSION["sebhtml"]["session_id"]) AND//pas de session php, anonnyme...
	!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))//vient juste d'embarquer, on prend pas les googles
	{
	

	$query = "INSERT INTO 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]." 
	(
usr_id,
php_session_id,	

HTTP_USER_AGENT ,

HTTP_ACCEPT ,
HTTP_ACCEPT_LANGUAGE ,
HTTP_ACCEPT_ENCODING ,
HTTP_ACCEPT_CHARSET ,

HTTP_KEEP_ALIVE   ,

HTTP_CONNECTION,


REMOTE_ADDR,
REMOTE_PORT,

dns,
start_gmt, 
end_gmt

	 ) 
	VALUES
	(
".$_OPTIONS["usr_id"]["nobody"].",
'".session_id()."',	

'".$_SERVER["HTTP_USER_AGENT"]."' ,

'".$_SERVER["HTTP_ACCEPT"]."' ,
'".$_SERVER["HTTP_ACCEPT_LANGUAGE"]."' ,
'".$_SERVER["HTTP_ACCEPT_ENCODING"]."' ,
'".$_SERVER["HTTP_ACCEPT_CHARSET"]."' ,

'".$_SERVER["HTTP_KEEP_ALIVE"]."'  ,

'".$_SERVER["HTTP_CONNECTION"]."',


'".$_SERVER["REMOTE_ADDR"]."',
'".$_SERVER["REMOTE_PORT"]."',
'".gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
$start_gmt, 
$end_gmt
	   );";

		$mon_objet->query($query);
	$_SESSION["sebhtml"]["session_id"] = $mon_objet->insert_id();
	
	}//fin de l'insertion pour les visiteurs.
/*
//$dns = ;

//


	$query = "INSERT INTO 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]." 
	(
usr_id,
php_session_id,	

HTTP_USER_AGENT ,

HTTP_ACCEPT ,
HTTP_ACCEPT_LANGUAGE ,
HTTP_ACCEPT_ENCODING ,
HTTP_ACCEPT_CHARSET ,

HTTP_KEEP_ALIVE   ,

HTTP_CONNECTION,

REMOTE_HOST ,
REMOTE_ADDR,
REMOTE_PORT,

dns,
start_gmt, 
end_gmt

	 ) 
	VALUES
	(
	$usr_id,
'".session_id()."',	

'".$_SERVER["HTTP_USER_AGENT"]."' ,

'".$_SERVER["HTTP_ACCEPT"]."' ,
'".$_SERVER["HTTP_ACCEPT_LANGUAGE"]."' ,
'".$_SERVER["HTTP_ACCEPT_ENCODING"]."' ,
'".$_SERVER["HTTP_ACCEPT_CHARSET"]."' ,

'".$_SERVER["HTTP_KEEP_ALIVE"]."'  ,

'".$_SERVER["HTTP_CONNECTION"]."',

'".$_SERVER["REMOTE_HOST"]."' ,
'".$_SERVER["REMOTE_ADDR"]."',
'".$_SERVER["REMOTE_PORT"]."',
'".gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
$start_gmt, 
$end_gmt
	   );";

		$mon_objet->query($query);
	$_SESSION["sebhtml"]["session_id"] = $mon_objet->insert_id();
	
	$tmp["session_id"] = $mon_objet->insert_id();

	}
	else// if($fetch_result["count(php_session_id)"] != 0)//est dï¿½ï¿½lï¿½	{
	{
//	
$tmp["session_id"] = $fetch_result["session_id"];//pour l'éexécution du script.
	
//die($tmp["session_id"]);

	//----------
	//mise ï¿½jour de la table
	//-------
	$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]."
	SET 
	end_gmt=$start_gmt
	
	WHERE
	session_id=".$fetch_result["session_id"]."
	;";

		$mon_objet->query($query);
		
	}
	*/
	
	//$tmp["session_id"] = $fetch_result["session_id"];//pour l'éexécution du script.
	
//die($tmp["session_id"]);

	//----------
	//mise ï¿½jour de la table
	//-------
	
	//echo $end_gmt;
	
	//exit();
	
	if(isset($_SESSION["sebhtml"]["session_id"]))
	{
	$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]."
	SET 
	end_gmt=$end_gmt,
	is_online=1
	WHERE
	session_id=".$_SESSION["sebhtml"]["session_id"]."
	;";

	$mon_objet->query($query);
	}
	

}



?>

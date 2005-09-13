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
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : kovistaz



//
//---------------------------------------------------------------------
*/
include "modules/sessions/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";

 if(
isset($_OPTIONS["INCLUDED"]) 
)
{




//requête pour toutes les sessions...
$sql = "
SELECT 
dns,
is_online,
end_gmt,
start_gmt,
end_gmt-start_gmt,
REMOTE_PORT,
REMOTE_ADDR,

HTTP_USER_AGENT,
HTTP_CONNECTION,
HTTP_KEEP_ALIVE,
HTTP_ACCEPT_CHARSET,
HTTP_ACCEPT,
HTTP_ACCEPT_LANGUAGE,
HTTP_ACCEPT_ENCODING,
php_session_id,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
usr_name
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].".usr_id
AND
session_id=".$_GET["session_id"]."
";

/*
//base url pour le tableau
$base = "?module_id=501";

*/
	$query_result = $mon_objet->query($sql);
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	$mon_objet->free_result($query_result);
	$tableau = array();

//usr_name
$tableau []= array($_LANG["500"]["usr_name"],
retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"]));


//php_session_id
$tableau []= array($_LANG["500"]["php_session_id"], $fetch_result["php_session_id"]);


//is_online,
$tableau []= array($_LANG["500"]["is_online"], $fetch_result["is_online"]);

//end_gmt,
$tableau []= array($_LANG["500"]["end_gmt"], format_time_stamp($fetch_result["end_gmt"]));

//start_gmt,
$tableau []= array($_LANG["500"]["start_gmt"], format_time_stamp($fetch_result["start_gmt"]));

//end_gmt-start_gmt,
$tableau []= array($_LANG["500"]["end_gmt-start_gmt"], format_time_length($fetch_result["end_gmt-start_gmt"]));


//dns,
$tableau []= array($_LANG["500"]["dns"], $fetch_result["dns"]);

//REMOTE_PORT,
$tableau []= array($_LANG["500"]["REMOTE_PORT"], $fetch_result["REMOTE_PORT"]);

//REMOTE_ADDR,
$tableau []= array($_LANG["500"]["REMOTE_ADDR"], $fetch_result["REMOTE_ADDR"]);

//HTTP_USER_AGENT,
$tableau []= array($_LANG["500"]["HTTP_USER_AGENT"], $fetch_result["HTTP_USER_AGENT"]);

//HTTP_CONNECTION,
$tableau []= array($_LANG["500"]["HTTP_CONNECTION"], $fetch_result["HTTP_CONNECTION"]);

//HTTP_KEEP_ALIVE,
$tableau []= array($_LANG["500"]["HTTP_KEEP_ALIVE"], $fetch_result["HTTP_KEEP_ALIVE"]);

//HTTP_ACCEPT_CHARSET,
$tableau []= array($_LANG["500"]["HTTP_ACCEPT_CHARSET"], $fetch_result["HTTP_ACCEPT_CHARSET"]);

//HTTP_ACCEPT,
$tableau []= array($_LANG["500"]["HTTP_ACCEPT"], $fetch_result["HTTP_ACCEPT"]);

//HTTP_ACCEPT_LANGUAGE,
$tableau []= array($_LANG["500"]["HTTP_ACCEPT_LANGUAGE"], $fetch_result["HTTP_ACCEPT_LANGUAGE"]);

//HTTP_ACCEPT_ENCODING,
$tableau []= array($_LANG["500"]["HTTP_ACCEPT_ENCODING"], $fetch_result["HTTP_ACCEPT_ENCODING"]);




$module_content .= retournerTableauXY($tableau);

$elements_titre = array(
retournerHref("?module_id=500", $_LANG["common"]["500"]),
$fetch_result["php_session_id"]
);

	$module_title = retourner_titre($elements_titre);

//echo nl2br(print_r($_SERVER, TRUE));

/*
$fields = array(
	"start_gmt_timestamp" => array(
		"col_title" => $_LANG["4"]["date"],
		 "col_data" => "\$unit = format_time_stamp(\$f['start_gmt_timestamp'],
 \$_SESSION[\"de_sit\"][\"usr_time_decal\"] , 
\$_LANG[\"txt_usr_time_decals\"],
  \$_LANG[\"months\"], \$_LANG[\"week_days\"]);"
		 	),
			
	"usr_name" => array(
		"col_title" => $_LANG["4"]["usr_name"],
		 "col_data" => "\$unit =  retournerHref(\"?module_id=4&usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]);"
		 	),
			
	"session_id" => array(
		"col_title" => $_LANG["4"]["session_id"],
		 "col_data" => "\$unit =  \$f[\"session_id\"];"
		 	),
			
	"adresse_ip" => array(
		"col_title" => $_LANG["4"]["ip"],
		 "col_data" => "\$unit = \$f[\"adresse_ip\"];"
		 	),
			
	"dns" => array(
		"col_title" => $_LANG["4"]["DNS"],
		 "col_data" => "\$unit = \$f[\"dns\"];"
		 	),
	
	"HTTP_USER_AGENT" => array(
		"col_title" => $_LANG["4"]["HTTP_USER_AGENT"],
		 "col_data" => "\$unit = \$f[\"HTTP_USER_AGENT\"];"
		 	),	
			
	"end_gmt_timestamp-start_gmt_timestamp" => array(
		"col_title" => $_LANG["4"]["duree"],
		 "col_data" => "\$unit = format_time_length(\$f[\"end_gmt_timestamp-start_gmt_timestamp\"]);"
		 	)
			);	


*/
//$module_content .= $mon_tableau->OUTPUT();



}
?>

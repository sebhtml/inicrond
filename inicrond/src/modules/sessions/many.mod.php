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
session_id,
start_gmt,
php_session_id, 
 
end_gmt-start_gmt,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
usr_name
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].".usr_id

";

//base url pour le tableau
$base = "?module_id=500";


if(isset($_GET["usr_id"]) AND//un membre...
$_GET["usr_id"] != "" AND
(int) $_GET["usr_id"]
)
{
$sql .= " AND ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"].".usr_id=".$_GET["usr_id"];

$query = "SELECT
usr_name

FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE usr_id=".$_GET["usr_id"].";";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);


$elements_titre = array(
retournerHref("?module_id=8",$_LANG["common"]["8"]),
retournerHref("?module_id=4&usr_id=".$_GET["usr_id"],$fetch_result["usr_name"]),
$_LANG["common"]["500"]

);

// titre
$module_title = retourner_titre($elements_titre);


//$module_content .= retournerTableauXY($tableau2);

}
else
{
	


$elements_titre = array($_LANG["common"]["500"]);

	$module_title = retourner_titre($elements_titre);

}





$fields = array(
	"start_gmt" => array(
		"col_title" => $_LANG["500"]["date"],
		 "col_data" => "\$unit = format_time_stamp(\$f['start_gmt']);"
		 	),
			
	"usr_name" => array(
		"col_title" => $_LANG["4"]["usr_name"],
		 "col_data" => "
		
		 {
		 \$unit =  retournerHref(\"?module_id=4&usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]);
		 }
		 "
		 	),
			
	"php_session_id" => array(
		"col_title" => $_LANG["500"]["session_id"],
		 "col_data" => "\$unit =  retournerHref(\"?module_id=501&session_id=\".\$f[\"session_id\"], \$f[\"php_session_id\"]);"
		 	),
	
			
	"end_gmt-start_gmt" => array(
		"col_title" => $_LANG["500"]["duree"],
		 "col_data" => "\$unit = format_time_length(\$f[\"end_gmt-start_gmt\"]);"
		 	)
			);	
$mon_tableau = new Table_columnS();

$mon_tableau->SET_sql_base($sql);//la requete de base
$mon_tableau->SET_mon_objet($mon_objet);//ok
$mon_tableau->SET_base_url($base);//ok
$mon_tableau->SET_cols($fields);//ok
$mon_tableau->SET__LANG($_LANG);//ok

$module_content .= $mon_tableau->OUTPUT();

$r = $mon_objet->query($sql);
	
	$donnees = array();//données statistiques
/*
$data = array(
		ar40ray(
			"x" => "y",
			"x" => "y"
			
			),
		array(
			"x" => "y",
			"x" => "y"
			)
);
*/
	while($f = $mon_objet->fetch_assoc($r))
	{
	//pour la loi normal
	$donnees []= $f["end_gmt-start_gmt"]/60;//en minutes
	
	//pour la droite de calibration...
		if(isset($Calib_curve_data[($f["start_gmt"]/(60*60*24))]))//est-ce que la date est déjà enregistrée?
		{
		$Calib_curve_data[($f["start_gmt"]/(60*60*24))] ++;//on augmente le nombre de visite pour cette journée.
		}
		else
		{
		$Calib_curve_data[($f["start_gmt"]/(60*60*24))] = 1;
		}
	}//fin du while
	
	$mon_objet->free_result($r);
		
		//pr
$_SESSION["sebhtml"]["loi_normal"] = $donnees;

//
//
//
//$_SESSION["sebhtml"]["loi_normal"] = array(1,1,1,1,1,1,1,1,1,1,1,1,80);
$module_content .= "<br />";
$module_content .= $_LANG["500"]["normal"];
$module_content .= "<br />";

$module_content .= "<img src=\"download.php?loi_normal\" />";
$module_content .= "<br />";
//$bob = array($Calib_curve_data);

/*
$bob = array();
$i = 1000;
while($i--)
{
$bob[$i] = rand(0, 100);
}
*/
//print_r($bob);

/*
$bob = array(
	array(1=>1, 2=>2, 3=>3,4=>2)
	
);
*/

//echo nl2br(print_r($bob, TRUE));

$_SESSION["sebhtml"]["calib_curve"] = array($Calib_curve_data);

//print_r($_SESSION["sebhtml"]["calib_curve"]);

$module_content .= "<br />";

$module_content .= $_LANG["500"]["curve"];
$module_content .= "<br />";
$module_content .= "<br /><img src=\"download.php?calib_curve\" />";
//$module_content .= "ww";

}
?>

<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : modifirer profile
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
include "modules/usr/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

if(isset($_GET["usr_md5_password"]) AND
isset($_GET["usr_name"])

)//le md5 pour changer de password
{

$query = "SELECT
usr_id,
usr_time_decal,
usr_communication_language


   FROM 
   ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." 
   WHERE 
   usr_name='".$_GET["usr_name"]."'
   AND
     usr_md5_password='".$_GET["usr_md5_password"]."'
     ;";

$query_result = $mon_objet->query($query);

$fetch_result = $mon_objet->fetch_assoc($query_result);

//$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

	if(isset($fetch_result["usr_id"]))
	{
	$_SESSION["sebhtml"]["usr_id"] = $fetch_result["usr_id"];
	$_SESSION["sebhtml"]["usr_name"] = $_GET["usr_name"] ;
	
$_SESSION["sebhtml"]["usr_time_decal"] = $fetch_result["usr_time_decal"];
$_SESSION["sebhtml"]["usr_communication_language"] = $fetch_result["usr_communication_language"];
//$_SESSION["sebhtml"]["windows_width"] = $fetch_result["windows_width"];
	}
}
if(isset($_SESSION["sebhtml"]["usr_id"]) ) // usr sulement
{

		

//---------------------
//TITRE
//---------------

$elements_titre = array(
$_LANG["11"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	
	//afficher profile modifier
	if(!isset($_POST["modifierProfile"]))

	{



	$usr_id = $_SESSION["sebhtml"]["usr_id"];
	
	$query = "
	SELECT 
	usr_time_decal,
	usr_communication_language,
	usr_localisation,
	usr_web_site,
	usr_job,
	usr_email,
	usr_hobbies,
	usr_signature,
	usr_status,
	show_email

	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." 
	WHERE 
	usr_id=".$_SESSION["sebhtml"]["usr_id"].";";

	$query_result = $mon_objet->query($query);
	

	$fetch_result = $mon_objet->fetch_assoc($query_result);

	$mon_objet->free_result($query_result);
	
		include "modules/usr/includes/forms/usr_inc.form.php";
		
	}
	else if( $_POST["usr_password"] != $_POST["usr_password_2"])
	{
	$module_content .= $_LANG["11"]["doublePass"];
	}
	else if($_POST["usr_password"] != "" AND
	 !preg_match($_OPTIONS["preg_usr"],  $_POST["usr_password"])
	  )
	{
	$module_content .= $_LANG["11"]["champsIncorrects"];
	}
	else if(!preg_match($_OPTIONS["preg_email"], $_POST["usr_email"] ) )
	{
	$module_content .= $_LANG["11"]["error_email"];
	}
	else if(!preg_match("/http:\/\//", $_POST["usr_web_site"] ) AND
	$_POST["usr_web_site"] != "" )
	{
	$module_content .= $_LANG["11"]["error_website"];
	}
	
	else
	{

	
	
	if(is_file($_FILES["usrs_pics"]["tmp_name"]) AND
	$info = getimagesize($_FILES['usrs_pics']['tmp_name']) AND
	$info[0] <=1000 AND //dimensions
	$info[1] <=1000 
	
	)//ajouter une image
	{
		if(is_file($_OPTIONS["usrs_pics"]."/".$_SESSION["sebhtml"]["usr_id"]))
		{
		unlink($_OPTIONS["usrs_pics"]."/".$_SESSION["sebhtml"]["usr_id"]);//supprime l'image.
		}
	
	copy($_FILES['usrs_pics']['tmp_name'], 
	$_OPTIONS["usrs_pics"]."/".$_SESSION["sebhtml"]["usr_id"]);
//	$module_content .= "fddd";
	}
	
	//enlever l'image
	
	elseif(
	isset($_POST["remove_usrs_pics"]) AND // on enlève le picture.
	is_file($_OPTIONS["usrs_pics"]."/".$_SESSION["sebhtml"]["usr_id"]))
	{
	unlink($_OPTIONS["usrs_pics"]."/".$_SESSION["sebhtml"]["usr_id"]);//supprime l'image.
	}


	$usr_id = $_SESSION["sebhtml"]["usr_id"];

	$usr_time_decal = $_POST["usr_time_decal"];
	$usr_communication_language = filter($_POST["usr_communication_language"]);
	$usr_localisation = filter($_POST["usr_localisation"]);
	$usr_web_site = filter($_POST["usr_web_site"]);
	$usr_job = filter($_POST["usr_job"]);
	$usr_hobbies = filter($_POST["usr_hobbies"]);
	$usr_email = filter($_POST["usr_email"]);
	$usr_status = filter($_POST["usr_status"]);
	$usr_signature = filter($_POST["usr_signature"]);

	$show_email = isset($_POST["show_email"]) ? 1 : 0 ;//montrer son courriel ??
	
		//$//["UPDATE"] ++; // comptage
		
	$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." SET
	";

		if ($_POST["usr_password"] != "")
		{
		$usr_md5_password = md5($_POST["usr_password"]);

		//include "includes/fonctions/fonctions_cryptage_inc.php";

		//$usr_crypted_password = sebhtml_encrypt($_POST["usr_password"], 2, 7);
		$query .= "
		usr_md5_password='$usr_md5_password',
		
		";
		}

	$query .= "
	usr_time_decal=$usr_time_decal,
	usr_communication_language='$usr_communication_language', 
	usr_localisation='$usr_localisation',
	usr_web_site='$usr_web_site',
	usr_job='$usr_job',
	usr_hobbies='$usr_hobbies',
	usr_email='$usr_email',
	usr_status='$usr_status',
	usr_signature='$usr_signature',
	show_email=$show_email

	WHERE

	usr_id=$usr_id
	";

//	die($query);//debug
	
	//die($query);//debug

	$mon_objet->query($query);
	
//miet à jour
	$_SESSION["sebhtml"]["usr_communication_language"] =  $usr_communication_language ;
	$_SESSION["sebhtml"]["usr_time_decal"] = $usr_time_decal ;


	$_SESSION["sebhtml"]["windows_width"] = $_POST["windows_width"] ;//;largeur
	
	//$module_content .= $_POST["windows_width"] ;//debug
	
	//echo js_redir("./?module_id=$module_id&ok");
	
	$module_content .= $_LANG["11"]["profileModified"];
	
	}

}


?>

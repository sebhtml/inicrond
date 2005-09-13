<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : *MODULE dAJOUT d'UTILISATEUR
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
/*
*

*
*
*
*/

//inclue les  donnees de validation
//include "includes/donnees/donnees_validation_inc.php";


$elements_titre = array(
$_LANG["7"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

//si pas de soumission
if(!isset($_POST["soumissionAjoutUtilisateur"]))
	{
	//terme général
	$module_content .= $_OPTIONS["preg_usr"] ;
	$module_content .= "<br />" ;

	//inclusion du formulaire

	include "modules/usr/includes/forms/signin.form.php";
	
	}

//sinon il y a eu soumission

//expressions régulières
 else if (!preg_match($_OPTIONS["preg_usr"], $_POST["usr_name"] ) ||
  !preg_match($_OPTIONS["preg_usr"], $_POST["usr_password"] ) ||
  !preg_match($_OPTIONS["preg_email"], $_POST["usr_email"] )  )
	{
	$module_content .= $_LANG["11"]["champsIncorrects"];
	}
//doublon mot de passe
else if ($_POST["usr_password"] != $_POST["usr_password_2"])
	{
	$module_content .= $_LANG["11"]["doublePass"];
	}
	

//si l'utilisateur n'existe pas, on l'ajoute...

else 
{


$usr_name = $_POST["usr_name"];
	

//$queries["SELECT"] ++; // comptage


$query = "SELECT usr_name FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." WHERE usr_name='$usr_name'";

$query_result = $mon_objet->query($query);

$result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

	if($result > 0)
	{
	//le nom est déjà pris
	$module_content .= $_LANG["7"]["dejaPris"];
	}
	else
	{
$usr_add_gmt_timestamp = gmmktime();

$usr_md5_password = md5($_POST["usr_password"]);

//include "includes/fonctions/fonctions_cryptage_inc.php";

//$usr_crypted_password = sebhtml_encrypt($_POST["usr_password"], 2, 7);

$usr_email = $_POST["usr_email"];

//$queries["INSERT"] ++; // comptage

$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." (
usr_name,
usr_md5_password,

usr_add_gmt_timestamp,
usr_email
) VALUES (
'$usr_name',
'$usr_md5_password',

$usr_add_gmt_timestamp,
'$usr_email'
) ;";

		if(!$mon_objet->query($query))
		{
		$module_content .= $mon_objet->error();
		}
		else
		{


		$content = ""."
		".
		
		$_LANG["4"]["usr_name"]." : ".$_POST["usr_name"]."
		".
		$_LANG["4"]["usr_password"]." : ".$_POST["usr_password"]."
		
		".$_LANG["email_footer"];
		
			if(mail($_POST["usr_email"], $_LANG["7"]["mail_subject"], $content))//j'm sendmail
			{
			$module_content .= $_LANG["14"]["send_email"];
			}
			else
			{
			$module_content .= $_LANG["14"]["error_send_email"];
			}
		}
	
	
	}

	
}
?>

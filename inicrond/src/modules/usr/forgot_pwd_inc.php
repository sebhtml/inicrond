<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : oublier password
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

$module_title = "";
$module_content  = "";

//---------------------
//TITRE
//---------------

$elements_titre = array(
$_LANG["14"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

if(!isset($_POST["envoi"]))
{

include "modules/usr/includes/forms/forgot_PW.form.php";

}
else
{


$usr_name = $_POST["usr_name"];
//$queries["SELECT"] ++; // comptage

$query = "SELECT
 usr_email,
 usr_name,
  usr_md5_password
   FROM 
   ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." 
   WHERE 
   usr_name='".$_POST["usr_name"]."'";

$query_result = $mon_objet->query($query);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

	if($row_result != 1)
	{
	$module_content .= $_LANG["9"]["UtilisateurExistePas"];
	}
	else
	{

//include "includes/fonctions/fonctions_cryptage_inc.php";

//$usr_password = sebhtml_decrypt($fetch_result["usr_crypted_password"], 2, 7);

$content = $_LANG["14"]["the_text"].retournerHref($_OPTIONS["addr"].
"/index.php?module_id=11&usr_md5_password=".$fetch_result["usr_md5_password"].
"&usr_name=".$fetch_result["usr_name"], $_LANG["14"]["profil"])."."."

".$_LANG["email_footer"];

//die($content);//debug

		if(mail($fetch_result["usr_email"], $_LANG["14"]["subject"], $content))//j'm sendmail
		{
		$module_content .= $_LANG["14"]["send_email"];
		}
		else
		{
		$module_content .= $_LANG["14"]["error_send_email"];
		}

	}

}

?>

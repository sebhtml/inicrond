<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : login
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
$layout_contenu = "";

/*



	//analyse la soumission		
	if (isset($_POST["soumission"]))//demande de login
	{
	
		
	$query = "SELECT
	usr_id,
	usr_time_decal,
	usr_communication_language,
	usr_activation

	FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	usr_name='".$_POST["usr_name"]."'
	AND
	usr_md5_password='".md5($_POST["usr_password"])."'
	";

$query_result = $mon_objet->query($query);
		

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		//$rows_result = mysql_num_rows($query_result);

		$mon_objet->free_result($query_result);


		//trouve le user et v�ifie le pass
		if( isset($fetch_result["usr_activation"]) AND
		$fetch_result["usr_activation"]  == 0 
		)//usr pas activ�
		{
		$layout_contenu .= $_LANG["txt_login"]["Activation"];
		}
		

		else//pas trouv�
		{
		$layout_contenu .= $_LANG["txt_login"]["AccesDenied"]; 
		//forumlaire pour se loguer
include "includes/layout/includes/forms/login_inc.form.php";
		}
	}
	//pas de soumission et pas de session	
	else 
	{
		//forumlaire pour se loguer

	}
*/

if(isset($tmp["error"]))//erreur
{
$layout_contenu .= $tmp["error"];
}
if(!isset($_SESSION["sebhtml"]["usr_id"]))
{
include "includes/layout/includes/forms/login_inc.form.php";
}

}
 
?>



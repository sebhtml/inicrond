<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : add/edit galerie
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : Minicrond
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
include "modules/galery/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}




if(isset($_SESSION["sebhtml"]["usr_id"] ) AND
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet)) //admin seulement
{



	

	if($_GET["mode_id"] == 0)
	{
	
//-----------
//titre de la page::
//--------------
$elements_titre = array(
$_LANG["16"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

		if(!isset($_POST["envoi"]))
		{

		$uploaded_files_section_name_value = "";

		include "modules/galery/includes/forms/section_inc.form.php";
		}
		else
		{



		//$galerie_name = ;


		$query = "INSERT
		 INTO 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		(
		galerie_name,
		right_add_an_img
		)
		VALUES
		(
		'".filter($_POST["galerie_name"])."',
		".$_POST["right_add_an_img"]."
		)";

			if($mon_objet->query($query))
			{
					echo js_redir("?module_id=10");
					exit();
			}
			else
			{
			$module_content .= $mon_objet->error();
			}
		}
	}
	else if($_GET["mode_id"] == 1 AND
	isset($_GET["galerie_id"]) AND
	$_GET["galerie_id"] != "" AND
	(int) $_GET["galerie_id"]
	)
	{


//-----------
//titre de la page::
//--------------
$elements_titre = array(
 $txtmod_5["edit"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);
			//--------------
			// existe-il ??
			//-------------

			$query = "SELECT
			  galerie_name,
			  right_add_an_img
			  FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
			   WHERE galerie_id=".$_GET["galerie_id"]."
			   ";

			$query_result = $mon_objet->query($query);


			//$num_row = $mon_objet->num_rows($query_result);

			
			$fetch_result = $mon_objet->fetch_assoc($query_result);

			$mon_objet->free_result($query_result);


			if(!isset($_POST["envoi"]))
			{
			//$uploaded_files_section_name_value = ;

		include "modules/galery/includes/forms/section_inc.form.php";
			}
			else//on changer les choses
			{

		// filtrage des données



			$galerie_name = filter($_POST["galerie_name"]);


			$query = "UPDATE
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
			SET
			galerie_name='$galerie_name',
			right_add_an_img=".$_POST["right_add_an_img"]."
			WHERE
			galerie_id=".$_GET["galerie_id"]."
			";

				if($mon_objet->query($query))
				{
			//
			echo js_redir("?module_id=10");
			exit();
				}
				else
				{
				$module_content .= $mon_objet->error();
				}
			}

		
	
	}

}
?>



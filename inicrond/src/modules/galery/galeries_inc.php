<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : liste des galeries
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
//-------------------

//--------------------
include "modules/galery/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
//------------------
//enlever une galerie
//-------------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
		is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND
		isset($_GET["galerie_id"]) AND
$_GET["galerie_id"] != "" AND
(int) $_GET["galerie_id"]
)
{//début de la section pour enleer une galerie
	if(!isset($_POST["envoi"]))//pas d'envoi, formulaire
	{
	$module_content .= $_LANG["10"]["transfer_img"];//message.
	
	//---------------
		//la liste déroulante :::
		//----------------
		$module_content .= "<form method=\"POST\">
		<select name=\"galerie_id\" >";
		
		//-----------
		
		//------------
		
						
		//$queries["SELECT"] ++; // comptage
			
		$query = "SELECT
		galerie_id, galerie_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		
		;";

		$query_result = $mon_objet->query($query);
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{

		 	if($fetch_result["galerie_id"] !=
		$_GET["galerie_id"]
			)//la galerie courante: on n'en veut pas.
			{
			$module_content .= "<OPTION ";
			$module_content .=  " VALUE=\"".
			$fetch_result["galerie_id"]."\">".
			$fetch_result["galerie_name"]."</OPTION>";
			}
			
		}

		$mon_objet->free_result($query_result);
		
		//fermeture du formulaire
		  $module_content .= "</select>
		  <input type=\"submit\"
		   name=\"envoi\" value=\"".$_LANG["txtBoutonForms"]["ok"]."\" />	
		   </form>";
		   
	}
	elseif(isset($_POST["galerie_id"]) AND
	$_POST["galerie_id"] != "" AND
	(int) $_POST["galerie_id"]
	)//on fait les changements
	{
	//$queries["UPDATE"] ++; // comptage
			
		$query = //on change les images de galerie
		 "UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
		SET
		galerie_id=".$_POST["galerie_id"]."
		WHERE
		galerie_id=".$_GET["galerie_id"]."
		
		;";

		$query_result = $mon_objet->query($query);
		
	//	$queries["DELETE"] ++; // comptage
			
		$query = //onm supprime la galerie..
		 "DELETE
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		
		WHERE
		galerie_id=".$_GET["galerie_id"]."
		
		;";

		$query_result = $mon_objet->query($query);
		
		
	}
}//fin de la section pour enlever une galerie

//---------------------
//TITRE
//---------------

$elements_titre = array(
$_LANG["10"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



//	$queries["SELECT"] ++; // comptage
$query = "SELECT
 galerie_id,  galerie_name
  FROM 
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
  
ORDER BY galerie_name ASC
;";

$query_result = $mon_objet->query($query);

$tableau = array();//tableau que l'on va remplir

$tableau []= array($_LANG["10"]["galerie"], $_LANG["10"]["count_img"]);//la première ligne...

	while($fetch_result = $mon_objet->fetch_assoc($query_result)) 
	{
	
	$ligne = array();//la ligne que l'on bvetu remplir.
	
	
	$colonne = 	
	retournerHref("?module_id=12&galerie_id=".$fetch_result["galerie_id"], 
	$fetch_result["galerie_name"]) ;
	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
		is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet)
		)
		{
	//lien pour l'enlever
	$colonne .= " (";
	$colonne .= retournerHref("?module_id=10&galerie_id=".$fetch_result["galerie_id"], 
	$_LANG["10"]["remove_galerie"]) ;
	$colonne .= $_OPTIONS["separator"]. retournerHref("?module_id=16&mode_id=1&galerie_id=".$fetch_result["galerie_id"],
		 $_LANG["common"]["edit"]);
	$colonne .=  ")";
	
		
	//fin du lien pour enlever
		}
//--------------
	//droits
	//---------------
	$galerie_id = $fetch_result["galerie_id"];//pour tantot
	$tableau2 = array();
		$sql = 
		"SELECT
		right_add_an_img
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		WHERE
		
		galerie_id=".$fetch_result["galerie_id"]."
		;";
		
		$query_result2 = $mon_objet->query($sql);
		
		
		$fetch_result = $mon_objet->fetch_assoc($query_result2);
		
			
		$mon_objet->free_result($query_result2);
	
		
		if($fetch_result["right_add_an_img"] == 0)
		{
		$group_name = $_LANG["28"]["all"];
		}
		else
		{
		$group_name = retournerHref("?module_id=22&group_id=".$fetch_result["right_add_an_img"],
		group_name($fetch_result["right_add_an_img"] , $mon_objet));
		}
		$tableau2[] = array($_LANG["10"]["right_add_an_img"], 
		$group_name);
		
		//$query_result = $mon_objet->query($sql);
		
	
		
		//$fetch_result = $mon_objet->fetch_assoc($query_result);
		$colonne .= "<br />";
		$colonne .= "<small>". $_LANG["23"]["droits"]."</small>";
			$colonne .= retournerTableauXY($tableau2, "");
		
	$ligne []= $colonne ;//la premiere colonne.
	
	$query = "SELECT 
	count(image_id) 
	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
	 WHERE 
	 galerie_id=".$galerie_id."
	 ;";

	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);
	
	$ligne []= "".$fetch_result["count(image_id)"]."";
	//$module_content .= "<br />";
	
	$tableau [] = $ligne;//on ajoute la ligne...
	}//fin du while

$mon_objet->free_result($query_result);



	
if(isset($_SESSION["sebhtml"]["usr_id"]) AND
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet))
{
$module_content .= "<br />";

$module_content .= retournerHref("?module_id=16&mode=0", $_LANG["16"]["titre"]);//ajouter une galerie
}

$module_content .= retournerTableauXY($tableau);//le tableau à afficher...
?>
<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : téléchargemements
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
include "modules/files/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
//------------------
//enlever une dl section
//-------------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet) AND
 isset($_GET["uploaded_files_section_id"]) AND
$_GET["uploaded_files_section_id"] != "" AND
(int) $_GET["uploaded_files_section_id"]
)
{//début de la section pour enleer une dl section
	if(!isset($_POST["envoi"]))//pas d'envoi, formulaire
	{
	$module_content .= $_LANG["1"]["transfer_dl"];//message.
	
	//---------------
		//la liste déroulante :::
		//----------------
		$module_content .= "<form method=\"POST\">
		<select name=\"uploaded_files_section_id\" >";
		
		//-----------
		
		//------------
		
						
		$queries["SELECT"] ++; // comptage
			
		$query = "SELECT
		uploaded_files_section_id, uploaded_files_section_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
		
		;";

		$query_result = $mon_objet->query($query);
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{

		 	if($fetch_result["uploaded_files_section_id"] !=
		$_GET["uploaded_files_section_id"]
			)//la galerie courante: on n'en veut pas.
			{
			$module_content .= "<OPTION ";
			$module_content .=  " VALUE=\"".
			$fetch_result["uploaded_files_section_id"]."\">".
			$fetch_result["uploaded_files_section_name"]."</OPTION>";
			}
			
		}

		$mon_objet->free_result($query_result);
		
		//fermeture du formulaire
		  $module_content .= "</select>
		  <input type=\"submit\"
		   name=\"envoi\" value=\"".$_LANG["txtBoutonForms"]["ok"]."\" />	
		   </form>";
		   
	}
	elseif(isset($_POST["uploaded_files_section_id"]) AND
	$_POST["uploaded_files_section_id"] != "" AND
	(int) $_POST["uploaded_files_section_id"]
	)//on fait les changements
	{
	$queries["UPDATE"] ++; // comptage
			
		$query = //on change les images de galerie
		 "UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
		SET
		uploaded_files_section_id=".$_POST["uploaded_files_section_id"]."
		WHERE
		uploaded_files_section_id=".$_GET["uploaded_files_section_id"]."
		
		;";

		$query_result = $mon_objet->query($query);
		
		$queries["DELETE"] ++; // comptage
			
		$query = //onm supprime la galerie..
		 "DELETE
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
		
		WHERE
		uploaded_files_section_id=".$_GET["uploaded_files_section_id"]."
		
		;";

		$query_result = $mon_objet->query($query);
		
		
	}
}//fin de la section pour enlever une dl section

//-----------------------
// titre
//---------------------


$elements_titre = array($_LANG["1"]["titre"]);

$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



	//$queries["SELECT"] ++; // comptage
 
$query = "SELECT uploaded_files_section_id,  uploaded_files_section_name FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
ORDER BY uploaded_files_section_name ASC
;";

$query_result = $mon_objet->query($query);

$tableau = array();//tableau qui sera évidemment rempli beaucoup en fonction des choses qui sont fournies.

$tableau []= array($_LANG["1"]["section"], $_LANG["1"]["count_files"]);//première ligne du tableau.

	while($fetch_result = $mon_objet->fetch_assoc($query_result)) 
	{
	$ligne = array();//la ligne courante est vide à l'heure actuelle.
	
	$colonne = retournerHref("?module_id=5&uploaded_files_section_id=".//le lien vers cette section.
	$fetch_result["uploaded_files_section_id"], $fetch_result["uploaded_files_section_name"]) ;
	
	
	
		if(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
		is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet)//administratuer seulement. (group_id == 1;)
		)//fermeture du if conditionnel.
		{//ici commence l'acollade du if
		//--------------
		//le lien ici pour l'enlever.
		//------------
		$colonne .= " (";//une parenthe à acfficher
		$colonne .= retournerHref("?module_id=1&uploaded_files_section_id=".
		$fetch_result["uploaded_files_section_id"],
		$_LANG["1"]["remove_it"]) ;//le lien pour enlever la section.
	

		$colonne .= $_OPTIONS["separator"];
		$colonne .= retournerHref("?module_id=17&mode_id=1&uploaded_files_section_id=".
		$fetch_result["uploaded_files_section_id"],
		 $_LANG["5"]["edit"]);
			$colonne .= ")";//une belle fermeture de parenthèse
		}//ici finit l'acollade du if
	//$module_content .= "<br />";//debuguage ???
		
	//--------------
	//droits
	//---------------
	$uploaded_files_section_id = $fetch_result["uploaded_files_section_id"];//pour tantot
	$tableau2 = array();
		$sql = 
		"SELECT
		right_add_a_file
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
		WHERE
		
		uploaded_files_section_id=".$fetch_result["uploaded_files_section_id"]."
		;";
		
		$query_result2 = $mon_objet->query($sql);
		
		
		$fetch_result = $mon_objet->fetch_assoc($query_result2);
		
			
		$mon_objet->free_result($query_result2);
	
		
		if($fetch_result["right_add_a_file"] == 0)
		{
		$group_name = $_LANG["28"]["all"];
		}
		else
		{
		$group_name = retournerHref("?module_id=22&group_id=".$fetch_result["right_add_a_file"],
		group_name($fetch_result["right_add_a_file"] , $mon_objet));
		}
		$tableau2[] = array($_LANG["17"]["right_add_a_file"], 
		$group_name);
		
		//$query_result = $mon_objet->query($sql);
		
	
		
		//$fetch_result = $mon_objet->fetch_assoc($query_result);
		$colonne .= "<br />";
		$colonne .= "<small>". $_LANG["23"]["droits"]."</small>";
			$colonne .= retournerTableauXY($tableau2, "");
		
			
			
	$ligne []= $colonne ; //ajout de la belle colonne.
	
	//$uploaded_files_section_id = $fetch_result["uploaded_files_section_id"];
	
		$queries["SELECT"] ++; // comptage
	$query_2 = "SELECT count(uploaded_file_id)
	 FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]." WHERE uploaded_files_section_id=".
	 $uploaded_files_section_id."";//requete pour compter les fichier des cette section

	$query_result_2 = $mon_objet->query($query_2);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);
	
	$ligne []= "".$fetch_result["count(uploaded_file_id)"]."";
	
	$tableau []= $ligne;//on ajoute la ligne au beau et grand tableau. 25 sept 2004.
	
	}//fin de la boucle while
	

$mon_objet->free_result($query_result);//libération des ressources MySQL.. allouées


$module_content .= retournerTableauXY($tableau);//on print le tableau.

	
if(isset($_SESSION["sebhtml"]["usr_id"]) AND//y a t il un membre en ligne
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet))//si oui, est-il administrateurs ?
{//début du if
$module_content .= "<br />";//saut de ligne en html , ça veut dire break line.

$module_content .= retournerHref("?module_id=17", $_LANG["17"]["titre"]);//echoLienModule(17);
}//fin du if

?>

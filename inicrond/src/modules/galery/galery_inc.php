<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir une galerie
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
else
{
	if((isset($_GET["galerie_id"]) AND
	$_GET["galerie_id"] != "" AND
	(int) $_GET["galerie_id"]
	))
	
	{
		

		$query = "SELECT 
		galerie_name 
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		WHERE 
		galerie_id=".$_GET["galerie_id"]."
		;";

			if(!$query_result = $mon_objet->query($query))
			{
			die($query." ".$mon_objet->error());
			}
			
		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);
		
		
$elements_titre = array(
retournerHref("?module_id=10", $_LANG["10"]["titre"]),
$fetch_result["galerie_name"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



	
		if(right_add_an_img($_SESSION["sebhtml"]["usr_id"], $_GET["galerie_id"], $mon_objet)
		)
		{
		$module_content .= "<br />";
		$module_content .= retournerHref("?module_id=18&galerie_id=".$_GET["galerie_id"],
		$_LANG["18"]["titre"]);//ajouter une image ??

		}
	$query = "SELECT 
	image_title, image_id, file_name,
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE 
	galerie_id=".$_GET["galerie_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].".usr_id
	ORDER BY 
	edit_gmt_timestamp DESC
	;";
$query_result =  $mon_objet->query($query);


	$result = array();

	$ligne = array();
	
		while($r = $mon_objet->fetch_assoc($query_result)) 
		{
		/*
		$alt = $r["image_title"].
		$r["file_name"].
		filesize($_OPTIONS["images_dir"]."/".$r["image_id"]).
		$r["usr_id"]
		;
		*/
	
	$query = "SELECT 
	count(session_id) AS nb_views
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_images"]."
	WHERE
	image_id=".$r["image_id"]."
	;";
	
	$query_result_2 = $mon_objet->query($query);
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	$mon_objet->free_result($query_result_2);

		$r["nb_views"] = $fetch_result["nb_views"];
		
	//	$queries["SELECT"] ++; // comptage dans download
		
			if(count($ligne) != 3)
			{
			
$image_info = getimagesize($_OPTIONS["images_dir"]."/".$r["image_id"]);
	
			$ligne[] = "<p align=\"center\">".retournerHref("?module_id=13&image_id=".$r["image_id"],
			"<img src=\"download.php?miniatures=".$r["image_id"]."\" border=\"0\"  
				 />")."".
				" <br /><small>".
				$r["file_name"]."<br />".
				$image_info["0"]." X ".$image_info["1"]."<br />".
				fileSize($_OPTIONS["images_dir"]."/".$r["image_id"])." ".$_LANG["txt_footer"]["octets"]."<br />".
				 $r["nb_views"].$_LANG["12"]["clics"].
				 "</small>
				 </p>";
			}
			else
			{
			$result[] = $ligne;
			
			$ligne = array();
				
			$ligne[] = "<p align=\"center\">".retournerHref("?module_id=13&image_id=".$r["image_id"],
			"<img src=\"download.php?miniatures=".$r["image_id"]."\" border=\"0\"  
				 />")."".
				" <br /><small>".
				$r["file_name"]."<br />".
				$image_info["0"]." X ".$image_info["1"]."<br />".
				fileSize($_OPTIONS["images_dir"]."/".$r["image_id"])." ".$_LANG["txt_footer"]["octets"]."<br />".
				 $r["nb_views"].$_LANG["12"]["clics"].
				 "</small>
				 </p>";
			}
		
		}

		$result[] = $ligne;//la derniere ligne
		
	$mon_objet->free_result($query_result);

	$module_content .= retournerTableauXY($result);
	}

}
?>



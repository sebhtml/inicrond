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
$_OPTIONS["INCLUDED"] = TRUE;

//----------
//Classes de formulaire
//--------------
include "includes/class/form/Base.class.php";//classe de base pour les formulaires.
include "includes/class/form/Form.class.php";
include "includes/class/form/Hidden.class.php";
include "includes/class/form/File_.class.php";
include "includes/class/form/Textarea.class.php";
include "includes/class/form/Submit.class.php";
include "includes/class/form/Text.class.php";
include "includes/class/form/Radio.class.php";
include "includes/class/form/Checkbox.class.php";
include "includes/class/form/Password.class.php";
include "includes/class/form/Select.class.php";
include "includes/class/form/Option.class.php";

//
//FORMULAIRE AVEC DES REQUÊTESé.
//

include "includes/class/form/sql/Select_with_sql.class.php";

include "includes/class/Table_columnS.class.php";
//include "includes/class/Table_columnS.class.php";//loi normal



//------------
//autre classes
//------------
include "includes/class/Month_calendar.class.php";//la classe calendrier.
include "includes/class/Window_layout.class.php";//la classe calendrier.


//--------------
//fonctions
//---------------
include "includes/func/fonctions_autres_inc.function.php";//echotableau
include "includes/func/fonctions_Liens_inc.function.php";//echHref
include "includes/func/titre_inc.function.php";//titre
include "includes/func/fonctions_date_inc.function.php" ;//date
include "includes/func/BBcode.function.php";//parser BBcode
include "includes/func/fonctions_access_inc.function.php";
include "includes/func/statistiques.function.php";//statistiques
include "includes/func/fonctions_validation_inc.function.php";//filtrage de données

include "includes/func/js_redir.function.php";//javascript redirection

include "includes/kernel/db_init.php";


include $_OPTIONS["file_path"]["opt_in_mysql"];//les options comme l'heure...
include "includes/etc/colors.inc.php";


  
session_start();//session.




$_SESSION["sebhtml"]["usr_time_decal"] = isset( $_SESSION["sebhtml"]["usr_time_decal"]) ?
 $_SESSION["sebhtml"]["usr_time_decal"] : $_OPTIONS["usr_time_decal"];

$_SESSION["sebhtml"]["usr_communication_language"] = isset( $_SESSION["sebhtml"]["usr_communication_language"]) ?
$_SESSION["sebhtml"]["usr_communication_language"] : $_OPTIONS["language"];
 
	if($_SESSION["sebhtml"]["usr_communication_language"] == "fr")
	{
	include "includes/lang/fr/index_inc.php";
	}
	elseif($_SESSION["sebhtml"]["usr_communication_language"] == "en")
	{
	include "includes/lang/en/index_inc.php";
	}
if(isset($_GET["end"]))
{

include "includes/kernel/logout_inc.php";//dÃ©connexion";
}

include "includes/kernel/log_in.kernel.php";//loguage

include "includes/kernel/update_lang.kernel.php";//update le language.

//inclure les donnees messages

 //inclue les autres fonctions


	$module_path = is_file($_OPTIONS["modules"][$_GET["module_id"]]) 
	? $_OPTIONS["modules"][$_GET["module_id"]] : $_OPTIONS["modules"][$_OPTIONS["default_module_id"]] ;


include "includes/kernel/set_sess_offline.kernel.php" ;//met à jour les sessions.

include "includes/kernel/visits_tracker_inc.php" ;//met Ã  jour les sessions.

include $module_path;
				
//après l'inclusion du module...
//include "includes/kernel/visits_tracker_inc.php" ;//met Ã  jour les sessions.
	
			
//pour le titre


		$output .= "
<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>



<!--mÃƒÂ©ta tags -->
		<META NAME=\"Author\" CONTENT=\"sebastien boisvert (oloko.cjb.net)\" />
		<META NAME=\"Description\" CONTENT=\"mon site web\" />
		<META NAME=\"Keywords\" LANG=\"fr\" CONTENT=\"sebhtml, php, MySQL\" />
		<META NAME=\"Identifier-URL\" CONTENT=\"http://membres.lycos.fr/\" />
		<META NAME=\"Date-Creation-yyyymmdd\" content=\"".gmdate("Ymd")."\" />

		<META NAME=\"Date-Revision-yyyymmdd\" content=\"".gmdate("Ymd")."\" />
		<META NAME=\"Robots\" CONTENT=\"index,follow,all\" />
		<META NAME=\"revisit-after\" CONTENT=\"30 days\" />
		<META NAME=\"Reply-to\" CONTENT=\"sebhtml@yahoo.ca\" />
		<META NAME=\"Category\" CONTENT=\"dev\" />
		<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=ISO-8859-1\" />
<style  type=\"text/css\">";
  include "includes/css_style/css_inc.php";

  $output .= "
</style>
	
  <title>
 ".unhtmlentities(strip_tags(
$module_title))
."

  </title>
</head>
<body>

	<table border=\"0\"  cellpadding=\"0\" cellspacing=\"5\" width=\"". "100%"."\">
		
		<tr>
			<td colspan=\"2\" >";
			
			include "includes/layout/header.block.php"; 

							
		 $output .="	</td>
		</tr>
	
		<tr>
			
			<td valign=\"top\" width=\"200\" >
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"5\">
			<tr><td>
			";
			
		//menu principal
		include "includes/layout/menu_principal_inc.block.php" ;
		$my_window = new Window_layout($_LANG["txt_windows"]["menu_princi"], $layout_contenu);
		$output .= $my_window->output();
		
		 $output .= "</td></tr><tr><td>";
		
		//intéractivité
		include "includes/layout/inter_inc.block.php" ;
		$my_window = new Window_layout($_LANG["txt_windows"]["inter"], $layout_contenu);
		$output .= $my_window->output();
		
				 $output .= "</td></tr><tr><td>";
		
				 
		 //changer le language
		include "includes/layout/lang.block.php" ;
		$my_window = new Window_layout($_LANG["txt_windows"]["lang"], $layout_contenu);
		$output .= $my_window->output();
		
		 $output .= "</td></tr><tr><td>";
				
				 	 
		//personne en ligne
		include "includes/layout/online_ppl_inc.block.php" ;
		$my_window = new Window_layout($_LANG["txt_windows"]["online_ppl"], $layout_contenu);
		$output .= $my_window->output();
		
		 $output .= "</td></tr><tr><td>";
				 
		//calendrier.
		
		$thing = getdate(gmmktime()+$_SESSION["sebhtml"]["usr_time_decal"]*60*60);
		include "includes/layout/calendar_inc.block.php" ;
		$my_window = new Window_layout(
		retournerHref("?module_id=44&year=".$thing["year"]."&month=".$thing["mon"], $_LANG["months"][$thing["mon"]])." ".
		retournerHref("?module_id=44&year=".$thing["year"], $thing["year"]), 
		$layout_contenu
		);
		$output .= $my_window->output();
			
		 $output .= "</td></tr>
		 </table>";
				 
		$output .= "</td>
				
		
			<td valign=\"top\" width=\"100%\">
			
			";
		
		//contenu
		$my_window = new Window_layout(
		"".$module_title.""."".
		"", 
$module_content);
		$output .= $my_window->output();
				
				
			$output .= "</td>
		
		</tr>
				
		<tr>
			<td colspan=\"2\" >
			
			
";
						//
			include "includes/layout/footer_inc.block.php"; 
						
							
		"	</td>
		</tr>
	</table>	
			

			 

</body>
</html>";

echo $output;

?>





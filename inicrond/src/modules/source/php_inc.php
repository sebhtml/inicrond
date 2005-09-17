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
include "modules/source/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";

if(isset($_OPTIONS["INCLUDED"]))
{

	if(
	isset($_GET["php_file"]) AND
	$_GET["php_file"] != "" AND
	!strstr("..", $_GET["php_file"]) AND //pas de .. AND
	$_GET["php_file"]["0"] != "/" AND //pas le root pour la sécurité.
	is_file($_GET["php_file"]//est-ce un fichier?
	)
	)
	{
//---------------------
//TITRE
//---------------

$elements_titre = array(
$_LANG["43"]["titre"]
);
// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

$module_content .= "<b>".$_GET["php_file"]."</b><br />";
		
	$content = highlight_file($_GET["php_file"], TRUE);//le parseur de couleur intégré...
	
	if($content == "")//si la fonction ne fonctionne pas comme c'Est le cas chez multimania...
	{
	$fp = fopen($_GET["php_file"], "r");
	$content = fread($fp, fileSize($_GET["php_file"]));
	fclose($fp);
	$content = highlight_string($content, TRUE);
	}
	
	$content = preg_replace(
	"/((includes|modules)[^ ]+\.php)/U",
	"<a href=\"?module_id=43&php_file=$1\">$1</a>",
	$content
	);
	
	$module_content .= $content; 
	
	
	}

}





?>
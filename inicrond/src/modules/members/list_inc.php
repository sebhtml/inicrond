<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier :  utilisateurs
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

include "modules/members/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";

if(isset($_OPTIONS["INCLUDED"]))
{

$module_title = "";
$module_content = "";



		//$queries["SELECT"] ++; // comptage

	$sql = "SELECT 
	usr_id, usr_name
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]." 
	WHERE usr_activation=1
	ORDER BY usr_name ASC
	;";

	$query_result = $mon_objet->query($sql);

	$tableau = array();//stocke les résultats

	$tableau[] = array($_LANG["4"]["usr_name"]);

		while($fetch_result = $mon_objet->fetch_assoc($query_result)) 
		{
	$tableau[] = array(retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"],
	$fetch_result["usr_name"]));
		}

	$mon_objet->free_result($query_result);






	//-----------------------
	// titre
	//---------------------


	$elements_titre = array($_LANG["8"]["titre"]);

	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


	$module_content .= retournerTableauXY($tableau);
}
?>

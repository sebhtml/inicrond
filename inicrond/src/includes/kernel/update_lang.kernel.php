<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : personnes en lignes
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

/*

$_LANG["usr_communication_languages"]= array(
"fr" => "Fran&ccedil;ais",
"en" => "Anglais"
);


*/
	
/*

base64_encode($_SERVER["QUERY_STRING"])

*/
if(isset($_LANG["usr_communication_languages"][$_GET["usr_communication_languages"]]))//language demandé
{
//	die("99");

$_SESSION["sebhtml"]["usr_communication_language"] = $_GET["usr_communication_languages"];
//print_r($_SERVER);

	echo js_redir("?".base64_decode($_GET["redirect"]));
	
	//echo js_redir("?".""."".base64_decode($_GET["redirect"]));
	exit();

}
	
//echo $_GET["usr_communication_languages"];//debug


}



?>

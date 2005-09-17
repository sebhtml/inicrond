<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : fichier fr
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
$_LANG["500"]["date"] = "Date";
$_LANG["500"]["session_id"] = "Session PHP";
$_LANG["500"]["duree"] = "Dur&eacute;e";

$_LANG["500"]["normal"] = "Distribution des dur&eacute;es des visites" ;
$_LANG["500"]["curve"] = "Nombre de visites en fonction du temps" ;

$_LANG["500"]["dns"] = "Le nom de la machine";
$_LANG["500"]["is_online"] = "Est-t-il en ligne?";
$_LANG["500"]["end_gmt"] = "Date de la fin de la visite";
$_LANG["500"]["start_gmt"] = "Date du d&eacute;but de la visite";
$_LANG["500"]["end_gmt-start_gmt"] = $_LANG["500"]["duree"];
$_LANG["500"]["REMOTE_PORT"] = "Port de la machine cliente";
$_LANG["500"]["REMOTE_ADDR"] = "Adresse de la machine cliente";
//$_LANG["500"]["REMOTE_HOST"] = "REMOTE_HOST";
$_LANG["500"]["HTTP_USER_AGENT"] = "Navigateur de la machine";
$_LANG["500"]["HTTP_CONNECTION"] = "Type de connexion";
$_LANG["500"]["HTTP_KEEP_ALIVE"] = "Dur&eacute;e du garder en vie";
$_LANG["500"]["HTTP_ACCEPT_CHARSET"] = "Encodages accept&eacute;es";
$_LANG["500"]["HTTP_ACCEPT"] = "Type de fichiers accept&eacute;s par la machine";
$_LANG["500"]["HTTP_ACCEPT_LANGUAGE"] = "Langues accept&eacute;es";
$_LANG["500"]["HTTP_ACCEPT_ENCODING"] = "Compressions accept&eacute;es";
$_LANG["500"]["php_session_id"] = $_LANG["500"]["session_id"];
$_LANG["500"]["usr_name"] = $_LANG["4"]["usr_name"];

}

?>

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
$_LANG["500"]["session_id"] = "php id";
$_LANG["500"]["duree"] = "Length";


$_LANG["500"]["normal"] = "Length distribution" ;
$_LANG["500"]["curve"] = "Correlation between time and the amount of visits" ;

$_LANG["500"]["dns"] = "DNS";
$_LANG["500"]["is_online"] = "Online status";
$_LANG["500"]["end_gmt"] = "End of the visit";
$_LANG["500"]["start_gmt"] = "Start of the visit";
$_LANG["500"]["end_gmt-start_gmt"] = $_LANG["500"]["duree"];
$_LANG["500"]["REMOTE_PORT"] = "Remote port";
$_LANG["500"]["REMOTE_ADDR"] = "Remote adress";
//$_LANG["500"]["REMOTE_HOST"] = "Remote host";
$_LANG["500"]["HTTP_USER_AGENT"] = "Software";
$_LANG["500"]["HTTP_CONNECTION"] = "Connection";
$_LANG["500"]["HTTP_KEEP_ALIVE"] = "Kepp alive";
$_LANG["500"]["HTTP_ACCEPT_CHARSET"] = "Charset";
$_LANG["500"]["HTTP_ACCEPT"] = "Mime types";
$_LANG["500"]["HTTP_ACCEPT_LANGUAGE"] = "Languages";
$_LANG["500"]["HTTP_ACCEPT_ENCODING"] = "Encoding";
$_LANG["500"]["php_session_id"] = $_LANG["500"]["session_id"];
$_LANG["500"]["usr_name"] = $_LANG["4"]["usr_name"];

}

?>

<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : forum main()
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

include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";


if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}



//----------------
//monter une discussion
//--------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND //admin
isset($_GET["forum_discussion_id"]) AND //on demande-tu ??
$_GET["forum_discussion_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_discussion_id"] AND//chagnement de type
isset($_GET["mode_id"]) AND //mode demandé ??
$_GET["mode_id"] == 0 //
)//
{
include "modules/forum/includes/move/forum_up.php";
}

//----------------
//descendre une discussion
//--------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND //admin
isset($_GET["forum_discussion_id"]) AND //on demande-tu ??
$_GET["forum_discussion_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_discussion_id"] AND//chagnement de type
isset($_GET["mode_id"]) AND //mode demandé ??
$_GET["mode_id"] == 1 //
)//
{
	
include "modules/forum/includes/move/forum_down.php";
}

//-------------
//enlever une discussion
//----------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND //admin
isset($_GET["forum_discussion_id"]) AND //on demande-tu ??
$_GET["forum_discussion_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_discussion_id"] AND //chagnement de type
isset($_GET["mode_id"]) AND //mode demandé ??
$_GET["mode_id"] == 2 //
)//enlever une section
{
include "modules/forum/includes/move/forum_remove.php";
}



//----------------
//monter une section
//--------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND //admin
isset($_GET["forum_section_id"]) AND //on demande-tu ??
$_GET["forum_section_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_section_id"] AND//chagnement de type
isset($_GET["mode_id"]) AND //mode demandé ??
$_GET["mode_id"] == 0 //
)//
{
include "modules/forum/includes/move/section_up.php";
}

//----------------
//descendre une section
//--------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND //admin
isset($_GET["forum_section_id"]) AND //on demande-tu ??
$_GET["forum_section_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_section_id"] AND//chagnement de type
isset($_GET["mode_id"]) AND //mode demandé ??
$_GET["mode_id"] == 1 //
)//
{
	
include "modules/forum/includes/move/section_down.php";
}
//----------------
//enlever une section
//--------------
elseif(isset($_SESSION["sebhtml"]["usr_id"]) AND //session au moins...
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND //admin
isset($_GET["forum_section_id"]) AND //on demande-tu ??
$_GET["forum_section_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_section_id"] AND//chagnement de type
isset($_GET["mode_id"]) AND //mode demandé ??
$_GET["mode_id"] == 2 //
)//enlever une section
{
include "modules/forum/includes/move/section_remove.php";
}

//PAS DE ELSE, CELA AFFICHE LE FORUM ARGH!!

{
include "modules/forum/includes/main_page.php";
}
	


?>

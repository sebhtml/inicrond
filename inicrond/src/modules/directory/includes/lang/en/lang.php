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


$_LANG["38"] = array(
"titre" => "Directory",
"transfer_dl" => "You must transfer the links",
"remove_it" => "Remove",
"section" => "Section",
"count_files" => "Number of ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].""
);
$_LANG["39"] = array(
"titre" => "Add a section",
"right_add_a_file" => "Who can post his/her ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]." here ?",
"language_name" => "Name"
);

$_LANG["40"] = array(
"titre" => "Add a link",

"link_url" => "Link",
//"source_url" => "Fichier",
//"enregistrer" => "Votre requ&ecirc;te a &eacute;t&eacute; enregistr&eacute;e",
//"error_file" => "Vous devez envoyer votre fichier correctement",
"add" => "Add",
"edit" => $_LANG["5"]["edit"],
"rm" => $_LANG["10"]["remove_galerie"],
"remove_now" => "Remove now"
//"new_file" => "Mettre &agrave; jour le fichier"
);

$_LANG["41"] = array(
"edit" => $_LANG["5"]["edit"],
"nb_hits" => "Number of visits on the site posted"
);

$_LANG["42"] = array(
"go" => "Visit the site"

);

$_LANG["42"]["curve"] = "Blue : hits, red : views of this very page, versus time";
}

?>

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

$_LANG["30"] = array(
"titre" => "Change section"
);
$_LANG["15"] = array(
"titre" => "Add your file",

"source_name" => "Title",
"source_description" => "Description",

"source_url" => "File",
"enregistrer" => "You query has been heard",
"error_file" => "Invalid file",
"add" => "Add",
"edit" => "Edit",
"rm" => "Remove",
"remove_now" => "Remove it now!",
//"new_file" => "Mettre &agrave; jour le fichier"
);


$_LANG["17"] = array(
"titre" => "Add a section",
"right_add_a_file" => "Who can add a file",
"language_name" => "Name"
);

$_LANG["1"] = array(
"titre" => "Files",
"transfer_dl" => "You must transfer all the file",
"remove_it" => "Remove",
"section" => "Files section",
"count_files" => "Number of files"
);


$_LANG["5"] = array(
"edit" => "Edit"
);


$_LANG["6"] = array(
"add_time" => "Add",
"modif_time" => "Modified",
"md5sum" => "md5Sum",
"nb_downloads" => "Number of downloads"
);
$_LANG["15"]["curve"] = "Blue : downloads, red : views, correlation with time";
}

?>

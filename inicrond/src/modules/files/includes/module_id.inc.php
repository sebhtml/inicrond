<?php
//$Id$

//-----------------------------------
//Config file...
//---------------------------

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : configuration sql
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


//--------------------------------
//modules disponibles
//--------------------------------


//files
$_OPTIONS["modules"]["1"] =  "files_inc.php";//fichiers
$_OPTIONS["modules"]["15"] =   "add_edit_remove_file_inc.php";//add/edit/rm file
$_OPTIONS["modules"]["17"] =  "add_edit_section_inc.php";//add/edit section
$_OPTIONS["modules"]["5"] =  "section_inc.php";//voir section
$_OPTIONS["modules"]["6"] =  "file_inc.php";//view file
$_OPTIONS["modules"]["30"] =  "move_file_inc.php";//bouger un download.

}

?>
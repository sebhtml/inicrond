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

//forum
$_OPTIONS["modules"]["23"] =  "main_inc.php";//forum main
$_OPTIONS["modules"]["24"] =  "forum_inc.php";//view forum
$_OPTIONS["modules"]["25"] =  "thread_inc.php";//view thread
$_OPTIONS["modules"]["26"] =  "start_edit_reply_inc.php";//start/edit/reply
$_OPTIONS["modules"]["27"] =  "add_edit_section_inc.php";//add/edit section
$_OPTIONS["modules"]["28"] =  "add_edit_forum_inc.php";//add/edit forum
$_OPTIONS["modules"]["33"] =  "mods_inc.php";//modérateurs

}

?>
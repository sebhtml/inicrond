<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : login
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

$my_form = new Form();
$my_form->set_method("POST");
$my_form->set_type(1);//sur une colonne

$my_text = new Text();
$my_text->set_value("");
$my_text->set_name("usr_name");
$my_text->set_size("16");
$my_text->set_text($_LANG["common"]["usr_name"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Password();
$my_text->set_value("");
$my_text->set_name("usr_password");
$my_text->set_size("16");
$my_text->set_text($_LANG["common"]["usr_password"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Hidden();
$my_text->set_value(base64_encode($_SERVER["QUERY_STRING"]));
$my_text->set_name("redirect");
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Submit();
$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("log_in_as_usr");

$my_text->validate();
$my_form->add_base($my_text);


$layout_contenu .= $my_form->output();

}
 
?>



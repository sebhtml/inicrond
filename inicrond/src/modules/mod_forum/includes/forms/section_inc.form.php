<?php
//$Id$

if(!__INICROND_INCLUDED__)
{
        die("hacking attempt!!");
}
/*
//----- ----------------------------------------------------------------
//
//
//Fonction du fichier : formulaire ad d / edit section forum
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
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
// filtrage des données
//include "includes/fonctions/fonctions_validation_inc.php";

include __INICROND_INCLUDE_PATH__."includes/class/form/Form.class.php";

$my_form = new Form();
$my_form->set_method("POST");

include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
include __INICROND_INCLUDE_PATH__."includes/class/form/Text.class.php";
$my_text = new Text();
$my_text->set_value($forum_section_name);
$my_text->set_name("forum_section_name");
$my_text->set_text($_LANG['title']);
$my_text->validate();
$my_form->add_base($my_text);

include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";
$my_text = new Submit();
$my_text->set_value($_LANG['txtBoutonForms_ok']);
$my_text->set_name("envoi");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);

$module_content .= $my_form->output();   

?>
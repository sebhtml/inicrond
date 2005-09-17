
<?php
//$Id$

if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : formulaire de edit post/add post/start thread
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



$my_form = new Form();
$my_form->set_method("POST");
$my_form->enctype();

$my_text = new Text();
$my_text->set_value($forum_message_titre);
$my_text->set_name("forum_message_titre");
$my_text->set_text($_LANG["26"]["forum_message_titre"]);
$my_text->validate();
$my_form->add_base($my_text);
  

$my_text = new Textarea();
$my_text->set_value($forum_message_contenu);
$my_text->set_name("forum_message_contenu");
$my_text->set_rows(50);
$my_text->set_cols(40);
$my_text->set_text($_LANG["26"]["forum_message_contenu"].
         $_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);
	 


$my_text = new Submit();
$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("sent");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);
    

$module_content .= $my_form->output();

  
?>

<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir discussion
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

if(__INICROND_INCLUDED__)
{
	
        
        include __INICROND_INCLUDE_PATH__."includes/class/form/Form.class.php";	
	$my_form = new Form();
        $my_form->set_method("POST");
        //$my_form->set_enctype("");
        
        include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
        include __INICROND_INCLUDE_PATH__."includes/class/form/sql/Select_with_sql.class.php";
        include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";
        
        $cours_id = forum_to_cours($forum_discussion_id);
        
        include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";
        $my_select = new Select_with_sql;
        $query = "SELECT
        forum_discussion_id AS VALUE, 
        forum_discussion_name AS TEXT
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
        AND
        cours_id=$cours_id
        AND
        forum_discussion_id!=$forum_discussion_id
        ";
        $my_select->sql=$query;//requeete
	$my_select->name="forum_discussion_id";//nom de la liste déroulante
	$my_select->default_VALUE=$forum_discussion_id;//valeur par défaut
	$my_select->text=$_LANG['move'];//le txte à côté
	$my_select->inicrond_db=$inicrond_db;//le lien vers la base de données.
	
        
        
        $my_form->add_base($my_select->OUTPUT());
        
        //<select name=\"\" >";
        
        
        
        //
        
        
        //$queries["SELECT"] ++; // comptage
        include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";
        
        $my_text = new Submit();
        $my_text->set_value($_LANG['txtBoutonForms_ok']);
        $my_text->set_name("envoi");
        //$my_text->set_text("valider");
        $my_text->validate();
        $my_form->add_base($my_text);
        
        $module_content .= $my_form->output();
	
}


?>
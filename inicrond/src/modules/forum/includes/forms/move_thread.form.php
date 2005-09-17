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
//$my_form->set_enctype("");

$my_select = new Select_with_sql;
$sql = "SELECT
		forum_discussion_id AS VALUE, 
		forum_discussion_name AS TEXT
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
		;";

		$my_select->SET_sql($sql);
		 $my_select->SET_name("forum_discussion_id");
		 $my_select->SET_default_VALUE($forum_discussion_id);
		 $my_select->SET_text($_LANG["common"]["move"]);
		 $my_select->SET_mon_objet($mon_objet);
		 
		
		$my_form->add_base($my_select->OUTPUT());
		
		//<select name=\"\" >";
		
		
		
		//$mon_objet->free_result($query_result);
				
		
		//$queries["SELECT"] ++; // comptage
			$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("envoi");
//$my_text->set_text("valider");
$my_text->validate();
$my_form->add_base($my_text);
		$module_content .= $my_form->output();
	
}


?>


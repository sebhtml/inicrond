
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
//Fonction du fichier : formulaire edit/add discussion
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

$my_text = new Text();
$my_text->set_value($forum_discussion_name);
$my_text->set_name("forum_discussion_name");
$my_text->set_text($_LANG["23"]["discussion"]);
$my_text->validate();
$my_form->add_base($my_text);
  
 $my_text = new Textarea();
$my_text->set_value($forum_discussion_description);
$my_text->set_name("forum_discussion_description");
$my_text->set_rows(50);
$my_text->set_cols(40);
$my_text->set_text($_LANG["23"]["description"].
      			$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);

$select = new Select();
$select->set_name("right_thread_start");
$select->set_text($_LANG["28"]["right_thread_start"]);

$my_option = new Option();
$my_option->set_value(0);
$my_option->set_text($_LANG["28"]["all"]);
$select->add_option($my_option);


			
		$sql = "SELECT
		group_id, group_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
		ORDER BY 
		group_name
		 ASC
		;";
		
		$query_result = $mon_objet->query($sql);
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{
		$my_option = new Option();
		
		$my_option->set_value($fetch_result["group_id"]);
		$my_option->set_text($fetch_result["group_name"]);
		

			 			
		if($fetch_result["group_id"] == $right_thread_start)
		{
		$my_option->selected();//SELECTED
		}
		$select->add_option($my_option);		
			
		}

		$mon_objet->free_result($query_result);
		
		
$select->validate();
$my_form->add_base($select);//ajout de la liste déroulante.

  
$select = new Select();
$select->set_name("right_thread_reply");
$select->set_text($_LANG["28"]["right_thread_reply"]);

$my_option = new Option();
$my_option->set_value(0);
$my_option->set_text($_LANG["28"]["all"]);
$select->add_option($my_option);


			
		$sql = "SELECT
		group_id, group_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
		ORDER BY 
		group_name
		 ASC
		;";
		
		$query_result = $mon_objet->query($sql);
		while($fetch_result = $mon_objet->fetch_assoc($query_result))
		{
		$my_option = new Option();
		
		$my_option->set_value($fetch_result["group_id"]);
		$my_option->set_text($fetch_result["group_name"]);
					 			
		if($fetch_result["group_id"] == $right_thread_reply)
		{
		$my_option->selected();//SELECTED
		}
		$select->add_option($my_option);		
			
		}

		$mon_objet->free_result($query_result);
				
$select->validate();
$my_form->add_base($select);//ajout de la liste déroulante.

$my_text = new Submit();
$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("envoi");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);
	 

$module_content .= $my_form->output();

?>

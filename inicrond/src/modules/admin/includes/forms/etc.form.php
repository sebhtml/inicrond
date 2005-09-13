<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : options
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
if(isset($_OPTIONS["INCLUDED"]) 
)
{

$my_form = new Form();
$my_form->set_method("POST");

 $select = new Select();
$select->set_name("usr_time_decal");
$select->set_text($_LANG["4"]["usr_time_decal"]);
		
				 
		 foreach ($_LANG["txt_usr_time_decals"] as $key => $value)
		{
			
		$my_option = new Option();
		
		$my_option->set_value($key);
		$my_option->set_text($value);
		

			 			
			if($key == $fetch_result["usr_time_decal"])
			{
			$my_option->selected();//SELECTED
			}
		$select->add_option($my_option);
		
		}
        
$select->validate();
$my_form->add_base($select);//ajout de la liste déroulante.



 $select = new Select();
$select->set_name("language");
$select->set_text($_LANG["4"]["usr_communication_language"]);
		
				 
		 foreach ($_LANG["usr_communication_languages"] as $key => $value)
		{
			
		$my_option = new Option();
		
		$my_option->set_value($key);
		$my_option->set_text($value);
		

			 			
			if($key == $fetch_result["language"])
			{
			$my_option->selected();//SELECTED
			}
		$select->add_option($my_option);
		
		}
			
        
$select->validate();
$my_form->add_base($select);//ajout de la liste déroulante.


 $select = new Select();
$select->set_name("news_forum_discussion_id");
$select->set_text($_LANG["34"]["news_forum_discussion_id"]);
		
		$sql = "SELECT
		forum_discussion_id, forum_discussion_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
		;";
		
		
		$query_result = $mon_objet->query($sql);
		while($fetch_result_2 = $mon_objet->fetch_assoc($query_result))
		{
			
		$my_option = new Option();
		
		$my_option->set_value($fetch_result_2["forum_discussion_id"]);
		$my_option->set_text($fetch_result_2["forum_discussion_name"]);
		

			 			
			if($fetch_result_2["forum_discussion_id"] == $fetch_result["news_forum_discussion_id"])
			{
			$my_option->selected();//SELECTED
			}
		$select->add_option($my_option);
		}
      
$select->validate();
$my_form->add_base($select);//ajout de la liste déroulante.


//////////////////////
     
$my_text = new Text();
$my_text->set_value($fetch_result["preg_email"]);
$my_text->set_name("preg_email");
$my_text->set_text($_LANG["34"]["preg_email"]);
$my_text->validate();
$my_form->add_base($my_text);
  
$my_text = new Text();
$my_text->set_value($fetch_result["preg_usr"]);
$my_text->set_name("preg_usr");
$my_text->set_text($_LANG["34"]["preg_usr"]);
$my_text->validate();
$my_form->add_base($my_text);
  
$my_text = new Text();
$my_text->set_value($fetch_result["titre"]);
$my_text->set_name("titre");
$my_text->set_text($_LANG["34"]["titre_site"]);
$my_text->validate();
$my_form->add_base($my_text);
  
$my_text = new Text();
$my_text->set_value($fetch_result["preg_agent"]);
$my_text->set_name("preg_agent");
$my_text->set_text($_LANG["34"]["preg_agent"]);
$my_text->validate();
$my_form->add_base($my_text);
  
  
$my_text = new Text();
$my_text->set_value($fetch_result["separator"]);
$my_text->set_name("separator");
$my_text->set_text($_LANG["34"]["separator"]);
$my_text->validate();
$my_form->add_base($my_text);
  
$my_text = new Textarea();
$my_text->set_value($fetch_result["header_txt"]);
$my_text->set_name("header_txt");
$my_text->set_rows("50");
$my_text->set_cols("30");
$my_text->set_text($_LANG["34"]["header_txt"].$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Textarea();
$my_text->set_value($fetch_result["footer_txt"]);
$my_text->set_name("footer_txt");
$my_text->set_rows("50");
$my_text->set_cols("30");
$my_text->set_text($_LANG["34"]["footer_txt"].$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Submit();
$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("envoi");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);
	 
$module_content .= $my_form->output();

 
}
?>


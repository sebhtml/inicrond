
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
$my_form->enctype();

$my_text = new Password();
$my_text->set_name("usr_password");
$my_text->set_size("16");
$my_text->set_text($_LANG["11"]["usr_password_new"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Password();
$my_text->set_name("usr_password_2");
$my_text->set_size("16");
$my_text->set_text($_LANG["11"]["usr_password_new"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Text();
$my_text->set_value($fetch_result["usr_email"]);
$my_text->set_name("usr_email");
$my_text->set_text($_LANG["4"]["usr_email"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Checkbox();
$my_text->set_name("show_email");
$my_text->set_text($_LANG["11"]["show_email"]);
if( $fetch_result["show_email"] == 1 )
{
$my_text->checked();//CHECKED
}
$my_text->validate();
$my_form->add_base($my_text);
 

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
$select->set_name("usr_communication_language");
$select->set_text($_LANG["4"]["usr_communication_language"]);

			
		foreach ($_LANG["usr_communication_languages"] as $key => $value)
		{
		$my_option = new Option();
		
		$my_option->set_value($key);
		$my_option->set_text($value);
								
			if($key == $fetch_result["usr_communication_language"])
			{
			$my_option->selected();//SELECTED
			}
		
		$select->add_option($my_option);
		}
     			
$select->validate();
$my_form->add_base($select);//ajout de la liste déroulante.
  
$my_text = new Textarea();
$my_text->set_value($fetch_result["usr_localisation"]);
$my_text->set_name("usr_localisation");
$my_text->set_rows("20");
$my_text->set_cols("30");
$my_text->set_text($_LANG["4"]["usr_localisation"].
      			$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);
 
$my_text = new Text();
$my_text->set_value($fetch_result["usr_web_site"]);
$my_text->set_name("usr_web_site");
$my_text->set_text($_LANG["4"]["usr_web_site"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Textarea();
$my_text->set_value($fetch_result["usr_job"]);
$my_text->set_name("usr_job");
$my_text->set_rows("20");
$my_text->set_cols("30");
$my_text->set_text($_LANG["4"]["usr_job"].
      			$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);
 
$my_text = new Textarea();
$my_text->set_value($fetch_result["usr_hobbies"]);
$my_text->set_name("usr_hobbies");
$my_text->set_rows("20");
$my_text->set_cols("30");
$my_text->set_text($_LANG["4"]["usr_hobbies"].
      			$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);
 
$my_text = new Textarea();
$my_text->set_value($fetch_result["usr_status"]);
$my_text->set_name("usr_status");
$my_text->set_rows("20");
$my_text->set_cols("30");
$my_text->set_text($_LANG["4"]["usr_status"].
      			$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Textarea();
$my_text->set_value($fetch_result["usr_signature"]);
$my_text->set_name("usr_signature");
$my_text->set_rows("20");
$my_text->set_cols("30");
$my_text->set_text($_LANG["4"]["usr_signature"].
      			$_LANG["23"]["cbparser_info"]);
$my_text->validate();
$my_form->add_base($my_text);
 
$my_text = new Checkbox();
$my_text->set_name("remove_usrs_pics");
$my_text->set_text($_LANG["11"]["remove_usrs_pics"]);
$my_text->validate();
$my_form->add_base($my_text);
 
$my_text = new File_();
$my_text->set_name("usrs_pics");
$my_text->set_text($_LANG["11"]["usrs_pics"]);
$my_text->validate();
$my_form->add_base($my_text);

$my_text = new Submit();
$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("modifierProfile");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);
    
$module_content .= $my_form->output();

?>

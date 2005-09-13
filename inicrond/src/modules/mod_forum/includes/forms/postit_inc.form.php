<?php
//$Id$

if(!__INICROND_INCLUDED__)
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


//include __INICROND_INCLUDE_PATH__."includes/class/form/Form.class.php";
//$my_form = new Form();
//$my_form->set_method("POST");
//$my_form->enctype();

$module_content .= "<form method=\"POST\">";


include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
include __INICROND_INCLUDE_PATH__."includes/class/form/Text.class.php";
$my_text = new Text();
$my_text->set_value($forum_message_titre);
$my_text->set_name("forum_message_titre");
//$my_text->set_text($_LANG['title']);
$my_text->validate();
//$my_form->add_base($my_text);

$module_content .= " <br /> <br />".$_LANG['title']." : ".$my_text->get_form_o();

include __INICROND_INCLUDE_PATH__."includes/class/form/Textarea.class.php";
$my_text = new Textarea();
$my_text->set_value($forum_message_contenu);
$my_text->set_name('forum_message_contenu');
$my_text->set_rows(15);
$my_text->set_cols(400);
$my_text->style = "width:100%";

//$my_text->set_text($_LANG['forum_message_contenu']."<br />".
// $_LANG['BB_code_info_main']);
$my_text->validate();
$module_content .= " <br /> <br />".$_LANG['forum_message_contenu']." :  <br /><br /> ".$my_text->get_form_o();
//$my_form->add_base($my_text);

////////////
//the checkbox for the groups that you want to send the email.

if(isset($_GET["forum_discussion_id"]) AND
is_teacher_of_forum($_SESSION['usr_id'], $_GET["forum_discussion_id"])
)
{
        
        $cours_id = forum_to_cours($_GET["forum_discussion_id"]);
        $module_content .= "<br /><br /><input type=\"hidden\"  name=\"send_email\" value=\"\"  />".$_LANG['send_this_message_to_the_following_groups'];
        
        
        
        
        $query = "SELECT
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id, 
        group_name		
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id=$cours_id
	
        ";
        $module_content .= "<table>";
	$rs = $inicrond_db->Execute($query);
	while($fetch_result = $rs->FetchRow())
	{
                
		
		$module_content .= "<tr><td>".$fetch_result['group_name']."</td><td><input type=\"checkbox\"  name=\"&group_id=".$fetch_result['group_id']."&\" value=\"&group_id=".$fetch_result['group_id']."&\"  /></td></tr>";
		
        }
        
        $module_content .= "</table><br />";
        
}

///////////////



$smarty->assign("textarea_name", 'forum_message_contenu');
$smarty->assign('HTMLArea_language', $_RUN_TIME['HTMLArea_language']);
$smarty->assign("HTMLArea_init", "onload=\"HTMLArea.init();\"");


$smarty->template_dir = __INICROND_INCLUDE_PATH__."templates/";
$tmp["left_delimiter"] = $smarty->left_delimiter;
$tmp["right_delimiter"] = $smarty->right_delimiter;
$tmp["template_dir"] = $smarty->template_dir;

$module_content .= $smarty->fetch($_OPTIONS['theme']."/HTMLArea_init.tpl");

//restore smarty values.
$smarty->left_delimiter = $tmp["left_delimiter"];
$smarty->right_delimiter = $tmp["right_delimiter"];
$smarty->template_dir = $tmp["template_dir"];

include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";
$my_text = new Submit();
$my_text->set_value($_LANG['txtBoutonForms_ok']);
$my_text->set_name("sent");
//$my_text->set_text("&nbsp;");
$my_text->validate();
//$my_form->add_base($my_text);
$module_content .= $my_text->get_form_o();

$module_content .= "</form>";    
//include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_autres.function.php";//inclue les autres fonctions					
//$module_content .= $my_form->output();


?>
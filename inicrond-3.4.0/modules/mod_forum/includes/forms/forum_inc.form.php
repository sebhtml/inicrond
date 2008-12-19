<?php
/*
    $Id: forum_inc.form.php 85 2005-12-27 03:22:23Z sebhtml $

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if(!__INICROND_INCLUDED__)
{
    die("hacking attempt!!");
}

include __INICROND_INCLUDE_PATH__."includes/class/form/Form.class.php";
$my_form = new Form();
$my_form->set_method("POST");

include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
include __INICROND_INCLUDE_PATH__."includes/class/form/Text.class.php";
$my_text = new Text();
$my_text->set_value($forum_discussion_name);
$my_text->set_name("forum_discussion_name");
$my_text->set_text($_LANG['discussion']);
$my_text->validate();
$my_form->add_base($my_text);

include __INICROND_INCLUDE_PATH__."includes/class/form/Textarea.class.php";

$my_text = new Textarea();
$my_text->set_value($forum_discussion_description);
$my_text->set_name("forum_discussion_description");
$my_text->set_rows(10);
$my_text->set_cols(40);
$my_text->set_text($_LANG['description'].
$_LANG['BB_code_info_main']);
$my_text->validate();
$my_form->add_base($my_text);

include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";
include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";
include __INICROND_INCLUDE_PATH__."includes/class/form/sql/Select_with_sql.class.php";
$select = new Select_with_sql();

//edit or add a forum???
$forum_section_id = isset($_GET["forum_section_id"]) ? $_GET["forum_section_id"] : $fetch_result["forum_section_id"];

$query = "
SELECT cours_id FROM ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
WHERE
forum_section_id=".$forum_section_id."
" ;

$recordSet =  $inicrond_db->Execute($query);

$f = $recordSet->FetchRow();

$cours_id = $f['cours_id'];

$query = "
SELECT
forum_section_id AS VALUE,
forum_section_name AS TEXT
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
WHERE
cours_id=$cours_id
" ;

$select->sql = $query;
$select->text=($_LANG['forums_section']);
$select->name=("forum_section_id");
$select->default_VALUE=($forum_section_id);
$select->inicrond_db = &$inicrond_db;

$select =  $select->OUTPUT();
$my_form->add_base($select);

include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";

$my_text = new Submit();
$my_text->set_value($_LANG['txtBoutonForms_ok']);
$my_text->set_name("envoi");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);

$module_content .= $my_form->output();

?>
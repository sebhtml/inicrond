<?php
//$Id$

/*---------------------------------------------------------------------
sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/

if(!__INICROND_INCLUDED__)
{
    exit();
}

include __INICROND_INCLUDE_PATH__."includes/class/form/Form.class.php";
$my_form = new Form();
$my_form->set_method("POST");
$my_form->enctype();

//file_title
include __INICROND_INCLUDE_PATH__.'includes/class/form/Base.class.php';
include __INICROND_INCLUDE_PATH__.'includes/class/form/Text.class.php';
$my_text = new Text();
$my_text->set_value($fetch_result['file_title']);
$my_text->set_name('file_title');
$my_text->set_size('50');
$my_text->set_text($_LANG['title']);
$my_text->validate();
$my_form->add_base($my_text);

//IS_DOWNLOADABLE

include __INICROND_INCLUDE_PATH__.'includes/class/form/Select.class.php';
include __INICROND_INCLUDE_PATH__.'includes/class/form/Option.class.php';

//infos
include __INICROND_INCLUDE_PATH__.'includes/class/form/Textarea.class.php';

$my_text = new Textarea();
$my_text->set_value($fetch_result["file_infos"]);
$my_text->set_name("file_infos");
$my_text->set_rows("20");
$my_text->set_cols("30");
$my_text->set_text($_LANG['description']);
$my_text->validate();
$my_form->add_base($my_text);

//the file
include __INICROND_INCLUDE_PATH__."includes/class/form/File_.class.php";
$my_text = new File_();
$my_text->set_name("uploaded_file");
$my_text->set_text($_LANG['file']."<br /><b><span style=\"color: red;\"></span></b>");
$my_text->validate();
$my_form->add_base($my_text);

include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";
$my_text = new Submit();
$my_text->set_value($_LANG['txtBoutonForms_ok']);
$my_text->set_name("okidou");
$my_text->set_text($_LANG['txtBoutonForms_ok']);
$my_text->validate();
$my_form->add_base($my_text);

$module_content .= $my_form->output();

?>
<?php
//$Id$


$_OPTIONS["INCLUDED"] = TRUE;

include "../includes/class/form/Form.class.php";
$my_form = new Form();
$my_form->set_method("GET");
$my_form->set_enctype("");

include "../includes/class/form/Base.class.php";

include "../includes/class/form/Select.class.php";
$select = new Select();
$select->set_name("checkboxname");
$select->set_text("check box -");


include "../includes/class/form/Option.class.php";
$my_option = new Option();
//$my_option->selected();//SELECTED
$my_option->set_value("valeur 1");
$my_option->set_text("value1");
$select->add_option($my_option);

$my_option = new Option();
//$my_option->selected();//SELECTED
$my_option->set_value("valeur 2");
$my_option->set_text("value2");
$select->add_option($my_option);

$my_option = new Option();
$my_option->selected();//SELECTED
$my_option->set_value("valeur 3");
$my_option->set_text("value3");
$select->add_option($my_option);

$select->validate();
$my_form->add_base($select);

include "../includes/class/form/Checkbox.class.php";
$my_text = new Checkbox();
$my_text->set_name("cheame");
$my_text->set_text("check box -");
$my_text->set_value("chvalue");
$my_text->checked();//CHECKED
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/class/form/Radio.class.php";
$my_text = new Radio();
$my_text->set_name("radioname");
$my_text->set_text("radio box -");
$my_text->checked();//CHECKED
$my_text->set_value("bobu");
$my_text->validate();
$my_form->add_base($my_text);


include "../includes/class/form/Text.class.php";
$my_text = new Text();
$my_text->set_value("value2");
$my_text->set_name("bobu");
$my_text->set_size("50");
$my_text->set_text("mon petit texte");
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/class/form/Password.class.php";
$my_text = new Password();
$my_text->set_value("value2");
$my_text->set_name("bobu");
$my_text->set_size("50");
$my_text->set_text("mon petit texte");
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/class/form/Textarea.class.php";
$my_text = new Textarea();
$my_text->set_value("vaelue2");
$my_text->set_name("bobeu");
$my_text->set_rows("50");
$my_text->set_cols("30");
$my_text->set_text("mon petit texte pour le textarea");
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/class/form/Submit.class.php";
$my_text = new Submit();
$my_text->set_value("ssumbit");
$my_text->set_name("okidou");
$my_text->set_text("valider");
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/class/form/File_.class.php";
$my_text = new File_();
$my_text->set_name("okidous 3");
$my_text->set_text("valider 3");
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/class/form/Hidden.class.php";
$my_text = new Hidden();
$my_text->set_name("hidden name");
$my_text->set_text("valider 3");
$my_text->set_value("hidden value");
$my_text->validate();
$my_form->add_base($my_text);

include "../includes/fonctions/fonctions_autres_inc.php";
echo $my_form->output();

?>

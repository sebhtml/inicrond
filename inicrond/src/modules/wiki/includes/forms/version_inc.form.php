
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

while($fetch_result = $mon_objet->fetch_assoc($query_result))
{

$my_text = new Radio();
$my_text->set_name("wiki_id");

//MéGA texte pour chaque radio.:
$my_text->set_text(format_time_stamp($fetch_result["wiki_ts"],
	 $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"])."<br />".
retournerHref("?module_id=37&wiki_id=".
$fetch_result["wiki_id"], $fetch_result["wiki_title"])." ".$_LANG["modules/others/articles_inc.php"]["by"]." ".
retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"]));
	
	if($last_ts == $fetch_result["last_ts"])//la version courante.
	{
	$my_text->checked();//CHECKED
	}
	
$my_text->set_value($fetch_result["wiki_id"]);
$my_text->validate();
$my_form->add_base($my_text);
}


$mon_objet->free_result($query_result);

 
$my_text = new Submit();
$my_text->set_value($_LANG["txtBoutonForms"]["ok"]);
$my_text->set_name("version");
$my_text->set_text("&nbsp;");
$my_text->validate();
$my_form->add_base($my_text);
	 

$module_content .= $my_form->output();


?>

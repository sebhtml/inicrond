<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : fichier fr
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
$_LANG["msg_error"]["not_activated"] = "Your accound is not activated.";
//$_LANG["msg_error"]["dont_exists"] = "Ce compte n'existe pas.";
$_LANG["msg_error"]["acces_denied"] = "Access denied!!!";

$_LANG["stat"]["n"] = "Count";
$_LANG["stat"]["x-barre"] = "Mean";
$_LANG["stat"]["s"] = "Standard deviation";
$_LANG["stat"]["sum"] = "Sum";

$_LANG["common"]["500"] = "Sessions";
$_LANG["common"]["remove"] = "Remove";


$_LANG["email_footer"] = "<br />
".$_OPTIONS["addr"]."";


$_LANG["SQBD"] = array(
"mysql" => "MySQL"
);

$_LANG["months"] = array(//mois
"1" => "January",
"2" => "February",
"3" => "March",
"4" => "April",
"5" => "May",
"6" => "June",
"7" => "July",
"8" => "August",
"9" => "September",
"10" => "October",
"11" => "November",
"12" => "December"
);

$_LANG["week_days"] = array(//jours
"0" => "Sunday",
"1" => "Monday",
"2" => "Thuesday",
"3" => "Wednesday",
"4" => "Thursday",
"5" => "Friday",
"6" => "Saturday"
);


$_LANG["txt_mod_count"]  = array(
"anonim" => "Anonymous",
"total" => "All",
"membres" => "Registred",
//"type" => "Type",
//"visits" => "Visites",
//"googlebot" => "GoogleBot",
"debut" => "Since"
);

$_LANG["usr_communication_languages"]= array(
"fr" => "French",
"en" => "English"
);

$_LANG["txt_windows"] = array(
"menu_princi" => "Navigation",
//"stats" => "Statistiques",
"inter" => "Interact",
//"content" => "Contenu",
//"sub_sites" => "Autres sites",
"online_ppl" => "Online people",
//"count" => "Compteur de visites",
//"last_stuff" => "Derniers ajouts",

//"count_stuff" => "Quantit&eacute;s"
//"date" => "Date",

"lang" => "Languages"

);

$_LANG["redir"]["msg"] = "The page will be refreshen soon, if not, click ";
$_LANG["redir"]["here"] = "Here";



$_LANG["txt_inter"] = array(
"back_drop" => "Back-up database with DROP command",
"back_delete" => "Back-up with DELETE command"
);

$_LANG["txt_usr_time_decals"] = array(
"-12" => "GMT -12:00",
"-11" => "GMT -11:00",
"-10" => "GMT -10:00",
"-9" => "GMT -9:00",
"-8" => "GMT -8:00",
"-7" => "GMT -7:00",
"-6" => "GMT -6:00",
"-5" => "GMT -5:00",
"-4" => "GMT -4:00",
"-3.5" => "GMT -3:30",
"-3" => "GMT -3:00",
"-2" => "GMT -2:00",
"-1" => "GMT -1:00",
"0" => "GMT",
"1" => "GMT +1:00",
"2" => "GMT +2:00",
"3" => "GMT +3:00",
"3.5" => "GMT +3:30",
"4" => "GMT +4:00",
"4.5" => "GMT +4:30",
"5" => "GMT +5:00",
"5.5" => "GMT +5:30",
"6" => "GMT +6:00",
"6.5" => "GMT +6:30",
"7" => "GMT +7:00",
"8" => "GMT +8:00",
"9" => "GMT +9:00",
"9.5" => "GMT +9:30",
"10" => "GMT +10:00",
"11" => "GMT +11:00",
"12" => "GMT +12:00"
); // time decals

$_LANG["txt_login"] = array(


//"titre" => "Connexion",
"AccesDenied" => "Acces denied",
//"connected" => "Vous &ecirc;tes connect&eacute;(e).",
"Activation" => "Your accound is not activated"

);

$_LANG["txtBoutonForms"] = array(
"ok" => "Validate",
"cancel" => "Cancel",
"parcourir" => "Run"
);


$_LANG["common"]["title"] = "Title";

$_LANG["common"]["description"] = "Description";

$_LANG["modules/admin/set/visits_inc.php"] = array(
//"php_session_id" => "SID",
//"adresse_ip" => "IP",
//"session_gmt_timestamp" => "GMT_TimeStamp",
"titre" => "Online_PPL"
);

$_LANG["common"]["add_date"] = "Add date";
$_LANG["common"]["43"] = "Source code";
$_LANG["common"]["nb_views"] = "Number of views";

$_LANG["28"]["all"] = "All";

$_LANG["4"] = array(


//"usr_id" => "",
"usr_name" => "Name",
"usr_password" => "Password",
"usr_add_gmt_timestamp" => "Sign in date",
//"usr_activation" => "",
//"usr_deletable" => "",
//"usr_ban_warning" => "",
"usr_time_decal" => "Time setting",
"usr_communication_language" => "Language",
"usr_localisation" => "Geography",
"usr_web_site" => "URL",
"usr_job" => "Job",
"usr_hobbies" => "Hobbies",
"usr_email" => "Email",
"usr_status" => "Status",
"usr_signature" => "Signature",
"count(messages)" => "Number of posts",
//"count(".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].")" => "Nombre de liens",
"count(files)" => "Numbers of files",
"count(image_id)" => "Numbers of images",

//"windows_width" => "Largeur (pixels)"

);
$_LANG["common"]["modif_time"] = "Date of editing";
$_LANG["common"]["32"] = "Home";
$_LANG["common"]["37"] = "WIKI";
$_LANG["common"]["8"] = "Members";
$_LANG["common"]["21"] = "Groups";
$_LANG["common"]["1"] = "Files";
$_LANG["common"]["38"] = "Web links";
$_LANG["common"]["10"] = "Pictures";
$_LANG["common"]["36"] = "Statistics";
$_LANG["common"]["44"] = "Calendar";
$_LANG["common"]["45"] = "Repositery";
$_LANG["common"]["23"] = "Forums";
$_LANG["common"]["35"] = "Search";
$_LANG["common"]["move"] = "Move";
$_LANG["common"]["3"] = "Log out";

$_LANG["common"]["usr_name"] = "Name";
$_LANG["common"]["usr_password"] = "Password";

$_LANG["common"]["7"] = "Sign in";
$_LANG["common"]["14"] = "Forgot password";

$_LANG["common"]["34"] = "Options";

$_LANG["common"]["9"] = "Rights";

$_LANG["common"]["edit"] = "Edit";

$_LANG["common"]["11"] = $_LANG["common"]["edit"];
}

?>

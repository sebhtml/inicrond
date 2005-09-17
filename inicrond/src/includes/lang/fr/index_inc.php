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

$_LANG["msg_error"]["not_activated"] = "Votre compte n'est pas activ&eacute;.";
//$_LANG["msg_error"]["dont_exists"] = "Ce compte n'existe pas.";
$_LANG["msg_error"]["acces_denied"] = "L'Acc&egrave;s vous est refus&eacute;.";

$_LANG["stat"]["n"] = "Nombre";
$_LANG["stat"]["x-barre"] = "Moyenne";
$_LANG["stat"]["s"] = "&Eacute;cart type corrig&eacute;";
$_LANG["stat"]["sum"] = "Total";


$_LANG["email_footer"] = "<br />
".$_OPTIONS["addr"]."";


$_LANG["SQBD"] = array(
"mysql" => "MySQL"
);

$_LANG["months"] = array(//mois
"1" => "Janvier",
"2" => "F&eacute;vrier",
"3" => "Mars",
"4" => "Avril",
"5" => "Mai",
"6" => "Juin",
"7" => "Juillet",
"8" => "Ao&ucirc;t",
"9" => "Septembre",
"10" => "Octobre",
"11" => "Novembre",
"12" => "D&eacute;cembre"
);

$_LANG["week_days"] = array(//jours
"0" => "Dimanche",
"1" => "Lundi",
"2" => "Mardi",
"3" => "Mercredi",
"4" => "Jeudi",
"5" => "Vendredi",
"6" => "Samedi"
);


$_LANG["txt_mod_count"] = array(
"anonim" => "Anonyme",
"total" => "Total",
"membres" => "Membre",

"debut" => "Depuis"
);

$_LANG["usr_communication_languages"]= array(
"fr" => "Fran&ccedil;ais",
"en" => "Anglais"
);

$_LANG["txt_windows"] = array(
"menu_princi" => "Menu",
//"stats" => "Statistiques",
"inter" => "Interaction",

"online_ppl" => "Personnes en ligne",

"lang" => "Langues"

);


$_LANG["redir"]["msg"] = "La page va se recharger , sinon, cliquer";
$_LANG["redir"]["here"] = "Ici";






$_LANG["txt_inter"] = array(
"back_drop" => "Sauvegarder la base de donn&eacute;s avec des commandes SQL DROP",
"back_delete" => "Sauvegarder la base de donn&eacute;s avec des commandes SQL DELETE"
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
"AccesDenied" => "Acc&egrave;s refus&eacute;",
//"connected" => "Vous &ecirc;tes connect&eacute;(e).",
"Activation" => "Votre compte n'est pas activ&eacute;"

);

$_LANG["txtBoutonForms"] = array(
"ok" => "Valider",
"cancel" => "Annuler",
"parcourir" => "Parcourir"
);

$_LANG["modules/admin/set/visits_inc.php"] = array(
//"php_session_id" => "SID",
//"adresse_ip" => "IP",
//"session_gmt_timestamp" => "GMT_TimeStamp",
"titre" => "Online_PPL"
);
$_LANG["28"]["all"] = "Tous";

$_LANG["common"]["32"] = "Accueil";
$_LANG["common"]["37"] = "WIKI";
$_LANG["common"]["8"] = "Membres";
$_LANG["common"]["21"] = "Groupes";
$_LANG["common"]["1"] = "Fichiers";
$_LANG["common"]["38"] = "Liens web";
$_LANG["common"]["10"] = "Images";
$_LANG["common"]["36"] = "Statistiques";
$_LANG["common"]["44"] = "Calendrier";
$_LANG["common"]["45"] = "D&eacute;pot";
$_LANG["common"]["23"] = "Forums";
$_LANG["common"]["35"] = "Recherche";

$_LANG["common"]["3"] = "D&eacute;connection";

$_LANG["common"]["usr_name"] = "Nom d'utilisateur";
$_LANG["common"]["usr_password"] = "Mot de passe";

$_LANG["common"]["7"] = "Inscription";
$_LANG["common"]["14"] = "Mot de passe oubli&eacute;";
$_LANG["common"]["34"] = "Options";

 $_LANG["common"]["edit"]= "&Eacute;diter";

$_LANG["common"]["11"] = $_LANG["common"]["edit"];
$_LANG["common"]["9"] = "Droits";
$_LANG["common"]["move"] = "Bouger";

$_LANG["common"]["add_date"] = "Date d'ajout";
$_LANG["common"]["43"] = "Code source";

$_LANG["common"]["nb_views"] = "Nombre de visionnements";

$_LANG["common"]["modif_time"] = "Date de modification";
$_LANG["common"]["remove"] = "Enlever";

$_LANG["common"]["title"] = "Titre";

$_LANG["common"]["description"] = "Description";

$_LANG["common"]["500"] = "Sessions";

  $_LANG["4"] = array(


//"usr_id" => "",
"usr_name" => "Nom d'utilisateur",
"usr_password" => "Mot de passe",
"usr_add_gmt_timestamp" => "Date d'inscription",
//"usr_activation" => "",
//"usr_deletable" => "",
//"usr_ban_warning" => "",
"usr_time_decal" => "D&eacute;calage horaire",
"usr_communication_language" => "Langue de communication",
"usr_localisation" => "Emplacement g&eacute;ographique",
"usr_web_site" => "URL",
"usr_job" => "Emploi",
"usr_hobbies" => "Activit&eacute;s et loisirs",
"usr_email" => "Courriel",
"usr_status" => "Statut",
"usr_signature" => "Signature",
"count(messages)" => "Nombre de messages",
//"count(".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].")" => "Nombre de liens",
"count(files)" => "Nombre de fichiers",
"count(image_id)" => "Nombre d'images",

//"windows_width" => "Largeur (pixels)"

);
}



?>

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
$_LANG["11"] = array (
"titre" => "Modifier votre profil",

"error_website" => "Vous devez commencez votre adresse web avec http://",
"usr_password_new" => "Nouveau mot de passe",
"profileModified" => "Votre profil a &eacute;t&eacute; modifi&eacute;",
"champsIncorrects" => "Vous devez remplir les champs correctement",
"doublePass" => "Vous n'avez pas entr&eacute; le m&ecirc;me mot de passe deux fois",
"error_email" => "Adresse de courriel non valide",
"show_email" => "Montrer votre courriel",



"remove_usrs_pics" => "Enlever votre image",
"usrs_pics" => "Changer votre image (100 X 100 maximum)"
);

$_LANG["3"] = array(
"titre" => "D&eacute;connexion",
"email" => "Courriel"
//"deconnected" => "Vous &ecirc;tes d&eacute;connect&eacute;(e)"
);

$_LANG["14"] = array(
"titre" => "Mot de passe oubli&eacute;",

"send_email" => "Un courriel vous a &eacute;t&eacute; envoy&eacute;",
"error_send_email" => "Erreur lors de l'envoi du courriel",
"subject" => "Voici votre mot de passe",
"the_text" => "Vous avez oublier votre mot de passe  sur le site ".$_OPTIONS["titre"].", pour le changer, cliquer ici: ",
"profil" => "Profil"
);

$_LANG["7"] = array(
"titre" => "Inscription",
"dejaPris" => "Ce nom est d&eacute;j&agrave; pris",
"mail_subject" => "Inscription &agrave; ".$_OPTIONS["titre"].""
);
}

?>

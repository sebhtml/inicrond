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
$_LANG["14"] = array(
"titre" => "Forgot your password ?",

"send_email" => "An email has been sent to you",
"error_send_email" => "An error has occured when the email was sent",
"subject" => "You can change your password...",
"the_text" => "You have forgot your password on ".$_OPTIONS["titre"].", click here to change it : ",
"profil" => "Personal profil"
);


$_LANG["11"] = array (
"titre" => "My profil",
"error_website" => "You must start your URL with http://",
"usr_password_new" => "New password",
"profileModified" => "Your account has been altered",
"champsIncorrects" => "You must fill in the field correctly",
"doublePass" => "You must enter the same password in both fields",
"error_email" => "Invalid email adress",
"show_email" => "Show your email",


"remove_usrs_pics" => "Remove your picture",
"usrs_pics" => "Change or add your picture (100 X 100)"
);

$_LANG["7"] = array(
"titre" => "Registration",
"dejaPris" => "This name is already took",
"mail_subject" => "Registration to ".$_OPTIONS["titre"].""
);

$_LANG["3"] = array(
"titre" => "Disconnection",
"email" => "Email"
//"deconnected" => "Vous &ecirc;tes d&eacute;connect&eacute;(e)"
);

}

?>

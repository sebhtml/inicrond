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

$_LANG["20"] = array(
"add" => "Ajouter un groupe",
"edit" => "&Eacute;diter un groupe",
//"error_not_valid" => "Nom pas valide",
"usr_name" => "Chef",
"group_name" => "Groupe",
"description" => "Description",
"missing_user" => "Utilisateur invalide!"
);

$_LANG["21"] = array(
"titre" => "Groupes"
);

$_LANG["22"] = array(
"chef" => $_LANG["20"]["usr_name"],
"groupe" => "Groupe",
"members" => $_LANG["8"]["titre"],
"pending" => "Demandes en attente",
"join" => "Demander de joindre",
"rm" => $_LANG["10"]["remove_galerie"],
"validate" => "Accepter",
"refuse" => "Refuser"

);
}

?>

<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/
if(isset($_OPTIONS["INCLUDED"]))
{

include "includes/etc/files.php";

include("includes/class/Connexion_db.class.php");

include $_OPTIONS["file_path"]["db_config"];


include $_OPTIONS["file_path"]["sql_tables"] ;
include $_OPTIONS["file_path"]["modules_id"] ;
include $_OPTIONS["file_path"]["mod_dirs"] ;

//connexion ? la base de donn?es
$mon_objet = new Connexion_db();
$mon_objet->set_SGBD($_OPTIONS["SGBD"]);

	$mon_objet->connect($_OPTIONS["sql_server_name"], $_OPTIONS["sql_user_name"], $_OPTIONS["sql_user_password"], FALSE);
	//choisie la database
	$mon_objet->select_db($_OPTIONS["sql_database_name"]);

include $_OPTIONS["file_path"]["options"];


}

?>

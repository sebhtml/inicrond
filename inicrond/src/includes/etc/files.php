<?php
//$Id$

//-----------------------------------
//Config file...
//---------------------------

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
 $_OPTIONS["file_path"]["opt_in_mysql"] = "includes/etc/perso_opt.php" ;
 $_OPTIONS["file_path"]["options"] = "includes/etc/options_inc.php" ;


$_OPTIONS["file_path"]["db_config"] = "includes/etc/ro/db_config_inc.php" ;

$_OPTIONS["file_path"]["mod_dirs"] = "includes/etc/ro/modules_dir.config.php" ;
$_OPTIONS["file_path"]["modules_id"] = "includes/etc/ro/modules.config.php" ;
$_OPTIONS["file_path"]["sql_tables"] = "includes/etc/ro/tables.config.php" ;//uploaded file dir

//dirs
$_OPTIONS["file_path"]["mod_dir"] = "modules";

$_OPTIONS["file_path"]["uploaded_files_dir"] = "upload/uploaded_files_dir";
$_OPTIONS["file_path"]["images_dir"] = "upload/images";
$_OPTIONS["file_path"]["usrs_pics"] = "upload/usrs_pics";
$_OPTIONS["file_path"]["repository_dir"] = "upload/repository";

//pour la compatibilité.
$_OPTIONS["uploaded_files_dir"] = $_OPTIONS["file_path"]["uploaded_files_dir"];
$_OPTIONS["images_dir"] = $_OPTIONS["file_path"]["images_dir"];
$_OPTIONS["usrs_pics"] = $_OPTIONS["file_path"]["usrs_pics"];
$_OPTIONS["repository_dir"] = $_OPTIONS["file_path"]["repository_dir"];


}



?>
<?php
/*
    $Id: files.php 72 2005-12-16 02:08:23Z sebhtml $

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
/*
Changes :

december 15, 2005
	I formated the code correctly.
	
		--sebhtml

*/
if(!__INICROND_INCLUDED__)
{
	exit();
}

$_OPTIONS["file_path"]['options'] = "includes/etc/options_inc.php" ;
$_OPTIONS["file_path"]["date_stuff.inc.php"] = "includes/etc/date_stuff.inc.php" ;
$_OPTIONS["file_path"]["db_config_no_path"] = "db_config_inc.php" ;
$_OPTIONS["file_path"]["db_config"] = "includes/etc/ro/".$_OPTIONS["file_path"]["db_config_no_path"] ;

$_OPTIONS["file_path"]["sql_tables"] = "includes/etc/compiled/tables.config.php" ;//uploaded file dir
$_OPTIONS["file_path"]["available_langs.php"] = "includes/etc/compiled/available_langs.php" ;
$_OPTIONS["file_path"]["themes.php"] = "includes/etc/compiled/themes.php" ;

$_OPTIONS["file_path"]['smarty_cache_config'] = __INICROND_INCLUDE_PATH__."includes/etc/compiled/smarty_cache_config.conf.php" ;
$_OPTIONS["file_path"]["options_variable"] = __INICROND_INCLUDE_PATH__."includes/etc/compiled/options_variable.php" ;

//dirs
$_OPTIONS["file_path"]["mod_dir"] = __INICROND_INCLUDE_PATH__."modules/";
$_OPTIONS["file_path"]["uploads_no_prefix"] = "uploads/";
$_OPTIONS["file_path"]["uploads"] = __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["uploads_no_prefix"];


?>
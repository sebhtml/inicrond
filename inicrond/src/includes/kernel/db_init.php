<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//

//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
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
if(!__INICROND_INCLUDED__){exit();}

include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["db_config"];
include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["sql_tables"] ;
include __INICROND_INCLUDE_PATH__."includes/etc/options_inc.php";

$connect_type= $_OPTIONS['sql_server_persistency'] ? "PConnect" : "Connect";
/*
//adodb here...

include __INICROND_INCLUDE_PATH__.'libs/adodb/adodb.inc.php';


      
$inicrond_db = &ADONewConnection($_OPTIONS['SGBD']);  # create a connection
$inicrond_db->$connect_type(
$_OPTIONS['sql_server_name'],
$_OPTIONS['sql_user_name'],
$_OPTIONS['sql_user_password'],
$_OPTIONS['sql_database_name']
);
$inicrond_db->SetFetchMode(ADODB_FETCH_ASSOC);
*/

//my own class that are mysql only, but faster...


include __INICROND_INCLUDE_PATH__.'includes/class/Inicrond_mysql_db.class.php';

$inicrond_db = new Inicrond_mysql_db ;
$inicrond_db->$connect_type(
$_OPTIONS['sql_server_name'],
$_OPTIONS['sql_user_name'],
$_OPTIONS['sql_user_password'],
$_OPTIONS['sql_database_name']
);

?>
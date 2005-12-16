<?php
/*
    $Id$

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
	exit () ;
}

include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["db_config"];
include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["sql_tables"] ;
include __INICROND_INCLUDE_PATH__."includes/etc/options_inc.php";

$connect_type= $_OPTIONS['sql_server_persistency'] ? "PConnect" : "Connect";

/*
Uncomment the adodb block and comment the inicrond_Db block if you want to use adodb instead on inicronddb.
Officially, inicrond only supports MySQL
On the other hand, you can try at your own risks postgreSQL or sqLITE
I just don't think that the create queries will do the job...

	-- sebhtml, december 15, 2005
*/
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
//////////////////////////////////////////////////////////BEGIN FOR INICROND_DB		//$$$_+___--
											//$$$_+___--
include __INICROND_INCLUDE_PATH__.'includes/class/Inicrond_mysql_db.class.php';      	//$$$_+___--
											//$$$_+___--
$inicrond_db = new Inicrond_mysql_db ;							//$$$_+___--
											//$$$_+___--
$inicrond_db->$connect_type(								//$$$_+___--
$_OPTIONS['sql_server_name'],								//$$$_+___--
$_OPTIONS['sql_user_name'],								//$$$_+___--
$_OPTIONS['sql_user_password'],								//$$$_+___--
$_OPTIONS['sql_database_name']								//$$$_+___--
);											//$$$_+___--
											//$$$_+___--
//////////////////////////////////////////////////////////END FOR INICROND_DB		//$$$_+___--

?>
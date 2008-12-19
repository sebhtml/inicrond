<?php
/*
    $Id: course_session_update.kernel.php 78 2005-12-21 03:16:28Z sebhtml $

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

if(!__INICROND_INCLUDED__)//security check...
{
	exit();
}

if(isset($_SESSION['usr_id']) &&//is there a session?
isset ($_GET['cours_id']) &&
is_numeric($_GET['cours_id']) &&
!isset($_SESSION['cours_id'])) //not yet set in the database...AND
{//beginning of if clause

	//echo "UID = ".$_SESSION['usr_id']." , CID = ".$_GET['cours_id']."";
	//update the last session and set it to the first course asked in this very session.
	$query = "UPDATE
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
		SET
		cours_id=".$_GET['cours_id']."
		WHERE
		is_online = '1'
		AND
		usr_id = ".$_SESSION['usr_id']."
		AND
		cours_id = 0
		
		";//and of the query definition.

	$inicrond_db->Execute($query);//execute the great and mighty query.
 
	$_SESSION['cours_id'] = $_GET['cours_id'] ; //put in a session variable to check later if this hjave been done already.

}//end of if clause.

?>
<?php
//$Id$

/*---------------------------------------------------------------------
sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/

if(!__INICROND_INCLUDED__){ exit();}//security check...

//update online time if the cours_id in session is not set yet...
//echo "session update";

//$module_content .= "SCID =  ".$_SESSION['cours_id']." ";
//echo $_SESSION['cours_id'];
if(
isset($_SESSION['usr_id']) AND//is there a session?
is_numeric($_GET['cours_id']) AND
!isset($_SESSION['cours_id']) //not yet set in the database...AND


)
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
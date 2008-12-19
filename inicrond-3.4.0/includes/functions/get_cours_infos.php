<?php
/*
    $Id: get_cours_infos.php 78 2005-12-21 03:16:28Z sebhtml $

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
function get_cours_infos($cours_id)
{
	global $_OPTIONS, $inicrond_db;

	if(!isset($cours_id))
	{
		echo "[DEBUG] cours_id is not set in get_cours_infos<br />";
		return FALSE;
	}
	
	//get the cours infos.
      	$query = "SELECT 
      	cours_id,
      	cours_code,
      	cours_name
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
	WHERE
	cours_id=$cours_id
	";
	
	
	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return array(array("<h2>".$fetch_result['cours_code']. " "."<a href=\"../../modules/courses/inode.php?&cours_id=".$fetch_result['cours_id']."\">".$fetch_result['cours_name']."</a>"." "."</h2>"));

}

?>
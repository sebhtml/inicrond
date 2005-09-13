<?php
/*---------------------------------------------------------------------

$Id$

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


function ev_id_to_cours_id($ev_id)
{
        global $_OPTIONS, $inicrond_db;
        
        
        $query = "
        SELECT 
        cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
        WHERE
        ev_id=$ev_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." .group_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." .group_id
        ";
        
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        return $fetch_result['cours_id'];
        
}


?>
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

function check_if_each_entry_exists($group_id, $ev_id)
{
        global $_OPTIONS, $inicrond_db;
        
        //check if every student has his entry for this evaluation, if not, insert 0 value.
        
        //get alkl usr_id from the group.
        $query = "SELECT 
        
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        WHERE
        group_id=$group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        
        ORDER BY usr_nom ASC
        
        ";
        $rs = $inicrond_db->Execute($query);
        
        //for each usr_id, check if he/she has an entry in the table evaluation entries.
        while($fetch_result = $rs->FetchRow())
        {
                $query = "SELECT 
		
		usr_id
		
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
                WHERE
		usr_id=".$fetch_result['usr_id']."
		AND
		ev_id=$ev_id
                
                ";
                $rs2 = $inicrond_db->Execute($query);
                $fetch_result2 = $rs2->FetchRow();
                
                if(!isset($fetch_result2['usr_id']))//is no entry, insert one right now dude.
                {
                        $query = "INSERT INTO
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
                        (ev_id, usr_id, ev_score)
                        VALUES
                        ($ev_id, ".$fetch_result['usr_id'].", 0)
                        
                        
                        ";
                        $inicrond_db->Execute($query);
                }
        }
        
        return TRUE;
        
}

?>
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

function delete_result_id($result_id)
{
        global $_OPTIONS, $inicrond_db;
        
        $fetch_result['result_id'] = $result_id;
        
	$query = "SELECT
	question_ordering_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
	WHERE
        result_id=".$fetch_result['result_id']."
	";
        
	$rs2 = $inicrond_db->Execute($query);
        
        while($fetch_result2 = $rs2->FetchRow())
        {
		//delete answer_ordering entries
		$query = "DELETE FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
		WHERE
		question_ordering_id=".$fetch_result2["question_ordering_id"]."
		";
                
		$inicrond_db->Execute($query);
		
		//delete short_answers entries
		$query = "DELETE FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
		WHERE
		question_ordering_id=".$fetch_result2["question_ordering_id"]."
		";
                
		$inicrond_db->Execute($query);
		
		//delete media_linkage entries
		$query = "DELETE FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage']."
		WHERE
		question_ordering_id=".$fetch_result2["question_ordering_id"]."
		";
                
		$inicrond_db->Execute($query);
        }
        
        $query = "DELETE FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
        WHERE
        result_id=".$fetch_result['result_id']."
        ";
        
        $inicrond_db->Execute($query);
        
        $query = "DELETE FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
        WHERE
        result_id=".$fetch_result['result_id']."
        ";
        
        $inicrond_db->Execute($query);
	
}
?>

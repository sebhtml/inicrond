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

if(!__INICROND_INCLUDED__)
{
        exit();
}
/**
* return infos on a session
*
* @param        integer  $session_id    the id of the session
* @param        boolean  $show_scores    show score infos?
* @param        boolean  $show_results    show results info ?
* @param        boolean  $show_dl_acts    show dl acts info?
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function infos_for_session($session_id, $show_scores, $show_results, $show_dl_acts)
{
        global $_OPTIONS;
        global $_RUN_TIME;
        global $_LANG, $inicrond_db;
        
        $output = "";
        
        if($show_scores)
        {
                $query = "SELECT
                count(score_id)	
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
                WHERE
                session_id=".$session_id."
                AND
                time_stamp_start<time_stamp_end
                ";
                
                $rs = $inicrond_db->Execute($query);
                
                $r = $rs->FetchRow();
		
                /*
                time_stamp_start BIGINT UNSIGNED,
                
                time_stamp_end
                */
		if($r["count(score_id)"])//!= 0
		{
                        $output .= " [ ".retournerHref(
                        "../../modules/marks/main.php?session_id=$session_id",
                        $r["count(score_id)"]." ".$_LANG['marks']
                        )." ] ";
		}
        }
        
	if($show_results)
        {
		
                $query = "SELECT
                count(result_id)	
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
                WHERE
                session_id=".$session_id."
                AND
                time_GMT_start<time_GMT_end
                ";
                
                $rs = $inicrond_db->Execute($query);
                
                $r = $rs->FetchRow();
		
                /*
                
                time_GMT_start BIGINT UNSIGNED  ,
                time_GMT_end BIGINT UNSIGNED  ,
                
                */
		if($r["count(result_id)"])//!= 0
		{
                        $output .= " [ ".retournerHref(
                        "../../modules/tests-results/results.php?session_id=$session_id",
                        $r["count(result_id)"]." ".$_LANG['tests-results']
                        )." ] ";
		}
		
	}
	
	if($show_dl_acts)
	{
                $query = "SELECT 
                count(usr_id)
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading']."
                WHERE
                session_id=".$session_id."
                
                ";
                
                $rs = $inicrond_db->Execute($query);
                $f = $rs->FetchRow();
                
		if($f["count(usr_id)"] > 0)
		{
                        $output .= " [ "
                        . retournerHref("../../modules/dl_acts_4_courses/show_dl_acts.mo.php?session_id=$session_id", $f["count(usr_id)"]." ".$_LANG['dl_acts_4_courses']).
                        " ] ";
                        
		}
	}
	return $output;
        
        
}



?>
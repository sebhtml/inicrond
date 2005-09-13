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

/**
* 
*
* @param        integer  $forum_message_id 
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return       array
*/	
function order_posts_in_thread($forum_sujet_id)
{
        global $_OPTIONS, $_RUN_TIME, $inicrond_db;
        
        $return = array();
        
        
        
        $query = "
        SELECT
        forum_message_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
        WHERE
        forum_sujet_id=$forum_sujet_id
        AND
        forum_message_id_reply_to=0
        ";
        
        $rs = $inicrond_db->Execute($query);
	while($fetch_result = $rs->FetchRow())
	{
                $return []= $fetch_result["forum_message_id"];
                $return = array_merge($return, all_child_posts($fetch_result["forum_message_id"]));
	}
        
        
        return $return;
        
        
}

/**
* 
*
* @param        integer  $forum_message_id 
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return       array
*/	
function all_child_posts($forum_message_id)
{
        global $_OPTIONS, $_RUN_TIME, $inicrond_db;
        
        $return = array();
        
        $query = "
        SELECT
        forum_message_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
        WHERE
        forum_message_id_reply_to=$forum_message_id
        ";
        
        $rs = $inicrond_db->Execute($query);
	while($fetch_result = $rs->FetchRow())
	{
                $return []= $fetch_result["forum_message_id"];
                $return = array_merge($return, all_child_posts($fetch_result["forum_message_id"]));
	}
        
        
        return $return;
        
        
}
?>
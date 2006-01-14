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


/**
*
*
* @param        integer  $forum_message_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return       string
*/
function parent_view_count_for_post($forum_message_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $return = "";

    $query = "
    SELECT
    forum_message_id_reply_to
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
    WHERE
    forum_message_id=$forum_message_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if($fetch_result["forum_message_id_reply_to"] == 0)
    {
        return $return;
    }
    else
    {
        $return .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";//add one level

        //recursive call.
        return $return .= parent_view_count_for_post($fetch_result["forum_message_id_reply_to"]);
    }
}
?>
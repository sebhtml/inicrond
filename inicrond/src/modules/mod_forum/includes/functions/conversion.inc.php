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

if(!__INICROND_INCLUDED__)
{
    exit();
}
/**
* find in which thread is a message
*
* @param        integer  $forum_message_id      the ID of the msg
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function message2sujet($forum_message_id)
{

        global $_OPTIONS, $_RUN_TIME, $inicrond_db;

        $query =
        "SELECT
        forum_sujet_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
        WHERE
        forum_message_id=$forum_message_id
        ";
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        return $fetch_result["forum_sujet_id"];

}
/**
* find in which discussion is a thread
*
* @param        integer  $forum_sujet_id      the ID of the thread
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function sujet_2_discussion($forum_sujet_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    forum_discussion_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
    WHERE
    forum_sujet_id=$forum_sujet_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result["forum_discussion_id"];
}

/**
* find in which section is the forum
*
* @param        integer  $forum_discussion_id      the ID of the forum
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function section_to_course($forum_section_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
    WHERE
    forum_section_id=$forum_section_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}



/**
*
*
* @param        integer  $forum_discussion_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function forum_to_cours($forum_discussion_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $section_id = forum_2_section($forum_discussion_id);

    return section_to_course($section_id);
}

/**
*
*
* @param        integer  $forum_discussion_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function forum_2_section($forum_discussion_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    forum_section_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    forum_discussion_id=$forum_discussion_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result["forum_section_id"];
}

?>
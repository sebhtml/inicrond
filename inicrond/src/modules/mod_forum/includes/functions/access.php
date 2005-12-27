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
* tell if the person is a moderator...
*
* @param        integer  $usr_id       the ID of the user
* @param        integer  $forum_discussion_id      the ID of the discussion
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_mod($usr_id, $forum_discussion_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if(!isset($_SESSION['usr_id']))//pas de session
    {
        return FALSE;//faux!!!
    }//fin du if

    if($_SESSION['SUID'])
    {
        return TRUE;
    }

    $query = "
    SELECT
    count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id)
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_moderators'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."_usrs
    WHERE
    forum_discussion_id=$forum_discussion_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_moderators'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."_usrs.group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."_usrs.usr_id=$usr_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return ($fetch_result["count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."_usrs.usr_id)"] != 0);
}
/**
* tell if someone can start a thread in a forum.
*
* @param        integer  $usr_id       the ID of the user
* @param        integer  $forum_discussion_id      the ID of forum
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function can_usr_start_thread($usr_id, $forum_discussion_id)
{//ouverture de la fonction peut_il_replier

    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if($_SESSION['SUID'])
    {
        return TRUE;
    }

    //offline check
    if(!isset($usr_id))
    {
        $query = "
        SELECT group_id  AS ACCESS_GRANTED
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_start']."
        WHERE
        forum_discussion_id=$forum_discussion_id
        AND
        group_id=".$_OPTIONS['group_id']['nobody']."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        return isset($fetch_result["ACCESS_GRANTED"]);//somebody can start a thread...
    }

    if(!isset($usr_id))//bye bye nobody...
    {
            return FALSE;
    }

    $query = "
    SELECT usr_id AS ACCESS_GRANTED
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_start']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_start'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    usr_id=$usr_id
    AND
    forum_discussion_id=$forum_discussion_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return  isset($fetch_result["ACCESS_GRANTED"]) ;
}

/**
* tell if someone can start a thread in a forum.
*
* @param        integer  $usr_id       the ID of the user
* @param        integer  $forum_discussion_id      the ID of forum
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function can_usr_view_forum($usr_id, $forum_discussion_id)
{//ouverture de la fonction peut_il_replier

    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if($_SESSION['SUID'])
    {
        return TRUE;
    }
    if(can_usr_admin_section($usr_id, forum_2_section($forum_discussion_id)))
    {
        return true;
    }
    //offline check
    if(!isset($usr_id))
    {
        $query = "
        SELECT
        group_id  AS ACCESS_GRANTED
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view']."
        WHERE
        forum_discussion_id=$forum_discussion_id
        AND
        group_id=".$_OPTIONS['group_id']['nobody']."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        return isset($fetch_result["ACCESS_GRANTED"]);//somebody can start a thread...
    }

    $query = "
    SELECT usr_id AS ACCESS_GRANTED
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    usr_id=$usr_id
    AND
    forum_discussion_id=$forum_discussion_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return  isset($fetch_result["ACCESS_GRANTED"]) ;
}

/**
* tell if someone can reply
*
* @param        integer  $usr_id       the ID of the user
* @param        integer  $forum_sujet_id      the ID of the thread
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function peut_il_replier($usr_id, $forum_sujet_id)
{//ouverture de la fonction peut_il_replier
        global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if($_SESSION['SUID'])
    {
        return TRUE;
    }

    //--------------
    //on vérifie le champs locked.
    //-----------------

    $query = "
    SELECT
    locked
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
    WHERE
    forum_sujet_id=".$forum_sujet_id."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if($fetch_result["locked"]== '1')
    {
            return FALSE;

    }//fin du if

    $forum_discussion_id = sujet_2_discussion($forum_sujet_id);

    //offline check
    if(!isset($usr_id))
    {
        $query = "
        SELECT
        group_id  AS ACCESS_GRANTED
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_reply']."
        WHERE
        forum_discussion_id=$forum_discussion_id
        AND
        group_id=".$_OPTIONS['group_id']['nobody']."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        return isset($fetch_result["ACCESS_GRANTED"]);//somebody can start a thread...
    }

    $query = "
    SELECT
    usr_id AS ACCESS_GRANTED
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_reply']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_reply'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    usr_id=$usr_id
    AND
    forum_discussion_id=$forum_discussion_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return  isset($fetch_result["ACCESS_GRANTED"]) ;

}//fermeture de la fonction peut_il_replier

/**
* tell if someone can start a thread in a forum.
*
* @param        integer  $usr_id       the ID of the user
* @param        integer  $forum_discussion_id      the ID of forum
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function can_usr_view_section($usr_id, $forum_section_id)
{//ouverture de la fonction

    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if($_SESSION['SUID'])
    {
        return TRUE;
    }

    if(can_usr_admin_section($usr_id, $forum_section_id))
    {
        return true;
    }

    //offline check
    if(!isset($usr_id))
    {
        $query = "
        SELECT
        group_id  AS ACCESS_GRANTED
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sections_groups_view']."
        WHERE
        forum_section_id=$forum_section_id
        AND
        group_id=".$_OPTIONS['group_id']['nobody']."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        return isset($fetch_result["ACCESS_GRANTED"]);//somebody can start a thread...
    }

    if(can_usr_admin_section($usr_id, $forum_section_id))
    {
        return TRUE;
    }

    $query = "
    SELECT
    usr_id AS ACCESS_GRANTED
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sections_groups_view']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sections_groups_view'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    usr_id=$usr_id
    AND
    forum_section_id=$forum_section_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return  isset($fetch_result["ACCESS_GRANTED"]) ;
}

/**
* tell if someone can start a thread in a forum.
*
* @param        integer  $usr_id       the ID of the user
* @param        integer  $forum_discussion_id      the ID of forum
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function can_usr_admin_section($usr_id, $forum_section_id)
{//ouverture de la fonction

    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if($_SESSION['SUID'])
    {
        return TRUE;
    }

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id  AS OK
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    forum_section_id=$forum_section_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id
    AND
    is_teacher_group = '1'
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return isset($fetch_result["OK"]);//somebody can start a thread...
}

/**
*
*
* @param        integer  $usr_id
* @param        integer  $forum_discussion_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_teacher_of_forum($usr_id, $forum_discussion_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id  AS OK
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    forum_discussion_id=$forum_discussion_id
    AND

    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
    AND
    is_teacher_group = '1'
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return isset($fetch_result["OK"]);//somebody can start a thread...
}

?>
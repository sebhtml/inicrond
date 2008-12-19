<?php
/*
    $Id: new_posts_since_last_visit.php 93 2006-01-03 23:09:52Z sebhtml $

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005, 2006  Sébastien Boisvert

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
    inputs : $_SESSION['usr_id'], $_GET['cours_id']

    This will show, for each section, foreach forum all new posts with a link to it for the requested course
    It will also show the date of the last visit.
*/
define ('__INICROND_INCLUDED__', TRUE) ;
define ('__INICROND_INCLUDE_PATH__', '../../') ;
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php' ;
include 'includes/languages/'.$_SESSION['language'].'/lang.php' ;

if (isset ($_SESSION['usr_id']) && isset ($_GET['cours_id']) && $_GET['cours_id'] != ''
&& is_numeric ($_GET['cours_id']))
{
    // get the time_t for the last visit
    $query = '
    select
    end_gmt_timestamp
    from
    '.$_OPTIONS['table_prefix'].'online_time
    where
    usr_id = '.$_SESSION['usr_id'].'
    order by end_gmt_timestamp desc
    limit 1,1
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $time_t_for_last_visit = $row['end_gmt_timestamp'] ;

    $query = '
    select distinct
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_sections.forum_section_id as forum_section_id,
    forum_section_name
    from
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_sections,
    '.$_OPTIONS['table_prefix'].'groups_usrs,
    '.$_OPTIONS['table_prefix'].'sections_groups_view
    where
    cours_id = '.$_GET['cours_id'].'
    and
    '.$_OPTIONS['table_prefix'].'sections_groups_view.group_id = '.$_OPTIONS['table_prefix'].'groups_usrs.group_id
    and
    usr_id = '.$_SESSION['usr_id'].'
    and
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_sections.forum_section_id = '.$_OPTIONS['table_prefix'].'sections_groups_view.forum_section_id
    ' ;

    $rs_for_section = $inicrond_db->Execute ($query) ;

    $section = array () ;

    $section_number = 0 ;

    while ($row = $rs_for_section->FetchRow ())
    {
        $forum_section_id = $row['forum_section_id'] ;
        $section[$section_number]['forum_section_id'] = $row['forum_section_id'] ;
        $section[$section_number]['forum_section_name'] = $row['forum_section_name'] ;

        $query = '
        select distinct
        '.$_OPTIONS['table_prefix'].'sebhtml_forum_discussions.forum_discussion_id as forum_discussion_id,
        forum_discussion_name,
        forum_discussion_description
        from
        '.$_OPTIONS['table_prefix'].'sebhtml_forum_discussions,
        '.$_OPTIONS['table_prefix'].'groups_usrs,
        '.$_OPTIONS['table_prefix'].'forums_groups_view
        where
        forum_section_id = '.$forum_section_id.'
        and
        '.$_OPTIONS['table_prefix'].'forums_groups_view.group_id = '.$_OPTIONS['table_prefix'].'groups_usrs.group_id
        and
        usr_id = '.$_SESSION['usr_id'].'
        and
        '.$_OPTIONS['table_prefix'].'sebhtml_forum_discussions.forum_discussion_id = '.$_OPTIONS['table_prefix'].'forums_groups_view.forum_discussion_id
        ' ;

        $rs_for_forum = $inicrond_db->Execute ($query) ;

        $forum_number = 0 ;

        $section[$section_number]['forum'] = array () ;

        while ($row = $rs_for_forum->FetchRow ())
        {
            $section[$section_number]['forum'][$forum_number]['forum_discussion_id'] = $row['forum_discussion_id'] ;
            $section[$section_number]['forum'][$forum_number]['forum_discussion_name'] = $row['forum_discussion_name'] ;
            $section[$section_number]['forum'][$forum_number]['forum_discussion_description'] = $row['forum_discussion_description'] ;

            $forum_discussion_id = $row['forum_discussion_id'] ;

            // get all posts from this forum...

            /*
                get those fields :
                    forum_message_id
                    forum_sujet_id
                    forum_message_titre
                    forum_message_contenu
                    forum_message_add_gmt_timestamp

                from those tables :
                    sebhtml_forum_messages
                    sebhtml_forum_sujets
                    usrs
            */

            $query = '
            select
            '.$_OPTIONS['table_prefix'].'usrs.usr_id as usr_id,
            usr_name,
            usr_nom,
            usr_prenom,
            forum_message_id,
            '.$_OPTIONS['table_prefix'].'sebhtml_forum_sujets.forum_sujet_id as forum_sujet_id,
            forum_message_titre,
            forum_message_contenu,
            forum_message_add_gmt_timestamp
            from
            '.$_OPTIONS['table_prefix'].'sebhtml_forum_messages,
            '.$_OPTIONS['table_prefix'].'sebhtml_forum_sujets,
            '.$_OPTIONS['table_prefix'].'usrs
            where
            '.$_OPTIONS['table_prefix'].'sebhtml_forum_messages.usr_id = '.$_OPTIONS['table_prefix'].'usrs.usr_id
            and
            '.$_OPTIONS['table_prefix'].'sebhtml_forum_sujets.forum_sujet_id = '.$_OPTIONS['table_prefix'].'sebhtml_forum_messages.forum_sujet_id
            and
            '.$_OPTIONS['table_prefix'].'sebhtml_forum_sujets.forum_discussion_id = '.$forum_discussion_id.'
            and
            forum_message_add_gmt_timestamp > '.$time_t_for_last_visit.'
            order by forum_message_add_gmt_timestamp desc
            ' ;

            $rs_for_post = $inicrond_db->Execute ($query) ;

            $post_number = 0 ;

            $section[$section_number]['forum'][$forum_number]['post'] = array () ;

            while ($row = $rs_for_post->FetchRow ())
            {
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['usr_id'] = $row['usr_id'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['usr_name'] = $row['usr_name'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['usr_nom'] = $row['usr_nom'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['usr_prenom'] = $row['usr_prenom'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['forum_message_id'] = $row['forum_message_id'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['forum_sujet_id'] = $row['forum_sujet_id'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['forum_message_titre'] = $row['forum_message_titre'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['forum_message_contenu'] = $row['forum_message_contenu'] ;
                $section[$section_number]['forum'][$forum_number]['post'][$post_number]['forum_message_add_gmt_timestamp'] = format_time_stamp ($row['forum_message_add_gmt_timestamp']) ;

                $post_number ++ ;
            }

            $forum_number ++ ;
        }

        $section_number ++ ;
    }

    $course_infos = get_cours_infos ($_GET['cours_id']);

    $smarty->assign ('course_infos', $course_infos);

    $smarty->assign ('section', $section) ;

    $date_of_last_visit = sprintf ($_LANG['MOD_FORUMS_the_date_of_your_last_visit_is'], format_time_stamp ($time_t_for_last_visit)) ;

    $smarty->assign ('date_of_last_visit', $date_of_last_visit) ;

    $smarty->assign ('__INICROND_INCLUDE_PATH__', __INICROND_INCLUDE_PATH__) ;
    $module_title = $_LANG['new_posts_since_last_visit'] ;
    $module_content .= $smarty->fetch ($_OPTIONS['theme'].'/new_posts_since_last_visit.tpl') ;
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;

?>
<?php
/*
    $Id: subscribe_to_a_thread.php 94 2006-01-04 01:12:12Z sebhtml $

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
    inputs : $_SESSION['usr_id'], $_GET['forum_sujet_id']
*/

define ('__INICROND_INCLUDED__', TRUE) ;
define ('__INICROND_INCLUDE_PATH__', '../../') ;
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php' ;

include 'includes/functions/access.php' ;
include "includes/functions/conversion.inc.php";

/*
    if the user can view the forum, the person can subscribe
*/

if (isset ($_SESSION['usr_id']) && isset ($_GET['forum_sujet_id']) && $_GET['forum_sujet_id'] != ''
&& is_numeric ($_GET['forum_sujet_id']))
{
    // check if the user is allowed to subscribe

    if (can_usr_view_forum($_SESSION['usr_id'], sujet_2_discussion($_GET['forum_sujet_id'])))
    {
        $query = '
        delete from
        '.$_OPTIONS['table_prefix'].'thread_subscription
        where
        usr_id = '.$_SESSION['usr_id'].'
        and
        forum_sujet_id = '.$_GET['forum_sujet_id'].'
        ' ;

        $inicrond_db->Execute ($query) ;

        $query = '
        insert into
        '.$_OPTIONS['table_prefix'].'thread_subscription
        (usr_id, forum_sujet_id)
        values
        ('.$_SESSION['usr_id'].', '.$_GET['forum_sujet_id'].')
        ' ;

        $inicrond_db->Execute ($query) ;
    }

    // get the cours_id and redirect to the forum main page

    $query = '
    select
    forum_discussion_id
    from
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_sujets
    where
    forum_sujet_id = '.$_GET['forum_sujet_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $forum_discussion_id = $row['forum_discussion_id'] ;

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";

    js_redir('forum_inc.php?&forum_discussion_id='.$forum_discussion_id);
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;
?>
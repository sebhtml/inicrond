<?php
/*
    $Id$

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
    inputs : $_SESSION['usr_id'], $_GET['forum_discussion_id']

    No security check need to be done. Just run the query because SESSION usr_id cannot be cracked. (I think)
*/

define ('__INICROND_INCLUDED__', TRUE) ;
define ('__INICROND_INCLUDE_PATH__', '../../') ;
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php' ;

if (isset ($_SESSION['usr_id']) && isset ($_GET['forum_discussion_id']) && $_GET['forum_discussion_id'] != ''
&& is_numeric ($_GET['forum_discussion_id']))
{
    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'forum_subscription
    where
    usr_id = '.$_SESSION['usr_id'].'
    and
    forum_discussion_id = '.$_GET['forum_discussion_id'].'
    ' ;

    $inicrond_db->Execute ($query) ;

    // get the cours_id and redirect to the forum main page

    $query = '
    select
    cours_id
    from
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_sections,
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_discussions
    where
    '.$_OPTIONS['table_prefix'].'sebhtml_forum_sections.forum_section_id = '.$_OPTIONS['table_prefix'].'sebhtml_forum_discussions.forum_section_id
    and
    forum_discussion_id = '.$_GET['forum_discussion_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $cours_id = $row['cours_id'] ;

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";

    js_redir("main_inc.php?cours_id=$cours_id");

}

?>
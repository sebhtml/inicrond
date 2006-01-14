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

function remove_a_group ($group_id, $inicrond_db, $_OPTIONS)
{
    $sql = '
    select ev_id
    from '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].'
    where
    group_id = '.$group_id.' ';

    $results_set = $inicrond_db->Execute ($sql) ;

    while ($row = $results_set->FetchRow ())
    {
        $sql = '
        delete
        from '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].'
        where ev_id = '.$row ['ev_id'].'
        ';

        $inicrond_db->Execute ($sql) ;
    }

    $tables_to_delete = array(
            'evaluations',
            'sections_groups_view',
            'forums_groups_reply',
            'forums_groups_start',
            'forums_groups_view',
            'sebhtml_moderators',
            'course_group_in_charge',
            'inode_groups',
            'groups_usrs',
            'groups');

    foreach($tables_to_delete AS $t_name)
    {
        $query = "DELETE FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$t_name]."
        WHERE
        group_id=".$_GET['group_id']."
        ";

        $inicrond_db->Execute($query);
    }
}

?>
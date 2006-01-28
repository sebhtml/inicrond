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
* nombre de chose pour un groupe : -> une page qui résume sous forme textuel. dans la même page
    Visites : 4660 pas pour le cours
    Téléchargements : 1614
    Notes Flash : 12518
    Résultats de tests : 2306
    Évaluations : 13
    Nombre de note d'évaluations
    Nombre de personne dans le groupe
*/

function
count_stuff_for_a_group ($group_id, $_OPTIONS, $inicrond_db, $_LANG)
{
    $output = array () ;

    $output['COUNT_groups_usrs'] ;
    $output['COUNT_online_time'] ;
    $output['COUNT_acts_of_downloading'] ;
    $output['COUNT_scores'] ;
    $output['COUNT_results'] ;
    $output['COUNT_evaluations'] ;
    $output['COUNT_user_evaluation_scores'] ;

    //     $output['COUNT_groups_usrs'] ;
    $query = '
    select
    count(usr_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'groups_usrs
    where
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_groups_usrs'] = $row['COUNT'] ;

    //     $output['COUNT_online_time'] ;
    $query = '
    select
    count('.$_OPTIONS['table_prefix'].'online_time.usr_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'groups_usrs,
    '.$_OPTIONS['table_prefix'].'online_time
    where
    '.$_OPTIONS['table_prefix'].'online_time.usr_id = '.$_OPTIONS['table_prefix'].'groups_usrs.usr_id
    and
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_online_time'] = $row['COUNT'] ;

    //     $output['COUNT_acts_of_downloading'] ;
    $query = '
    select
    count('.$_OPTIONS['table_prefix'].'online_time.usr_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'groups_usrs,
    '.$_OPTIONS['table_prefix'].'online_time,
    '.$_OPTIONS['table_prefix'].'acts_of_downloading
    where
    '.$_OPTIONS['table_prefix'].'online_time.usr_id = '.$_OPTIONS['table_prefix'].'groups_usrs.usr_id
    and
    '.$_OPTIONS['table_prefix'].'acts_of_downloading.session_id = '.$_OPTIONS['table_prefix'].'online_time.session_id
    and
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_acts_of_downloading'] = $row['COUNT'] ;

    //     $output['COUNT_scores'] ;

    $query = '
    select
    count('.$_OPTIONS['table_prefix'].'online_time.usr_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'groups_usrs,
    '.$_OPTIONS['table_prefix'].'online_time,
    '.$_OPTIONS['table_prefix'].'scores
    where
    '.$_OPTIONS['table_prefix'].'online_time.usr_id = '.$_OPTIONS['table_prefix'].'groups_usrs.usr_id
    and
    '.$_OPTIONS['table_prefix'].'scores.session_id = '.$_OPTIONS['table_prefix'].'online_time.session_id
    and
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_scores'] = $row['COUNT'] ;

    //     $output['COUNT_results'] ;
    $query = '
    select
    count('.$_OPTIONS['table_prefix'].'online_time.usr_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'groups_usrs,
    '.$_OPTIONS['table_prefix'].'online_time,
    '.$_OPTIONS['table_prefix'].'results
    where
    '.$_OPTIONS['table_prefix'].'online_time.usr_id = '.$_OPTIONS['table_prefix'].'groups_usrs.usr_id
    and
    '.$_OPTIONS['table_prefix'].'results.session_id = '.$_OPTIONS['table_prefix'].'online_time.session_id
    and
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_results'] = $row['COUNT'] ;

    //     $output['COUNT_evaluations'] ;
    $query = '
    select
    count(ev_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'evaluations
    where
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_evaluations'] = $row['COUNT'] ;


    //     $output['COUNT_user_evaluation_scores'] ;
    $query = '
    select
    count(usr_id) as COUNT
    from
    '.$_OPTIONS['table_prefix'].'evaluations,
    '.$_OPTIONS['table_prefix'].'user_evaluation_scores
    where
    '.$_OPTIONS['table_prefix'].'user_evaluation_scores.ev_id =
    '.$_OPTIONS['table_prefix'].'evaluations.ev_id
    and
    group_id = '.$group_id.'' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;
    $output['COUNT_user_evaluation_scores'] = $row['COUNT'] ;

    $output_string = '' ;

    $query = '
    select
    group_id,
    group_name,
    '.$_OPTIONS['table_prefix'].'cours.cours_id,
    cours_code,
    cours_name
    from
    '.$_OPTIONS['table_prefix'].'groups,
    '.$_OPTIONS['table_prefix'].'cours
    where
    '.$_OPTIONS['table_prefix'].'groups.cours_id = '.$_OPTIONS['table_prefix'].'cours.cours_id
    and
    group_id = '.$group_id.'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    foreach ($row as $key => $value)
    {
        $output_string .= $_LANG[$key].' : '.$value.'<br />' ;
    }

    foreach ($output as $key => $value)
    {
        $output_string .= $_LANG[$key].' : '.$value.'<br />' ;
    }

    $output_string .= '<br />' ;
    return $output_string ;
}

?>
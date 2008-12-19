<?php
/*
    $Id: move_up_a_java_identifications_on_a_figure_label.php 99 2006-01-08 02:49:00Z sebhtml $

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

define('__INICROND_INCLUDED__', true) ;
define('__INICROND_INCLUDE_PATH__', '../../') ;
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php' ;
include 'includes/languages/'.$_SESSION['language'].'/lang.php' ;

include 'includes/functions/java_identifications_on_a_figure_label_id_to_inode_id.php' ;
include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/transfert_cours.function.php' ;

if (isset ($_GET['java_identifications_on_a_figure_label_id'])
&& $_GET['java_identifications_on_a_figure_label_id'] != ''
&& is_numeric ($_GET['java_identifications_on_a_figure_label_id']))
{
    $inode_id = java_identifications_on_a_figure_label_id_to_inode_id
        ($_GET['java_identifications_on_a_figure_label_id'], $_OPTIONS, $inicrond_db) ;
}

if (isset ($inode_id)
&& is_teacher_of_cours ($_SESSION['usr_id'], inode_to_course ($inode_id)))
{
    /*
        Check if there is someone up this one
            if yes, get its id
            then swap the two of them...
    */

    $query = '
    select
    order_id
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    where
    java_identifications_on_a_figure_label_id = '.$_GET['java_identifications_on_a_figure_label_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $order_id_current = $row['order_id'] ;
    $java_identifications_on_a_figure_label_id_current = $_GET['java_identifications_on_a_figure_label_id'] ;

    $query = '
    select
    java_identifications_on_a_figure_label_id,
    order_id
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    where
    inode_id = '.$inode_id.'
    and
    order_id < '.$order_id_current.'
    order by order_id desc
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    if (isset ($row['java_identifications_on_a_figure_label_id'])) // there is something up there!!
    {
        $java_identifications_on_a_figure_label_id_before = $row['java_identifications_on_a_figure_label_id'] ;
        $order_id_before = $row['order_id'] ;

        $query = '
        update
        '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
        set
        order_id = '.$order_id_before.'
        where
        java_identifications_on_a_figure_label_id = '.$java_identifications_on_a_figure_label_id_current.'
        ' ;

        $inicrond_db->Execute ($query) ;

        $query = '
        update
        '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
        set
        order_id = '.$order_id_current.'
        where
        java_identifications_on_a_figure_label_id = '.$java_identifications_on_a_figure_label_id_before.'
        ' ;

        $inicrond_db->Execute ($query) ;
    }

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

    js_redir ('edit_a_java_identifications_on_a_figure.php?inode_id='.$inode_id);
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;

?>
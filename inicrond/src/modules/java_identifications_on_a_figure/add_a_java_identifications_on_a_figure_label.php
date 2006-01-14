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

define('__INICROND_INCLUDED__', true) ;
define('__INICROND_INCLUDE_PATH__', '../../') ;
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php' ;
include 'includes/languages/'.$_SESSION['language'].'/lang.php' ;

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";    //function for access...

if (isset ($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id']
&& is_teacher_of_cours ($_SESSION['usr_id'], inode_to_course ($_GET['inode_id'])))
{

    // insert the label

    $query = '
    insert into
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    (
        inode_id,
        label_name,
        x_position,
        y_position,
        order_id
    )
    values
    (
        '.$_GET['inode_id'].',
        \''.$_LANG['new'].'\',
        0,
        0,
        0
    )
    ' ;

    $inicrond_db->Execute ($query) ;

    $java_identifications_on_a_figure_label_id = $inicrond_db->Insert_ID () ;

    // update the label to be equal to the id

    $query = '
    update
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    set
    order_id = '.$java_identifications_on_a_figure_label_id.'
    where
    java_identifications_on_a_figure_label_id = '.$java_identifications_on_a_figure_label_id.'
    ' ;

    $inicrond_db->Execute ($query) ;

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

    js_redir ('edit_a_java_identifications_on_a_figure.php?inode_id='.$_GET['inode_id']);
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php' ;

?>
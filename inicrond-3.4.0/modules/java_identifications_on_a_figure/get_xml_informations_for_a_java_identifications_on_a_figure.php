<?php
/*
    $Id: get_xml_informations_for_a_java_identifications_on_a_figure.php 99 2006-01-08 02:49:00Z sebhtml $

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

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";

if(isset($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id']
&& is_in_inode_group ($_SESSION['usr_id'], $_GET['inode_id']))
{
    $query = '
    select
    inode_id,
    add_time_t,
    edit_time_t,
    title,
    at_random,
    available_result,
    available_sheet,
    image_file_name
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
    where
    inode_id = '.$_GET['inode_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $java_identifications_on_a_figure = $rs->FetchRow () ;

    $java_identifications_on_a_figure['add_time_t_human_readable'] = format_time_stamp ($java_identifications_on_a_figure['add_time_t']) ;

    $java_identifications_on_a_figure['edit_time_t_human_readable'] = format_time_stamp ($java_identifications_on_a_figure['edit_time_t']) ;

    $query = '
    select
    file_name_in_uploads
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
    where
    inode_id = '.$_GET['inode_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $file_name_in_uploads = $row['file_name_in_uploads'] ;

    $infos  = getimagesize($_OPTIONS["file_path"]["uploads"]."/".$file_name_in_uploads);

    $image_width = $infos[0];

    $image_height = $infos[1];

    $java_identifications_on_a_figure['image_width'] = $image_width ;

    $java_identifications_on_a_figure['image_height'] = $image_height ;

    $java_identifications_on_a_figure['image_file_url'] = $_OPTIONS['virtual_addr'].'modules/java_identifications_on_a_figure/get_java_identifications_on_a_figure_image.php?inode_id='.$_GET['inode_id'] ;


    $smarty->assign ('java_identifications_on_a_figure', $java_identifications_on_a_figure) ;

    // get the labels...

    $query = '
    select
    java_identifications_on_a_figure_label_id,
    label_name,
    x_position,
    y_position,
    order_id
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    where
    inode_id = '.$_GET['inode_id'].'
    order by order_id asc
    ' ;

    $rs = $inicrond_db->Execute ($query) ;

    $java_identifications_on_a_figure_label = array () ;

    while ($row = $rs->FetchRow ())
    {
        $java_identifications_on_a_figure_label [] = $row ;
    }

    if ($java_identifications_on_a_figure['at_random'] == '1')
    {
        include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/random.func.php";

        $java_identifications_on_a_figure_label = at_random ($java_identifications_on_a_figure_label) ;
    }

    $smarty->assign ('java_identifications_on_a_figure_label', $java_identifications_on_a_figure_label) ;

    header("Content-type: text/xml; charset=utf-8");

    $smarty->display ($_OPTIONS['theme'].'/get_xml_informations_for_a_java_identifications_on_a_figure.tpl') ;

    die () ;
}

?>
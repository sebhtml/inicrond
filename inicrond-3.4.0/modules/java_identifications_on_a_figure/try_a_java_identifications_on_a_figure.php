<?php
/*
    $Id: try_a_java_identifications_on_a_figure.php 104 2006-01-13 23:00:50Z sebhtml $

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
    title
    from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
    where
    inode_id = '.$_GET['inode_id'].'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    $smarty->assign ('title', $row['title']) ;

    $smarty->assign ('xml_file', $_OPTIONS['virtual_addr'].'modules/java_identifications_on_a_figure/get_xml_informations_for_a_java_identifications_on_a_figure.php?inode_id='.$_GET['inode_id']) ;

    $smarty->display ($_OPTIONS['theme'].'/try_a_java_identifications_on_a_figure.tpl') ;

    die () ;
}

?>
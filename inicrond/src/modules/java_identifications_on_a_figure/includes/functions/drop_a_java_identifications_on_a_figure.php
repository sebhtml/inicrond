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

function
drop_a_java_identifications_on_a_figure ($inode_id, $_OPTIONS, $inicrond_db)
{
    /*
        delete from
            java_identifications_on_a_figure [done]
            java_identification_on_a_figure_label [done]
            java_identifications_on_a_figure_result [done]
            java_identifications_on_a_figure_result_association [done]
            inode_elements [done]
            inode_groups [done]
    */

    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_result_association
    using
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_result_association,
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_result
    where
    inode_id = '.$inode_id.'
    and
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_result_association.java_identifications_on_a_figure_result_id = '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_result.java_identifications_on_a_figure_result_id
    ' ;

    $inicrond_db->Execute ($query) ;

    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'inode_groups
    where
    inode_id = '.$inode_id.'
    ' ;

    $inicrond_db->Execute ($query) ;

    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'inode_elements
    where
    inode_id = '.$inode_id.'
    ' ;

    $inicrond_db->Execute ($query) ;

    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure
    where
    inode_id = '.$inode_id.'
    ' ;

    $inicrond_db->Execute ($query) ;

    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_label
    where
    inode_id = '.$inode_id.'
    ' ;

    $inicrond_db->Execute ($query) ;

    $query = '
    delete from
    '.$_OPTIONS['table_prefix'].'java_identifications_on_a_figure_result
    where
    inode_id = '.$inode_id.'
    ' ;

    $inicrond_db->Execute ($query) ;
}

?>
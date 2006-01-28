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

function
java_identifications_on_a_figure_label_id_to_inode_id
($java_identifications_on_a_figure_label_id, $_OPTIONS, $inicrond_db)
{
    $query = '
    select
    inode_id
    from
    '.$_OPTIONS["table_prefix"].'java_identifications_on_a_figure_label
    where
    java_identifications_on_a_figure_label_id = '.$java_identifications_on_a_figure_label_id.'
    ' ;

    $rs = $inicrond_db->Execute ($query) ;
    $row = $rs->FetchRow () ;

    return $row['inode_id'] ;
}

?>
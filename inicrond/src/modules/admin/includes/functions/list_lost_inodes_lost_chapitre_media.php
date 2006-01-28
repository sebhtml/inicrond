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

/** Returns all chapitre_media that have no inode_id... */

function
list_lost_inodes_lost_chapitre_media ($_OPTIONS, $inicrond_db)
{
    $query = 'SELECT
    chapitre_media_id as id,
    chapitre_media_title as title
    FROM '.$_OPTIONS['table_prefix'].'chapitre_media AS t1
    WHERE  NOT
    EXISTS (

    SELECT inode_id
    FROM '.$_OPTIONS['table_prefix'].'inode_elements
    WHERE '.$_OPTIONS['table_prefix'].'inode_elements.inode_id = t1.inode_id
    )' ;


    $output = array () ;

    $rs = $inicrond_db->Execute ($query) ;

    $i = 0 ;

    while ($row = $rs->fetchRow ())
    {
        $output[$i] = $row ;

        ++ $i ;
    }

    return $output ;
}

?>
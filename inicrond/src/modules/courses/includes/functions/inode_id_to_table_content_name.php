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
    Find in which table the inode_id is the pointer for
    if the inode is not found, return a empty string
*/
function
inode_id_to_table_content_name ($inode_id, $inicrond_db, $_OPTIONS)
{
        /*
            We first have to find if it is a directory, flash, text, test, file
        */

        $relation_to_search_in = array ('virtual_directories', 'courses_files', 'tests', 'chapitre_media', 'inicrond_images', 'inicrond_texts', 'java_identifications_on_a_figure') ;

        $relation_that_refer_to_the_current_inode = '' ;
        $the_row_have_been_found = false ;

        $amount = count ($relation_to_search_in) ;

        for ($i = 0 ; ($i < $amount) && ($the_row_have_been_found == false) ; $i ++)
        {
            $query = "
            select
            count(inode_id) as count_inode_id
            from
            ".$_OPTIONS['table_prefix'].$relation_to_search_in[$i]."
            where
            inode_id = ".$inode_id."
            " ;

            $rs = $inicrond_db->Execute ($query);

            $fetch_result = $rs->FetchRow ();

            if ($fetch_result['count_inode_id'] == 1)
            {
                $the_row_have_been_found = true ;
                $relation_that_refer_to_the_current_inode = $relation_to_search_in[$i] ;
            }
        }

        return $relation_that_refer_to_the_current_inode ;
}

?>
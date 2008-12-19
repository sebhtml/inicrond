<?php
/*
    $Id: inode_full_path.php 99 2006-01-08 02:49:00Z sebhtml $

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
//$Id: inode_full_path.php 99 2006-01-08 02:49:00Z sebhtml $

/**
* return the inode path
*
* @param        integer  $inode_id    id of an inode
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/

function
inode_full_path($inode_id, $cours_id = NULL)
{
    global $_OPTIONS, $inicrond_db;

    $full_path = '';

    if ($inode_id == 0)//at the root dude.
    {
        //return the cours name
        $query = "
        SELECT
        cours_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE
        cours_id=$cours_id
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        return "<a href=\"inode.php?cours_id=$cours_id\">".$fetch_result['cours_name']."</a>";
    }
    else
    {
        /*
            Get inode_id_location
        */

        $query = "
        select
        inode_id_location
        from
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        where
        inode_id = $inode_id
        " ;

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $inode_id_location = $fetch_result['inode_id_location'] ;

        /*
            We first have to find if it is a directory, flash, text, test, file
        */

        $relation_to_search_in = array ('virtual_directories', 'courses_files', 'tests', 'chapitre_media', 'inicrond_images', 'inicrond_texts', 'java_identifications_on_a_figure') ;

        $relation_that_refer_to_the_current_inode = '' ;
        $the_row_have_been_found = false ;

        $amount = count ($relation_to_search_in) ;

        for ($i = 0 ; ($i <= $amount) && ($the_row_have_been_found == false) ; $i ++)
        {
            $query = "
            select
            count(inode_id) as count_inode_id
            from
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$relation_to_search_in[$i]]."
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

        // add the final name
        if ($relation_that_refer_to_the_current_inode == 'virtual_directories')
        {
            $query = "
            SELECT
            dir_name as NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']."
            WHERE
            inode_id=".$inode_id."
            ";
        }
        elseif ($relation_that_refer_to_the_current_inode == 'courses_files')
        {
            $query = "
            SELECT
            file_title AS NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
            WHERE
            inode_id=".$inode_id."
            ";
        }
        elseif ($relation_that_refer_to_the_current_inode == 'tests')
        {
            $query = "
            SELECT
            test_name AS NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
            WHERE
            inode_id=".$inode_id."
            ";
        }
        elseif ($relation_that_refer_to_the_current_inode == 'chapitre_media')
        {
            $query = "
            SELECT
            chapitre_media_title AS NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
            WHERE
            inode_id=".$inode_id."
            ";
        }
        elseif ($relation_that_refer_to_the_current_inode == 'inicrond_images')
        {
             $query = "
             SELECT
            img_title AS NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
            WHERE
            inode_id=".$inode_id."
            ";
        }
        elseif ($relation_that_refer_to_the_current_inode == 'inicrond_texts')
        {
            $query = "
            SELECT
            text_title AS NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
            WHERE
            inode_id=".$inode_id."
            ";
        }
        elseif ($relation_that_refer_to_the_current_inode == 'java_identifications_on_a_figure')
        {
            $query = "
            SELECT
            title AS NAME
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['java_identifications_on_a_figure']."
            WHERE
            inode_id=".$inode_id."
            ";
        }

        //get the content_name.
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        $NAME = $fetch_result['NAME'];

        if($relation_that_refer_to_the_current_inode != 'virtual_directories')//  is not a directory.
        {
            $full_path = "".$NAME."";
        }
        else //is a directory, show the link...
        {
            $full_path = "<a href=\"".__INICROND_INCLUDE_PATH__.
                "modules/courses/inode.php?&inode_id_location=".$inode_id."\">".$NAME."</a>";
        }

        if ($inode_id_location == 0)//bang the root...
        {//return the full path with the course name.

            //get the course id
            $query = "
            SELECT
            cours_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
            WHERE
            inode_id=".$inode_id."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
            ";

            $rs = $inicrond_db->Execute($query);
            $fetch_result = $rs->FetchRow();

            return "<a href=\"".__INICROND_INCLUDE_PATH__.
                "modules/courses/inode.php?&cours_id=".$fetch_result['cours_id']."\">".
                $fetch_result['cours_name']."</a>"." &gt;&gt; ".$full_path;//pas d'erreur

        }//end of final function return.
        else///Recursive call.
        {
            //recursive call.
            //echo "Recursive call<br />";
            return inode_full_path($inode_id_location)." &gt;&gt; ".$full_path;

        }//end of recursivve call block.
    }//end of else for not equal to 0.
}//end of function.

?>
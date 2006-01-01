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

define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include "includes/functions/transfert_cours.function.php";      //transfer IDs

if (is_teacher_of_cours ($_SESSION['usr_id'], inode_to_course ($_GET['inode_id'])))
{
    /*
        We first have to find if it is a directory, flash, text, test, file
    */

    $relation_to_search_in = array ('virtual_directories', 'courses_files', 'tests', 'chapitre_media', 'inicrond_images', 'inicrond_texts') ;

    $relation_that_refer_to_the_current_inode = '' ;
    $the_row_have_been_found = false ;

    for ($i = 0 ; ($i <= 5) && $the_row_have_been_found == false ; $i ++)
    {
        $query = "
        select
        count(inode_id) as count_inode_id
        from
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$relation_to_search_in[$i]]."
        where
        inode_id = ".$_GET['inode_id']."
        " ;

        $rs = $inicrond_db->Execute ($query);

        $fetch_result = $rs->FetchRow ();

        if ($fetch_result['count_inode_id'] == 1)
        {
            $the_row_have_been_found = true ;
            $relation_that_refer_to_the_current_inode = $relation_to_search_in[$i] ;
        }
    }

    //------------
    //Here I get the course in which the thing is...
    //----------

    $query = "
    SELECT
    cours_id, inode_id_location, order_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=".$_GET['inode_id']."
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $cours_id = $fetch_result['cours_id'];
    $inode_id_location = $fetch_result['inode_id_location'];
    $order_id_present = $fetch_result["order_id"];

    //Get the one just before this one.
    $query = "
    SELECT
    MAX(order_id) AS order_id_other
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$relation_that_refer_to_the_current_inode]."
    WHERE
    order_id<$order_id_present
    AND
    inode_id_location=$inode_id_location
    AND
    cours_id=$cours_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$relation_that_refer_to_the_current_inode].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    if (isset ($fetch_result["order_id_other"]))        //est-ce qu'il y a quelque chose avant.
    {
        $order_id_avant = $fetch_result["order_id_other"];

        //on va chercher  avant.
        $query = "
        SELECT
        inode_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        order_id=".$fetch_result["order_id_other"]."
        ";

        $rs = $inicrond_db->Execute ($query);
        $fetch_result = $rs->FetchRow ();

        $inode_id_before = $fetch_result['inode_id'];

        $query =                //on met le order id du présent à celui avant.
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        SET
        order_id=".$order_id_avant."
        WHERE
        inode_id=".$_GET['inode_id'].   //celui qui est avant
        "
        ";

        $inicrond_db->Execute ($query);

        $query =                //celui qui est en haut descend
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        SET
        order_id=".$order_id_present."
        WHERE
        inode_id=".$inode_id_before."
        ";

        $inicrond_db->Execute ($query);
    }

    $query = "
    SELECT
    cours_id,
    inode_id_location
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=".$_GET['inode_id']."
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";       //javascript redirection
    js_redir ("inode.php?cours_id=".$fetch_result['cours_id']."&inode_id_location=".$fetch_result['inode_id_location']."");
}

?>

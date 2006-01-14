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

if (is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']))
{
    if ($_GET['inode_id_location'] != 0)
    {
        $query = "
        SELECT
        cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        inode_id=".$_GET['inode_id_location']."
        ";

        $rs = $inicrond_db->Execute ($query);
        $fetch_result = $rs->FetchRow ();
        $cours_id = $fetch_result['cours_id'];
    }
    else
    {
        $cours_id = $_GET['cours_id'];
    }

    //inode_id_location
    if (!isset ($_GET['inode_id_location']))
    {
        $module_content .=  "1";
    }
    elseif ($_GET['inode_id_location'] == "")
    {
        $module_content .=  "2";
    }
    elseif (!(((int) $_GET['inode_id_location']) OR $_GET['inode_id_location'] == 0))
    {
        $module_content .=  "3";
    }
    else
    {
        //insert the inode
        $sql = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        (inode_id_location, cours_id)
        VALUES
        (".$_GET['inode_id_location'].", $cours_id)
        ";

        $inicrond_db->Execute ($sql);

        //get the order_id
        $order_id = $inicrond_db->Insert_ID ();

        //update the order id
        $sql = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        SET
        order_id=$order_id
        WHERE
        inode_id=$order_id
        ";

        $inode_id = $order_id ;

        //insert the virtual directory.
        $inicrond_db->Execute ($sql);
        $sql = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']."
        (dir_name, inode_id)
        VALUES
        ('".$_LANG['new']."', $inode_id)
        ";

        $inicrond_db->Execute ($sql);

        //javascript redirection
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";

        js_redir (__INICROND_INCLUDE_PATH__.                    "modules/courses/inode.php?cours_id=$cours_id&inode_id_location=".
                    $_GET['inode_id_location']."");
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
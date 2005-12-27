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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

$is_teacher_of_cours = is_teacher_of_cours($_SESSION['usr_id'],$_GET['cours_id']);


include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";//transfer IDs
if(isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND

isset($_GET['inode_id_location']) AND
$_GET['inode_id_location'] != "" AND
//(int) $_GET['inode_id_location'] AND

$is_teacher_of_cours AND

(
inode_to_course($_GET['inode_id_location']) == $_GET['cours_id']
OR
$_GET['inode_id_location'] == 0

)






)
{

        $gmt_ts = inicrond_mktime();

        $query = "INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
        (
        test_name,
        cours_id,

        time_GMT_add,
        time_GMT_edit
        )
        VALUES
        (
        \"".$_LANG['new']."\",
        ".$_GET['cours_id'].",

        $gmt_ts,
        $gmt_ts
        )

        ";
        $inicrond_db->Execute($query);

        $test_id = $inicrond_db->Insert_ID();

        $inicrond_db->Execute("INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        (inode_id_location, content_type, content_id, cours_id)
        VALUES
        (".$_GET['inode_id_location'].", 2, ".$test_id.", ".$_GET['cours_id'].")
        ");
        $order_id=$inicrond_db->Insert_ID();

        $inicrond_db->Execute("UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        SET
        order_id=$order_id
        WHERE
        inode_id=$order_id
        ");
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?&cours_id=".$_GET['cours_id']."&inode_id_location=".$_GET['inode_id_location']."");




}



?>

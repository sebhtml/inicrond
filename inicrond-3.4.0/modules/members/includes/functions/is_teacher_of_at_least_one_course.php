<?php
/*
    $Id: is_teacher_of_at_least_one_course.php 85 2005-12-27 03:22:23Z sebhtml $

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

function is_teacher_of_at_least_one_course($usr_id)
{///start of function.

    global $_OPTIONS, $inicrond_db, $_RUN_TIME;//global stuff.

    if(!isset($usr_id))//super user.
    {
        return FALSE;
    }

    if($_SESSION['SUID'])//super user.
    {
        return TRUE;
    }

    if(isset($_RUN_TIME["is_teacher_of_at_least_one_course"]))//internal function caching.
    {
        return $_RUN_TIME["is_teacher_of_at_least_one_course"] ;
    }

    //is the person in at leasst one teacher group?

    $query = "
    SELECT
    usr_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
    WHERE
    is_teacher_group = '1'
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    usr_id = $usr_id
    LIMIT 1
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $_RUN_TIME["is_teacher_of_at_least_one_course"] = isset($fetch_result['usr_id']);

    return isset($fetch_result['usr_id']);

}//end of function.

?>
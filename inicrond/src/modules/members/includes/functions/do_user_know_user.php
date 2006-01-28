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

function do_user_know_user($current_usr_id, $usr_id_to_check)
{///start of function.

    global $_OPTIONS, $inicrond_db;//global stuff.

    if($current_usr_id == $usr_id_to_check)//is the same??
    {
        return TRUE;
    }
    elseif(is_in_charge_of_user($current_usr_id, $usr_id_to_check))//is in charge?
    {
        return TRUE;
    }

    //list all the course that the user is in.
    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$current_usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    ";

    $rs = $inicrond_db->Execute($query);

    //foreach course, check if the other user is in the course too.

    while ($fetch_result = $rs->FetchRow())
    {
        $query = "
        SELECT
        COUNT(usr_id)
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id_to_check
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id=".$fetch_result['cours_id']."
        ";

        $rs2 = $inicrond_db->Execute($query);
        $fetch_result = $rs2->FetchRow();

        if ($fetch_result["COUNT(usr_id)"] > 0)// > 0
        {
            return TRUE;
        }
    }

    //the is no course in common for the 2 users.
    return FALSE;

}//end of function.

?>
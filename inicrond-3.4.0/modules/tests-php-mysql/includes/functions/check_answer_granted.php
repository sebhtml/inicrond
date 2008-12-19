<?php
/*
    $Id: check_answer_granted.php 85 2005-12-27 03:22:23Z sebhtml $

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
* find if a usr is the leader of a group
*
* @param        integer  $usr_id
* @param        integer  $answer_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return bool
*/
function
check_answer_granted($usr_id, $answer_id)
{
    global  $granted_answers;

    if(isset($granted_answers[$answer_id]))//already granted.
    {
        return $granted_answers[$answer_id];
    }

    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    question_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
    WHERE
    answer_id=$answer_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $ans = check_question_granted($usr_id, $fetch_result["question_id"]);

    $granted_answers[$answer_id] = $ans;

    return $ans;
}

?>
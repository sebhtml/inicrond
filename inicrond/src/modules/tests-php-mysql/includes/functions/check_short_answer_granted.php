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
* find if a usr is the leader of a group
*
* @param        integer  $usr_id
* @param        integer  $short_answer_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return bool
*/
function check_short_answer_granted($usr_id, $short_answer_id)
{
    global  $granted_short_answers, $inicrond_db;

    if(isset($granted_short_answers[$short_answer_id]))//already granted.
    {
        return $granted_short_answers[$short_answer_id];
    }

    global $_OPTIONS, $_RUN_TIME;

    $query = "
    SELECT
    question_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
    WHERE
    short_answer_id=$short_answer_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $ans = check_question_granted($usr_id, $fetch_result["question_id"]);

    $granted_short_answers[$short_answer_id] = $ans;

    return $ans;
}

?>
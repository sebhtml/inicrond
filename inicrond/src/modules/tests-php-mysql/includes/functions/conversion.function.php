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
* return the id of the course that the test is in
*
* @param        integer  $test_id    id of the test
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function
test_2_cours($test_id)
{
    if(!isset($test_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME;
    global $inicrond_db;

    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    and
    test_id=$test_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}

function
question_2_cours($question_id)
{
    if(!isset($question_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME;
    global $inicrond_db;

    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
    WHERE
    question_id=$question_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}

function
answer_2_cours($answer_id)
{
    if(!isset($answer_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME;
    global $inicrond_db;

    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
    WHERE
    answer_id=$answer_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}

function
multiple_short_answer_2_cours($short_answer_id)
{
    if(!isset($short_answer_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME;
    global $inicrond_db;

    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
    WHERE
    short_answer_id=$short_answer_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}

function
multiple_short_answer_2_test($short_answer_id)
{
    if(!isset($short_answer_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME;
    global $inicrond_db;

    $query = "
    SELECT
    test_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
    WHERE
    short_answer_id=$short_answer_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return $fetch_result['test_id'];
}

?>
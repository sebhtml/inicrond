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

function
delete_test($test_id)
{
    global $_OPTIONS, $inicrond_db;

    $query =
    "DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
    USING
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=$test_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".result_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".result_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".question_ordering_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering'].".question_ordering_id
    ";

    $inicrond_db->Execute($query);

    $query =
    "DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
    USING
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=$test_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".result_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".result_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".question_ordering_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers'].".question_ordering_id
    ";

    $inicrond_db->Execute($query);

    $query =
    "DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage']."
    USING
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=$test_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".result_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".result_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".question_ordering_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage'].".question_ordering_id
    ";

    $inicrond_db->Execute($query);

    $query =
    "DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
    USING
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=$test_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".result_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".result_id
    ";

    $inicrond_db->Execute($query);

    $query =
    "DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
    WHERE
    test_id=".$test_id."";

    $inicrond_db->Execute($query);

    $query =
    "DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
    WHERE
    test_id=".$test_id."";

    $inicrond_db->Execute($query);
}

?>
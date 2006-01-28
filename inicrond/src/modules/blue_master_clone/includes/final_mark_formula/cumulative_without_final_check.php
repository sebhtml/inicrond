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

if(!__INICROND_INCLUDED__)
{
    die () ;
}

$point_obtenus = 0 ;
$points_max = 0 ;

/////
//first off, get all final examens...
$query = "SELECT
ev_score,
ev_weight,
ev_max
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
WHERE
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].".ev_id=  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].".ev_id
AND
usr_id=$usr_id
AND
group_id=$group_id
AND
available = '1'
";

$rs = $inicrond_db->Execute($query);

while($fetch_result = $rs->FetchRow())//foreach evaluation I got.
{
        //if all synthesis pass 60, then return the ponderated mark.
        //else return the ponderate before the synthesis.
        //add the resultat pondere here to add the last column.

        $point_obtenus += ($fetch_result['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight']);

        $points_max += $fetch_result['ev_weight'];

        //there is at last one stuff that is not ok.
}


?>
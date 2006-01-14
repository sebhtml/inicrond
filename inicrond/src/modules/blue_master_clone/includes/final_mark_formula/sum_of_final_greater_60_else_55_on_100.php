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
    die ();
}

/*
    pour acc�er au ynth�e, il faut 60%.
    sinon, cumulatif.

    si la somme des synth�es passe, alors retourner le cumulative,
    sinon, retourner la note si <=55 sinon retourner 55.

*/

//  v�ifier si il y a au moins 60% sans les synth�es.

$point_obtenus = 0 ;
$points_max = 0 ;

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
ev_final = '0'
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
}//end of loop for all none synthesis tests.

if($points_max == 0)//do do anything because there is no evaluations.
{

}
elseif($point_obtenus/$points_max < 0.6)//the cumulative is leseer than 60%...
{
    //he do not pass the session, give him the mark on 100 by additionning all ev_weight.
    $points_max = 0;

    //get all ev_weight.

    $query = "SELECT
    ev_weight
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
        $points_max += $fetch_result['ev_weight'];
    }
}//end of if to check is the person down not have the right to do the synthesis.

else//he can do synthesis dude,
{
    //check the sum of synthesiss.
    $point_obtenus = 0 ;
    $points_max = 0 ;
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
    ev_final = '1'
    AND
    available = '1'
    ";

    $rs = $inicrond_db->Execute($query);

    while($fetch_result = $rs->FetchRow())//foreach evaluation I got.
    {
        $point_obtenus += ($fetch_result['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight']);

        $points_max += $fetch_result['ev_weight'];
    }//end of loop for synthesis tests.

    //analyse the synthesis results.

    if(($points_max != 0)&&  ($point_obtenus/$points_max < 0.6) )//the cumulative is leseer than 60%...
    {
        //the final tests are failed,
        //get the total cumulative .
        //if it is between greater than 55 %, then give 55 %.
        $query = "SELECT
        ev_score,
        ev_max,
        ev_weight
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

        $point_obtenus = 0 ;
        $points_max = 0 ;

        while($fetch_result = $rs->FetchRow())//foreach evaluation I got.
        {
            $point_obtenus += $fetch_result['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight'];
            $points_max += $fetch_result['ev_weight'];
        }

        if($point_obtenus/$points_max > 0.55)//grater than 55% but lesser than 60%.
        {
            //return 55% for no revision of marks.
            $point_obtenus = 55;
            $points_max = 100;
        }//end of between 55 - 60 check.
    }//end of synthesis fail check.

    else//the student is good, the force is with him
    {
        /////////////////
        //at this point, the student is courageous and has beated all synthesis exam,
        //according to this fact, give him his ccumulative and enjoy it.
        /////
        //first off, get all final examens...
        $point_obtenus = 0 ;
        $points_max = 0 ;

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
        }//end of loop for all tests.
    }//the student can do synthesis.
}//end of code for the synthesis analysis because the student has been able to do it...

?>
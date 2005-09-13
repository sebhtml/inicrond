<?php
/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-----------------------------------------------------------------------*/
if(!__INICROND_INCLUDED__){exit;}
/*

piour accéder à l'Examen synthèse, il faut avoir accumuler au moins 60 %
sinon, le cumulatif est attribué.
si l'Examen synthèse est échouer la note de l'Axemen écouhé est attribué.
sinon c'Estle cumulatif.



*/
//vérifier si il y a au moins 60% sans les synthèses.
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
	
	
	
	
}

if($point_obtenus/$points_max < 0.6)//the cumulative is leseer than 60%...
{
        
}
else//can he do the synthesis test???????
{
	//check all examen synthesis 
	//if one fail, give him the failed marks.
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
                
                ///if the evaluation is failed, give the failed one.
                
                
                $point_obtenus = ($fetch_result['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight']);
                
                $points_max = $fetch_result['ev_weight'];
                
                
                if($point_obtenus/$points_max < 0.6)//the synthesis is failed...
                {
                        $stop = true;
                        break;//exit the loop.
                }
                
        }
        
        if(!$stop)
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
                        
                        
                        
                }
        }//end of stop checking.
}

?>
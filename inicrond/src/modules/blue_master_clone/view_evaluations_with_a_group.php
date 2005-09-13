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
define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.

include __INICROND_INCLUDE_PATH__."modules/inicrond_x/includes/languages/".$_SESSION['language'].'/lang.php';//init inicrond kernel
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/z_with_color.php";
include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";//init inicrond kernel
include "includes/etc/final_mark_formula.php";//init inicrond kernel
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/inicrond_compute_final_mark.php";
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';

if(

//always with the get group _id.
isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND
$cours_id = group_id_to_cours_id($_GET['group_id']) AND 
(
(
//one student at the same time.
isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])
)
OR
(
//the etacher see a lot of stuff.

is_teacher_of_cours($_SESSION['usr_id'], $cours_id)//a teacher only can see this very page.
)



)
)
{
        
        //show some informations.
        $query = "SELECT
	
        group_id,
        group_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
        cours_code,
        cours_name
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']." 
        WHERE 
        group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        foreach($fetch_result AS $key => $value)
        {
                $module_content .= $_LANG[$key]. " : ".$value."<br />";
        }
        
        $module_content .= "<br /><br />";
        
        //show the formula for the final mark.
        ///
        
        
        $query = "SELECT
	
        final_mark_formula
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
        WHERE 
        group_id=".$_GET['group_id']."
        
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        $module_content .= 
        $_LANG['final_mark_formula']." : ". $_LANG[$final_mark_formula[$fetch_result['final_mark_formula']]].
        "<br />".
        $_LANG[$final_mark_formula[$fetch_result['final_mark_formula']]."_info"]."<br /><br />";
        
        $final_mark_formula_value = $fetch_result['final_mark_formula'] ;
        /////////////////////////////
        //Here I compute all final marks...
        
        $parameters = array(
        'min',
        'max',
        'sum',
        'count',
        'mean',
        'median',
        //'mode',
        'midrange',
        //'geometric_mean',
        //'harmonic_mean',
        'stdev',
        //'absdev',
        //'variance',
        //'range',
        //'std_error_of_mean',
        //'skewness',
        //'kurtosis',
        'coeff_of_variation'
        );
        $final_marks_dataset = array();//the array that will contain the final marks data set.
        $query = "SELECT 		
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        
        AND
        group_id=".$_GET['group_id']."
        ORDER BY usr_nom ASC
        
        ";
        $rs = $inicrond_db->Execute($query);
        
        
        $i = count($parameters)+1 ;
        while($fetch_result = $rs->FetchRow())
        {
                //print_r($fetch_result);
                
                $final_mark[$i] = inicrond_compute_final_mark($fetch_result['usr_id'], $_GET['group_id']) ;
                
                $final_marks_dataset []= $final_mark[$i]['percentage'];
                
                $i++;
        }
        
        
        
        
        
        
        include PEAR_PATH."Math/Stats.php";//PEAR MATH STATS BY Jesus	
	$Math_Stats = new Math_Stats();
        
        $Math_Stats->setData($final_marks_dataset, STATS_DATA_SIMPLE);
        $final_marks_dataset_stats = $Math_Stats->calcFull();
        
        
        
        //end of final marks computing.
        
        $module_title = $_LANG['view_evaluations'];
        
        if(!isset($_GET['usr_id']))
        {
                $external_modules = array('add_evaluation', 'evaluations_graphics_for_a_group', 'edit_final_mark_formula', 'inherit_from_a_group', 'final_mark_output');
                
                foreach($external_modules AS $key)
                {
                        $module_content .= "<br /><a href=\"$key.php?group_id=".$_GET['group_id']."\">".$_LANG["$key"]."</a>";
                }
        }
        
        
        $i = 0 ;
        
        //$tableau_to_print[$i][] =$_LANG['usr_id'];
        //$tableau_to_print[$i][] =$_LANG['usr_name'];
        $tableau_to_print[$i][] =$_LANG['usr_nom'];
        //$tableau_to_print[$i][] =$_LANG['usr_prenom'];
        
        //get all evaluation for this group.
        $query = "SELECT 
        ev_id,
        ev_name,
        comments,
        available,
        ev_final,
        ev_max,
        ev_weight
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
        
        WHERE
        group_id=".$_GET['group_id']."
        ORDER BY order_id ASC
        ";
	$rs = $inicrond_db->Execute($query);
	
	while($fetch_result = $rs->FetchRow())
        {
                
                if(!$fetch_result['available'] AND isset($_GET['usr_id']))
                {
                        continue;
                }
                if(!isset($_GET['usr_id']))
                {
                        $stuffs = array(
                        array('move_evaluation_left', "templates/inicrond_default/images/left.gif"),
                        array('edit_evaluation', "templates/inicrond_default/images/edit.gif"),
                        array('remove_evaluation', "templates/inicrond_default/images/delete.gif"), 
                        array('edit_evaluation_entries', "templates/inicrond_default/images/icon.gif"), 
                        array('move_evaluation_right', "templates/inicrond_default/images/right.gif")
                        );
                        
                        
                        
                        $evaluation_links = "";
                        foreach($stuffs AS $stuff)
                        {
                                $evaluation_links.="<a href=\"".$stuff[0].".php?ev_id=".$fetch_result['ev_id']."\"><img src=\"".$stuff[1]."\" title=\"".$_LANG[$stuff[0]]."\" border=\"0\" /></a> ";
                        }
                        
                }
                $tableau_to_print[$i][] = "<br />".$fetch_result['ev_name']."<br /><small> ".nl2br($fetch_result['comments'])."</small>"."<br />".
                
                ($fetch_result['available'] ? "" : "<span style=\"color: red;\"><b>".$_LANG['not_available']."</b></span>")."<br />"
                . ($fetch_result['ev_final'] ? "<b><span style=\"color: darkblue;\">".$_LANG['ev_final']."</span></b>" : "")."<br />"
                ."".
                //show ev max + ev weight.
                "(".$fetch_result['ev_weight'].")<br />".
                $evaluation_links;
        }
        
        $i ++;
        
        //for this line, put all statistics dude!!!!!!!!!.
        
        
        
        $i = 0 ;
        $i ++;
        
        foreach($parameters AS $parameter)
        { 
                $tableau_to_print[$i][] = $_LANG[$parameter];
                
                $i ++;
        }
        
        
        //here I get all the datasets for each evaluation.
        $query = "SELECT 
        ev_id,
        ev_weight,
        ev_max,
        available
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
        
        WHERE
        group_id=".$_GET['group_id']."
        ORDER BY order_id ASC
        ";
	$rs = $inicrond_db->Execute($query);
        
	while($fetch_result = $rs->FetchRow())//list all evaluations.
        {
                if(!$fetch_result['available'] AND isset($_GET['usr_id']))
                {
                        continue;
                }
                
                $query = "SELECT 
		ev_score
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']." 
                
                WHERE
		ev_id=".$fetch_result['ev_id']."
                
                ";
                $rs2 = $inicrond_db->Execute($query);
                
                $dataset = array();
                while($fetch_result2 = $rs2->FetchRow())//ge all entries.
                {
                        //add the weighted marks.
                        $dataset []= $fetch_result2['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight'];
                }
                
                
                
                
                $Math_Stats->setData($dataset, STATS_DATA_SIMPLE);
                $stats = $Math_Stats->calcFull();
                $i = 0 ;
                $i ++;
                $i = 1 ;
                $evaluations_stats[$fetch_result['ev_id']] =  $stats;//keep those for later.
                foreach($parameters AS $parameter)
                {
                        
                        
                        $tableau_to_print[$i][] = sprintf(__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__, $stats[$parameter]);
                        
                        $i ++;
                }
                
        }//end of evaluation listing.
        
        //$i = 1 ;
        
        
        //$i = 1 ;
        
        foreach($parameters AS $parameter => $processing)
        {          
                $statistics[$parameter] = array("", "<b>".$_LANG[$parameter]."</b>");           
        }
        
        //////////////////////////////////////////////
        //here I would like to list the stats for the final marks.
        //get the final marks dataset.
        /* To do so, I list all user, then I calculate the final marks. */
        
        //this part is done at the end beaucause all final marks are already computed. lol.
        
        
        //select all users from the group.
        
        
        
        $query = "SELECT 
        usr_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
        usr_prenom,
        usr_nom
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        
        AND
        group_id=".$_GET['group_id']."
        
        
        ";
        
        if($_GET['usr_id'])//a single user...
        {
                $query .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_GET['usr_id']." " ;
        }
        
        $query .= " ORDER BY usr_nom ASC " ;
        $rs = $inicrond_db->Execute($query);
        
        
        //$i = 1 ;   
        while($fetch_result = $rs->FetchRow())
        {
                
                //set to 0 the marks.,
                
                $tableau_to_print[$i] [] =$fetch_result['usr_nom'].", ".$fetch_result['usr_prenom'];
                
                
                //check all evaluation for this user (in this group only dude).
                
                $query = "SELECT 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].".ev_id AS ev_id,
		ev_weight,
		ev_max,
                
		ev_score,
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].".comments AS comments,
		available
		
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].".ev_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].".ev_id
		AND
		usr_id=".$fetch_result['usr_id']."
                AND
                group_id=".$_GET['group_id']."
                ORDER BY order_id ASC
		
                
                ";
                $rs2 = $inicrond_db->Execute($query);
                while($fetch_result = $rs2->FetchRow())//foreach evaluation I got.
                {
                        //output the brute score divided by maximum
                        if(!$fetch_result['available'] AND isset($_GET['usr_id']))
                        {
                                continue;
                        }
                        
                        if(!isset($evaluations_stats[$fetch_result['ev_id']]['stdev']))
                        {
                                
                                $evaluations_stats[$fetch_result['ev_id']]['stdev'] = 0 ;
                        }
                        
                        if(isset($fetch_result['ev_max']) AND
                        $fetch_result['ev_max'] AND
                        is_numeric($evaluations_stats[$fetch_result['ev_id']]['stdev'])
                        )//not eq 0.
                        {
                                
                                //print_r($evaluations_stats["18"]);
                                if(isset($evaluations_stats[$fetch_result['ev_id']]['stdev']) AND
                                $evaluations_stats[$fetch_result['ev_id']]['stdev'] AND
                                isset($fetch_result['ev_id']) AND
                                $fetch_result['ev_id'] != ""
                                )
                                {
                                        $value =  
                                        (( $fetch_result['ev_score'])/($fetch_result['ev_max'])*($fetch_result['ev_weight'])//xi
                                        - ($evaluations_stats[$fetch_result['ev_id']]['mean'])
                                        //mean
                                        )/
                                        ($evaluations_stats[$fetch_result['ev_id']]['stdev']) ;
                                        //stdev
                                        
                                }
                                else
                                {
                                        $value = 0 ;
                                        
                                }
                                
                                
                                $tableau_to_print[$i] [] =
                                
                                $fetch_result['ev_score']."&nbsp;/&nbsp;".$fetch_result['ev_max']
                                
                                ."<br /> ".($fetch_result['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight'])."&nbsp;/&nbsp;".$fetch_result['ev_weight'].""
                                
                                ." <br /> ".(($fetch_result['ev_score']/$fetch_result['ev_max']*100))."&nbsp;%"
                                
                                //output the Z stuff.
                                ."<br /> ".z_with_color($value)."".
                                "<br /><b>
                                ".nl2br($fetch_result['comments'])."</b>"
                                ;
                        }
                        else
                        {
                                $tableau_to_print[$i] [] =$fetch_result['ev_max'];//eq 0
                        }
                        
                        
                        
                        
                }
                
                //if($total_ponderation)//not equal to 0
                
                //echo $final_mark[$i]['points_max']."<br />";
                
                
                if($final_marks_dataset_stats['stdev'] AND
                $final_mark[$i]['points_max'] AND
                is_numeric ($final_marks_dataset_stats['stdev']))
                {
                        
                        $value = (
                        ( $final_mark[$i]["points_obtenus"]/
                        $final_mark[$i]['points_max']*100
                        - $final_marks_dataset_stats['mean']
                        //mean
                        )/
                        $final_marks_dataset_stats['stdev']
                        //stdev
                        
                        ) ;
                }
                else
                {
                        $value = 0 ; 
                }  
                
                $tableau_to_print[$i] [] = $final_mark[$i]["points_obtenus"]."&nbsp;/&nbsp;".$final_mark[$i]['points_max']."<br /> ".($final_mark[$i]['percentage'])."&nbsp;%<br />"
                ." ".z_with_color($value)
                ;
                
                
                
                $i++;
        }
        
        //add the ponderation column.
        
        $i = 0 ;
        
        $tableau_to_print[$i][] =$_LANG['final_mark'];
        
        //////////////////
        //add the statistics for the final marks dataset.
        $i = 0 ;
        $i ++;//the second line beginning to 0 index.
        
        
        foreach($parameters AS $parameter)
        { 
                $tableau_to_print[$i][] = $final_marks_dataset_stats[$parameter];
                $i ++;
        }
        
        
        $module_content .= retournerTableauXY($tableau_to_print);
        
        if(isset($_GET['usr_id']))
        {
                $module_content .= "<h3><a href=\"view_my_evaluations.php?cours_id=$cours_id&usr_id=".$_GET['usr_id']."\">".$_LANG['return']."</a></h3>";
                
        }
        else
        {
                
                $module_content .= "<h3><a href=\"list_evaluations.php?cours_id=$cours_id\">".$_LANG['return']."</a></h3>";
        }
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>
<?php
/*
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

*/

define('__INICROND_INCLUDED__', true);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/z_with_color.php";
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

if(isset($_GET['group_id']) && //analysis all groups querys.
$_GET['group_id'] != "")
{
        //function to get only 2 digits.
        
        function get_2_digits($float_number)
        {
                return sprintf("%.2f", $float_number);
        }
        
        //foreach groups separated by a comma, I check if the person is in charge of that group.
        
        $groups_in_get = explode(",", $_GET['group_id']);
        
        $groups = array();
        
        foreach($groups_in_get AS $group_id)
        {
                if(is_in_charge_of_group($_SESSION['usr_id'], $group_id))
                {
                        $groups []= $group_id;
                }
        }
        
        $groups_clause = "";
        
        $count_groups = count($groups);
        
        if($count_groups)
        {
                $cours_id = group_id_to_cours_id($groups[0]);
                
                foreach($groups AS $key => $group_id)//do an sql query with this dude.....
                {
                        $groups_clause .= " group_id=$group_id ";
                        
                        if(($key +1) != $count_groups)//there is something to add yet.
                        
                        {
                                $groups_clause .= " OR ";
                        }
                }
                
                //show the groups.
                $groups_listing = '';
                
                $query = "SELECT 
                group_id,
                group_name	
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                WHERE
                $groups_clause	";
                
                $rs = $inicrond_db->Execute($query);
                while(  $fetch_result = $rs->FetchRow())
                {
                        $groups_listing .= '<a href="'.__INICROND_INCLUDE_PATH__.'modules/groups/grp.php?&group_id='.$fetch_result['group_id'].'">'.$fetch_result['group_name'].'</a><br />';
                }
                
                
                // $is_in_charge_of_group=is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']);
                
                $module_title = $_LANG['inicrond_x_module'];
                include PEAR_PATH.'Math/Stats.php';
                
                
                
                $i = 0;
                
                
                $check_those_things = array(
                //session count
                array(
                "name" => 'sessions_count',
                "query" => "\$query = \"SELECT
                COUNT(usr_id) AS stat_value
                FROM 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
                WHERE
                usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                cours_id=$cours_id
                \" ;
                ",
                "preprocessor" => ""
                )
                ,
                //time count
                array(
                "name" => 'online_time_count',
                "query" => "\$query = \"SELECT
                SUM(end_gmt_timestamp-start_gmt_timestamp) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
                WHERE
                usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                cours_id=$cours_id
                \";
                ",
                "preprocessor" => "format_time_length"
                ),
                //time mean.
                array(
                "name" => 'online_time_count_mean',
                "query" => "\$query = \"SELECT
                SUM(end_gmt_timestamp-start_gmt_timestamp)/COUNT(usr_id) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
                WHERE
                usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                cours_id=$cours_id
                \";
                ",
                "preprocessor" => "format_time_length"
                ),
                //post count
                array(
                "name" => 'posts_count',
                "query" => "\$query = \"SELECT
                COUNT(forum_message_id) stat_value 
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
                AND
                cours_id=$cours_id
                \";
                ",
                "preprocessor" => ""
                ),
                //view of thread
                array(
                "name" => 'views_of_threads',
                "query" => "\$query = \"SELECT
                COUNT(usr_id)  AS stat_value 
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['views_of_threads']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['views_of_threads'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['views_of_threads'].".forum_sujet_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
                AND
                cours_id=$cours_id
                \";
                ",
                "preprocessor" => ""
                ),
                //MARKS
                
                array(
                "name" => 'marks_scores_count',
                "query" => "\$query = \"SELECT
                COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id)  AS stat_value 
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 3 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_stamp_end>time_stamp_start \";
                ",
                "preprocessor" => ""
                ),
                array(
                "name" => 'marks_scores_data_mean',
                "query" => "\$query = \"SELECT
                SUM(points_obtenu/points_max*100)/COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 3 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_stamp_end>time_stamp_start \";
                ",
                "preprocessor" => "get_2_digits"
                ),
                array(
                "name" => 'marks_scores_data_sum',
                "query" => "\$query = \"SELECT
                SUM(points_obtenu/points_max*100) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 3 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id and ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_stamp_end>time_stamp_start \";
                ",
                "preprocessor" => ""
                ),
                array(
                "name" => 'marks_scores_time_mean',
                "query" => "\$query = \"SELECT
                SUM(time_stamp_end-time_stamp_start)/COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 3 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_stamp_end>time_stamp_start \";
                ",
                "preprocessor" => "format_time_length"
                ),
                array(
                "name" => 'marks_scores_time_sum',
                "query" => "\$query = \"SELECT
                SUM(time_stamp_end-time_stamp_start) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 3 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_stamp_end>time_stamp_start \";
                ",
                "preprocessor" => "format_time_length"
                ),
                
                //TESTS.
                
                array(
                "name" => 'tests_scores_count',
                "query" => "\$query = \"SELECT
                COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id)  AS stat_value 
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 2 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_GMT_end>time_GMT_start \";
                ",
                "preprocessor" => ""
                ),
                array(
                "name" => 'tests_scores_data_mean',
                "query" => "\$query = \"SELECT
                SUM(your_points/max_points*100)/COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 2 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_GMT_end>time_GMT_start \";
                ",
                "preprocessor" => "get_2_digits"
                ),
                array(
                "name" => 'tests_scores_data_sum',
                "query" => "\$query = \"SELECT
                SUM(your_points/max_points*100) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 2 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_GMT_end>time_GMT_start \";
                ",
                "preprocessor" => "get_2_digits"
                ),
                array(
                "name" => 'tests_scores_time_mean',
                "query" => "\$query = \"SELECT
                SUM(time_GMT_end-time_GMT_start)/COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 2 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id and ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_GMT_end>time_GMT_start \";
                ",
                "preprocessor" => "format_time_length"
                ),
                array(
                "name" => 'tests_scores_time_sum',
                "query" => "\$query = \"SELECT
                SUM(time_GMT_end-time_GMT_start) AS stat_value
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 2 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id and ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                AND
                time_GMT_end>time_GMT_start \";
                ",
                "preprocessor" => "format_time_length"
                ),
                
                //file donwload.
                array(
                "name" => 'downloads_count',
                "query" => "\$query = \"SELECT
                COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id)  AS stat_value 
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = 1 and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id and
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id=\".\$fetch_result[\"usr_id\"].\"
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=$cours_id
                \";
                ",
                "preprocessor" => ""
                )
                );
                
                
                
                
                $parameters = array(
                'min' => true,
                'max' => true,
                'sum' => true,
                'count' => false,
                'mean' => true,
                'median' => true,
                'mode' => true,
                'midrange' => true,
                'geometric_mean' => true,
                'harmonic_mean' => true,
                'stdev' => true,
                'absdev' => true,
                'variance' => true,
                'range' => true,
                'std_error_of_mean' => true,
                'skewness' => false,
                'kurtosis' => false,
                'coeff_of_variation' => false
                ); 
                
                
                foreach($parameters AS $parameter => $processing)
                {          
                        $statistics[$parameter] = array("".$_LANG[$parameter]);    //horizontal wrow , like a user, but for stats       
                }
                
                
		
                //get all usrs.
                
                $query = "SELECT
                DISTINCT
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id, usr_name, usr_nom, usr_prenom
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                WHERE
                (
                $groups_clause
                )
                AND
                
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
                ORDER BY usr_id ASC
                ";
                
                //echo $query;
                //exit;
                
                $rs = $inicrond_db->Execute($query);
                $data = array();
                
                //session count.
                
                $i = 1 ;//the line #0 is the lang stuff.
                
                $usrs_statistics = array();
                
                while( $fetch_result = $rs->FetchRow())
                {
                        $usrs_statistics[$i] = array();//the statistics for this user.
                        $inicrond_x[$i] = 0 ;
                        
                        $usrs_statistics[$i]['usr_name'] = "<a href=\"".__INICROND_INCLUDE_PATH__."modules/inicrond_x/user_graphics_for_a_course.php?usr_id=".$fetch_result['usr_id']."&cours_id=".$cours_id."\">".$fetch_result['usr_nom'].", ".$fetch_result['usr_prenom']."</a>";
                        
                        //	foreach user, get the count of sessions.
                        
                        foreach($check_those_things AS $a_thing)
                        {
                                
                                //echo $a_thing["query"];
                                
                                eval($a_thing["query"]);
                                
                                $rs2 = $inicrond_db->Execute($query);
                                $fetch_result2 = $rs2->FetchRow();
                                
                                //the raw data for this user.
                                $data[$a_thing["name"]] [$i]= $fetch_result2["stat_value"];
                                
                        }
                        
                        $i++;//increment the user.
                }//end of user loop.
                
                //print_r($usrs_statistics);
                //exit;
                
                //print_R($data['online_time_count'] );
                //exit;
                
                $s = new Math_Stats;
                
                
                foreach($check_those_things AS $a_thing)
                {
                        //column, compute the statistics as a row.
                        if (isset ($a_thing["name"]) && isset ($data[$a_thing["name"]]))
                        {
                        	$s->setData($data[$a_thing["name"]], STATS_DATA_SIMPLE);
                        }
                        
                        $stats = $s->calcFull();
                        foreach($parameters AS $parameter => $processing)
                        {          
                                
                                if($processing AND 
                                $a_thing["preprocessor"] != ""
                                )
                                {
                                        $statistics[$parameter] []= $a_thing["preprocessor"]((int) $stats[$parameter]); 
                                }
                                else
                                {
                                        $statistics[$parameter] []= get_2_digits($stats[$parameter]); 
                                }
                                // $statistics[$parameter] []= ""; 
                                //   $statistics[$parameter] []= "";          
                        }
                        $t = $s->getData();
                        
                        //print_R($t);
                        //exit;
                        //echo $a_thing["name"];
                        
                        
                        //reset the student counter.
                        $i = 1 ;
                        foreach($t AS $key => $value)//t is the data set foreach student.
                        {
                                if($a_thing["preprocessor"] != "")
                                {
                                        $usrs_statistics[$i][$a_thing["name"]] =  $a_thing["preprocessor"]($value)."<br />";
                                        //  $statistics[$parameter] []= $a_thing["preprocessor"]((int) $stats[$parameter]); 
                                }
                                else
                                {
                                	if (!isset ($usrs_statistics[$i][$a_thing["name"]]))
                                	{
                                        	$usrs_statistics[$i][$a_thing["name"]] =  ($value)."<br />";
                                        }
                                        else
                                        {
                                        	$usrs_statistics[$i][$a_thing["name"]] .=  ($value)."<br />";
                                        }
                                }
                                
                                if($stats['sum'])
                                {
                                	
                                	if (DEBUG)
                                	{
                                		echo '$value '.$value.'<br />' ;
                                		echo "\$stats['sum'] ".$stats['sum'].'<br />' ;
                                	}
                                	
                                	
                                        
                                        $usrs_statistics[$i][$a_thing["name"]] .= 
                                         get_2_digits(($value/$stats['sum']*100))."&nbsp;%<br />";
                                         
                                }
                                $i++;
                        }
                        
                        $s->studentize();
                        $t = $s->getData();
                        //$stats = $s->calcFull();
                        
                        
                        //reset the students.
                        $i = 1 ;
                        //update the Z quotes of students...
                        
                        
                        $inicrond_x = array () ;
                        
                        foreach($t AS $key => $value)
                        {
                        	if (!$usrs_statistics[$i])
                        	{
                                	$usrs_statistics[$i][$a_thing["name"]] = z_with_color($value);
                                }
                                else
                                {
                                	$usrs_statistics[$i][$a_thing["name"]] .= z_with_color($value);
                                }
                                
                                if (!isset ($inicrond_x[$i]))
                                {                                	
					$inicrond_x[$i] = 5*(4+$value);
                                }
                                else
                                {
                                	$inicrond_x[$i] += 5*(4+$value);
                                }
                               
				if (DEBUG)
                                {
                                	echo '$inicrond_x[$i] '.$inicrond_x[$i].'<br />' ;
                                }
                                
                                //increment the student .
                                $i++;
                        }//end of loop foreach student.
                        
                        
                        
                        
                }//end of loop for all columns
                
                ////////////----------------
                
                
                
                
                
                
                //add the inicrond X.
                
                
                foreach($inicrond_x AS $i => $inicrond_x_value) 
                {
                        
                        $usrs_statistics[$i]['inicrond_x'] = (int)$inicrond_x[$i] ;
                        
                        
                }
                
                
                
                $usrs_statistics2 = array();//the part with wstats
                
                $i = 0 ;
                $usrs_statistics2[$i] = array(//add the usr name column
                $_LANG['usr_nom']
                );
                
                
                
                
                
                foreach($check_those_things AS $a_thing)//add the column name
                {
                        
                        $usrs_statistics2[$i][]=$_LANG[$a_thing["name"]];
                        
                        
                }
                $usrs_statistics2[$i][]=$_LANG['inicrond_x'];//add the last column.
                
                
                
                //add the end lines.
                foreach($parameters AS $parameter => $processing)
                {          
                        $statistics[$parameter]  []="";//the statistic dont have a inicrond_x
                        
                        $usrs_statistics2 []=  $statistics[$parameter] ; 
                        
                        
                }
                //print_r($usrs_statistics);
                $usrs_statistics = array_merge($usrs_statistics2, $usrs_statistics);
                
                //print_r($usrs_statistics);
                
                $course_infos =  get_cours_infos($cours_id);
                $smarty->assign('course_infos', $course_infos);
                $smarty->assign('usrs_statistics', $usrs_statistics);
                //echo nl2br(print_r($courses, TRUE));
                $smarty->assign('groups_listing', $groups_listing);
                
                $module_content =  $smarty->fetch($_OPTIONS['theme']."/inicrond_x_module.tpl");
                
                
                
        }
}


include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>
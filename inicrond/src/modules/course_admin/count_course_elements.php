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

define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include __INICROND_INCLUDE_PATH__.'modules/courses/includes/languages/'.$_SESSION['language'].'/lang.php';

if(isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND
is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id'])
)//check if the get is ok to understand.
{
        
        $module_title = $_LANG['count_course_elements'];
        
        //get some infos.
        
        $query = "SELECT 
        cours_code,
        cours_name
        
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE
        cours_id=". $_GET['cours_id']."
        
	";
	
	
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        foreach($fetch_result AS $key => $value)
        {
                $module_content .= $_LANG[$key]." : ".$value."<br />";
        }
        
        $module_content .= "<br />";
        
        $stuffs_to_count = array(
        //count groups.
        array(
        "lang_index" => 'groups',
        "query" => "SELECT 
        COUNT(group_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
        
        WHERE
        cours_id=".$_GET['cours_id']."
        
        "
        ),
        //student groups,
        array(
        "lang_index" => 'students_groups',
        "query" => "SELECT 
        COUNT(group_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
        
        WHERE
        cours_id=".$_GET['cours_id']."
        AND
        is_student_group = '1'
        
        "
        ),
        //teacher groups.
        array(
        "lang_index" => 'teachers_groups',
        "query" => "SELECT 
        COUNT(group_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
        
        WHERE
        cours_id=".$_GET['cours_id']."
        AND
        is_teacher_group = '1'
        
        "
        ),
        //in charge groups.
        array(
        "lang_index" => 'groups_in_charge',
        "query" => "SELECT 
        COUNT(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
        
        WHERE
        cours_id=".$_GET['cours_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id
        
        "
        ),
        //count students
        array(
        "lang_index" => 'students',
        "query" => "SELECT 
        COUNT(usr_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        
        WHERE
        cours_id=".$_GET['cours_id']."
        AND
        is_student_group = '1'
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id  
        
        "
        ),
        //count teacher
        array(
        "lang_index" => 'teachers',
        "query" => "SELECT 
        COUNT(usr_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        
        WHERE
        cours_id=".$_GET['cours_id']."
        AND
        is_teacher_group = '1'
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id  
        
        "
        ),
        //count people in charge
        array(
        "lang_index" => 'persons_in_charge',
        "query" => "SELECT 
        COUNT(usr_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        
        WHERE
        cours_id=".$_GET['cours_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id  
        
        "
        ),
        //count all people.
        array(
        "lang_index" => 'persons',
        "query" => "SELECT 
        COUNT(usr_id) AS count_course_elements
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        
        WHERE
        cours_id=".$_GET['cours_id']."
	
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id 
        
        "
        ),
        
        
        //count directories
        array(
        "lang_index" => 'directories',
        "query" => "SELECT
        
        COUNT(inode_id) AS count_course_elements
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
	WHERE
	cours_id=".$_GET['cours_id']."
	AND
	content_type = '0'
        
	"
        ),
        //count files.
        array(
        "lang_index" => 'files',
        "query" => "SELECT
        COUNT(inode_id) AS count_course_elements
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
	WHERE
	cours_id=".$_GET['cours_id']."
	AND
	content_type='1'
	
	"
        ),
        //count tests.
        array(
        "lang_index" => 'tests',
        "query" => "SELECT
        COUNT(inode_id) AS count_course_elements
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
	WHERE
	cours_id=".$_GET['cours_id']."
	AND
	content_type='2'
	
	"
        ),
        //count flashes.
        array(
        "lang_index" => 'flashes',
        "query" => "SELECT
        
	COUNT(chapitre_media_id) AS count_course_elements
	FROM
        
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
	WHERE
	cours_id=".$_GET['cours_id']."
	
	
	
        "
        ),
        
        //count images.
        array(
        "lang_index" => 'images',
        "query" => "SELECT
        
	COUNT(img_id) AS count_course_elements
	FROM
        
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
	WHERE
	cours_id=".$_GET['cours_id']."
	
	
        "
        ),
        //count texts.
        array(
        "lang_index" => 'texts',
        "query" => "SELECT
        
	COUNT(text_id) AS count_course_elements
	FROM
        
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
	WHERE
	cours_id=".$_GET['cours_id']."
	
	
	
        "
        ),
        //count questions.
        array(
        "lang_index" => 'questions',
        "query" =>  "SELECT
        COUNT(question_id) AS count_course_elements
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
	WHERE
	cours_id=".$_GET['cours_id']."    
	"
        ),
        
        //count sessions.
        array(
        "lang_index" => 'visits',
        "query" =>  "SELECT
        COUNT(session_id) AS count_course_elements
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
	WHERE
	cours_id=".$_GET['cours_id']."    
	"
        ),
        //count downloads.
        array(
        "lang_index" => 'downloads',
        "query" =>  "SELECT
        COUNT(act_id) AS count_course_elements
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id
	AND
	cours_id=".$_GET['cours_id']."    
	"
        ),
        //count swf marks.
        array(
        "lang_index" => 'flash_scores',
        "query" =>  "SELECT
        COUNT(score_id) AS count_course_elements
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
	AND
	cours_id=".$_GET['cours_id']."    
	"
        ),
        //count tests results.
        array(
        "lang_index" => 'tests_results',
        "query" =>  "SELECT
        COUNT(result_id) AS count_course_elements
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
	AND
	cours_id=".$_GET['cours_id']."    
	"
        ),
        //count evaluations.
        array(
        "lang_index" => 'evaluations',
        "query" =>  "SELECT
        COUNT(ev_id) AS count_course_elements
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].".group_id
	AND
	cours_id=".$_GET['cours_id']."    
	"
        ),
        );
        
        foreach($stuffs_to_count AS $stuff_to_count)//foreach stuff.
        {
                
                $rs = $inicrond_db->Execute($stuff_to_count["query"]);
                $fetch_result = $rs->FetchRow();
                
                
                $module_content .= $_LANG[$stuff_to_count["lang_index"]]." : ".$fetch_result['count_course_elements']."<br />";
        }
	
        $module_content .= "<h3><a href=\"course_admin_menu.php?cours_id=".$_GET['cours_id']."\">".$_LANG['course_admin_menu']."</a></h3>";
        
}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>
<?php
/*
    $Id: list_questions.php 87 2006-01-01 02:20:14Z sebhtml $

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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/languages/'.$_SESSION['language'].'/lang.php';

//check if the get is ok to understand.
if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id']))
{
        $module_title = $_LANG['list_questions'];

        $module_content .= '<a href="'.__INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/add_q.php?cours_id='.$_GET['cours_id'].'">'.$_LANG['add_q'].'</a>';
        include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/inode_full_path.php';
        include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/languages/".$_SESSION['language'].'/lang.php';

        //to clolumns, the first is the name and the second is the location total length with a link.

        $query = "
        SELECT
        question_id,
        question_code,
        question_name,
        q_type
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ORDER BY question_code
        ";

        $results = array(array($_LANG["question_CODE"], $_LANG['question_name'], $_LANG['q_type']));

        $rs = $inicrond_db->Execute($query);

        while($fetch_result = $rs->FetchRow())
        {
            switch ($fetch_result['q_type'])
            {
                case '0':
                    $fetch_result['q_type'] = 'multiple_choices_question';
                    break;

                case '1':
                    $fetch_result['q_type'] = 'single_answer_question';
                    break;

                case '2':
                    $fetch_result['q_type'] = 'flash_based_question';
                    break;

                case '3':
                    $fetch_result['q_type'] = 'multiple_short_answers_q';
                    break;
            }

            $results []= array(

            $fetch_result["question_code"],$fetch_result['question_name'].' '.retournerHref(__INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/'."edit_a_question.php?question_id=".$fetch_result["question_id"], $_LANG['edit_a_question']).' '.retournerHref(__INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/'."drop_a_question.php?question_id=".$fetch_result["question_id"], $_LANG['remove']), $_LANG[$fetch_result['q_type']]);
        }

        $module_content .= retournerTableauXY($results);

        $module_content .= "<h3><a href=\"course_admin_menu.php?cours_id=".$_GET['cours_id']."\">".$_LANG['course_admin_menu']."</a></h3>";

}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>

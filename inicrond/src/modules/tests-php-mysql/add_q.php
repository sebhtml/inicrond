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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include 'includes/constants/q_type.php' ;

if(is_teacher_of_cours($_SESSION['usr_id'],$_GET['cours_id']))
{
    $module_title = $_LANG['add_q'];

    if(!isset($_GET['q_type']))//show thre possibilities.
    {
        //
        //FIN DU  available_results
        //
        //questions...
        $add_qs = array();
        //ajouter une question choix multiples
        $add_qs []= array("", retournerHref("../../modules/tests-php-mysql/add_q.php?q_type=0&cours_id=".$_GET['cours_id'], $_LANG['add_q_0']));

        //ajouter une question r�onse courte
        $add_qs []= array("", retournerHref("../../modules/tests-php-mysql/add_q.php?q_type=1&cours_id=".$_GET['cours_id'], $_LANG['add_q_1']));

        //ajouter une question FLASH
        $add_qs []= array("", retournerHref("../../modules/tests-php-mysql/add_q.php?q_type=2&cours_id=".$_GET['cours_id'], $_LANG['add_q_2']));


        //add a multiple short answer question
        $add_qs []= array("", retournerHref("../../modules/tests-php-mysql/add_q.php?q_type=3&cours_id=".$_GET['cours_id'], $_LANG['add_q_3']));

        $module_content .= retournerTableauXY($add_qs);
    }
    elseif($_GET['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MULTIPLE_CHOICES_QUESTION
    || $_GET['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_SHORT_ANSWER_QUESTION
    || $_GET['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MEDIA_QUESTION
    || $_GET['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MULTIPLE_SHORT_ANSWERS_QUESTION)
    {
        $query = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
        (
        question_name,
        q_type,
        cours_id
        )
        VALUES
        (
        \"".$_LANG['new']."\",
        ".$_GET['q_type'].",
        ".$_GET['cours_id']."
        )
        ";

        $inicrond_db->Execute($query);

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

        js_redir(__INICROND_INCLUDE_PATH__.'modules/courses/list_questions.php?&cours_id='.$_GET['cours_id']);
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
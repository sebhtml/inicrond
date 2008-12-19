<?php
/*
    $Id: search_forums.php 88 2006-01-03 21:09:08Z sebhtml $

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

define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.

$module_title = $_LANG['search_forums'];

if(is_numeric($_GET['cours_id']) && is_student_of_cours($_SESSION['usr_id'], $_GET['cours_id']))
{
    $smarty->assign('mod_forum', "<a href=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/main_inc.php?cours_id=".$_GET['cours_id']."\">".$_LANG['mod_forum']."</a>");

    if(!isset($_POST["string_to_search"]))
    {
        //----------------------------------------------------------------------------------//
        //First show the form
        //----------------------------------------------------------------------------------//
        $module_content .= $smarty->fetch($_OPTIONS['theme']."/search_forums_form.tpl");
    }
    else//search in authorised forums for this course.
    {
        if (is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']))
        {
            $query = "
            SELECT
            DISTINCT
            forum_message_id,
            forum_message_titre,
            forum_message_contenu,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id as forum_sujet_id,
            forum_message_add_gmt_timestamp,
            forum_discussion_name,
            forum_section_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id AS forum_discussion_id,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
            usr_nom,
            usr_name,
            usr_prenom,
            usr_signature
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".cours_id = ".$_GET['cours_id']."
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
            ";
        }
        else
        {
            $query = "
            SELECT
            DISTINCT
            forum_message_id,
            forum_message_titre,
            forum_message_contenu,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id as forum_sujet_id,
            forum_message_add_gmt_timestamp,
            forum_discussion_name,
            forum_section_name,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id AS forum_discussion_id,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
            usr_nom,
            usr_name,
            usr_prenom,
            usr_signature
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id = ".$_SESSION['usr_id']."
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view'].".group_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view'].".forum_discussion_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".cours_id = ".$_GET['cours_id']."
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
            ";
        }

        //split the string_to_search in words.

        $keywords = explode(' ', $_POST["string_to_search"]);
        $count_keywords = count($keywords);

        $query .= " AND ( ";
        $i = 1;
        foreach($keywords AS $keyword)
        {
            $query .= " forum_message_titre LIKE '%$keyword%' OR forum_message_contenu LIKE '%$keyword%' ";

            if($i != $count_keywords)//do I add the OR
            {
                $query .= " OR ";
            }

            $i++;
        }

        $query .= ")";

        function highlight_keywords($keywords, $input)
        {
            foreach($keywords AS $keyword)
            {
                $input = str_replace($keyword, "<span class=\"keyword\">".$keyword."</span>", $input);
            }

            return $input;
        }

        $rs = $inicrond_db->Execute($query);

        $results = array();

        $i = 0 ;

        while($fetch_result = $rs->FetchRow())//foreach match...
        {
            $results[$i]['usr_name'] =  $fetch_result['usr_name'];
            $results[$i]["usr_link"] =  __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id']."&cours_id=".$_GET['cours_id']."";
            $results[$i]['usr_nom'] =  $fetch_result['usr_nom'];
            $results[$i]['usr_prenom'] =  $fetch_result['usr_prenom'];
            $results[$i]['usr_signature'] =  nl2br($fetch_result['usr_signature']);

            $results[$i]["forum_hyperlink"] =  "forum_inc.php?forum_discussion_id=".$fetch_result["forum_discussion_id"];
            $results[$i]["forum_section_name"] =  $fetch_result["forum_section_name"];
            $results[$i]["forum_discussion_name"] =  $fetch_result["forum_discussion_name"];
            $results[$i]['date'] =  format_time_stamp($fetch_result["forum_message_add_gmt_timestamp"]);
            $results[$i]["forum_message_id"] =  $fetch_result["forum_message_id"];
            $results[$i]["forum_message_titre"] = highlight_keywords($keywords, $fetch_result["forum_message_titre"]);
            $results[$i]['forum_message_contenu'] = highlight_keywords($keywords,$fetch_result['forum_message_contenu']);
            $results[$i]["hyperlink"] = "thread_inc.php?forum_sujet_id=".$fetch_result["forum_sujet_id"]."#".$fetch_result["forum_message_id"];

            $i++;
        }

        $smarty->assign('results', $results);
        $module_content .= $smarty->fetch($_OPTIONS['theme']."/search_forums.tpl");
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
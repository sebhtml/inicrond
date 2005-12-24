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
include __INICROND_INCLUDE_PATH__."includes/class/Month_calendar.class.php";//la classe calendrier.

    if(isset($_GET['year']) && $_GET['year'] != "" && (int) $_GET['year'])//ann�
    {
        if(isset($_GET['month']) && $_GET['month'] != "" && (int) $_GET['month'])//mois
        {
            if(isset($_GET['day']) && $_GET['day'] != "" && (int) $_GET['day'])//jour
            {
                $delta_time = 24*60*60;

                $module_title = "<a href=\"main_inc.php?&year=".$_GET['year']."&cours_id=".$_GET['cours_id']."\">".$_GET['year']."</a>".
                "/".
                "<a href=\"main_inc.php?&year=".$_GET['year']."&month=".$_GET['month']."&cours_id=".$_GET['cours_id']."\">".$_GET['month']."</a>".
                "/".
                "<a href=\"main_inc.php?&year=".$_GET['year']."&month=".$_GET['month']."&day=".$_GET['day']."&cours_id=".$_GET['cours_id']."\">".$_GET['day']."</a>";
            }
            else//mois courant
            {
                //include "includes/class/Month_calendar.class.php";

                $calendrier = new Month_calendar;
                $calendrier->_LANG = $_LANG;
                $calendrier->month = $_GET['month'];
                $calendrier->year = $_GET['year'];
                $calendrier->type = 'big';
                $calendrier->_RUN_TIME = &$_RUN_TIME;
                $tableau = $calendrier->output();

                $delta_time = $calendrier->nombre_de_jour*24*60*60;

                $module_title = "<a href=\"main_inc.php?&year=".$_GET['year']."&cours_id=".$_GET['cours_id']."\">".$_GET['year']."</a>".
                "/".
                "<a href=\"main_inc.php?&year=".$_GET['year']."&month=".$_GET['month']."\"&cours_id=".$_GET['cours_id'].">".$_GET['month']."</a>";
            }
        }
        else//ann� courante
        {
            $tableau = array();

            foreach($_OPTIONS["months"] AS $key )
            {
                $tableau []= array(retournerHref(
                __INICROND_INCLUDE_PATH__."modules/calendar/main_inc.php?year=".$_GET['year']."&month=$key&cours_id=".$_GET['cours_id']."", $_LANG["month_$key"]));
            }

            $delta_time = 365*24*60*60;

            $module_title = "<a href=\"main_inc.php?&year=".$_GET['year']."&cours_id=".$_GET['cours_id']."\">".$_GET['year']."</a>";
        }
    }
    else//toutes les ann�s...
    {

        $annees = array(2004, 2005, 2006, 2007, 2008, 2009, 2010);
        $tableau = array();

        foreach($annees AS $key)
        {
            $tableau []= array(retournerHref(
            __INICROND_INCLUDE_PATH__."modules/calendar/main_inc.php?year=$key&cours_id=".$_GET['cours_id']."", $key));
        }

        $module_title = $_LANG['calendar'];
    }

    if(isset($_GET['cours_id']))
    {
        $course_infos =  get_cours_infos($_GET['cours_id']);
        $module_content .= retournerTableauXY($course_infos);
    }

    if(isset($tableau))
    {
        $module_content .= retournerTableauXY($tableau);
    }

    //$module_content = "";
    if(!isset($_GET['month']))
    {
        $_GET['month'] = 1 ;
    }
    if(!isset($_GET['day']))
    {
        $_GET['day'] = 1 ;
    }

    $start = mktime( 0,0, 0, $_GET['month'], $_GET['day'], $_GET['year'] );

    $end = $start + $delta_time ;
    //      $module_content .= "$start<br />$end";

    if(isset($_GET['year']) && is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id']))
    {
        $calendar_look_up = array(
        array(
        'QUERY_STRING' => "../../modules/marks/main.php?",
        'TITLE' => $_LANG['marks']
        )

        , array(
        'QUERY_STRING' => "../../modules/seSSi/one.php?",
        'TITLE' => $_LANG['seSSi']
        )
        , array(
        'QUERY_STRING' => "../../modules/tests-results/results.php?",
        'TITLE' => $_LANG['tests-results']
        )
        );

        foreach($calendar_look_up AS  $value)
        {
            $module_content .= "<a href=\"".
            $value['QUERY_STRING']."&start=$start&end=$end&cours_id=".$_GET['cours_id']."\">".
            $value['TITLE'].'</a><br />';
        }
    }

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
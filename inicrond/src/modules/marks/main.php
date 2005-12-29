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

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";


if (isset ($_GET['usr_id']) && isset ($_SESSION['usr_id']))
{
    $is_in_charge_of_user=is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']) ;
}

if (isset ($_GET['group_id']) && isset ($_SESSION['usr_id']))
{
    $is_in_charge_of_group=is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']);
}

if(isset($_GET['session_id']) && $_GET['session_id'] != "" && (int) $_GET['session_id'])
{
    include __INICROND_INCLUDE_PATH__."modules/seSSi/includes/functions/conversion.inc.php";//session function
    include __INICROND_INCLUDE_PATH__."includes/functions/is_author_of_session_id.php";//session function
}

if(isset($_SESSION['usr_id']))
{
    $base = __INICROND_INCLUDE_PATH__."modules/marks/main.php?";

    $SELECT_WHAT = "
    SELECT
    cours_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
    usr_name,
    chapitre_media_title,
    points_obtenu/points_max,
    points_obtenu,
    points_max,
    points_obtenu/points_max*100,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id,
    time_stamp_start,
    time_stamp_end-time_stamp_start,
    score_id,
    usr_nom,
    usr_prenom
    ";


    $FROM_WHAT = "
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",

    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    ";

    $WHERE_CLAUSE = "
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".inode_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".session_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    AND
    time_stamp_end>time_stamp_start
    ";

    $it_is_ok = FALSE;

    //en fonction de l'�udiant.
    if(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
    && !isset($_GET['join']) && $is_in_charge_of_user)
    {
        if(isset($_GET['cours_id']) AND
        $_GET['cours_id'] != "" AND
        (int) $_GET['cours_id']
        )
        {
            $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".cours_id=".$_GET['cours_id'];
        }

        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/marks/time_vs_score_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['correlation_between_time_and_score']."</a><br />";

        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['GD_distribution_of_score']."</a><br />";

        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['distribution_of_time']."</a><br />";

        $it_is_ok = TRUE;

        $query = "
        SELECT
        usr_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_id=".$_GET['usr_id']."
        ";

        $rs = $inicrond_db->Execute($query);
        $f = $rs->FetchRow();

        //-----------------------
        // titre
        //---------------------

        $module_title = $_LANG['marks'];

        $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=".$_GET['usr_id']."
        ";

        if($is_in_charge_of_user)
        {
            //
            //Marks by flash and by chapitre_media at the same time...
            //

            $query = "
            SELECT
            chapitre_media_title,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_GET['usr_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
            AND
            time_stamp_end>time_stamp_start
            ";

            if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])
            {
                $query .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_GET['cours_id'];
            }

            $tableX = array(array($_LANG['animations']));
            $already_there = array();

            $rs = $inicrond_db->Execute($query);

            while($f = $rs->FetchRow())
            {
                if(!isset($already_there[$f['chapitre_media_id']]))
                {
                    $tableX []= array(retournerHref("../../modules/marks/main.php?usr_id=".$_GET['usr_id']."&chapitre_media_id=".$f['chapitre_media_id']."&join",
                    $f['chapitre_media_title']));

                    $already_there[$f['chapitre_media_id']] = $f['chapitre_media_id'] ;//don't put it again later..
                }
            }

            $module_content .= retournerTableauXY($tableX);

            //
            // END OF : Marks by flash and by chapitre_media at the same time...
            //
        }
    }
    elseif(isset($_GET['session_id']) && $_GET['session_id'] != "" && (int) $_GET['session_id']
    &&  (
        is_author_of_session_id($_SESSION['usr_id'], $_GET['session_id'])
        OR
        is_in_charge_of_user($_SESSION['usr_id'], session_id_to_usr($_GET['session_id']))))
    {

        $it_is_ok = TRUE;

        $query = "
        SELECT
        usr_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
        WHERE
        session_id=".$_GET['session_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        ";

        $rs = $inicrond_db->Execute($query);
        $f = $rs->FetchRow();

        //title

        $module_title =  $_LANG['marks'];

        $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".session_id=".$_GET['session_id']."
        ";
    }//end of select with session_id

    //en fonctions des flashs
    elseif(isset($_GET['chapitre_media_id']) && $_GET['chapitre_media_id'] != ""
    && (int) $_GET['chapitre_media_id']
    &&  ($is_in_charge_of_user
        OR
        is_teacher_of_cours($_SESSION['usr_id'],chapitre_media_to_cours($_GET['chapitre_media_id']))))
    {
        $it_is_ok = TRUE;
        include "includes/kernel/chapitre_media.inc.php";//for a chapitre_media
    }

    elseif(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
    && !isset($_GET['join']) && $is_in_charge_of_group)
    {
        $it_is_ok = TRUE;

        $base .= '&group_id='.$_GET['group_id'] ;

        $query = "
        SELECT
        chapitre_media_title,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".session_id
        and
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
        ";

        $tableX = array(array(''));

        $already_there = array();

        $rs = $inicrond_db->Execute($query);

        while($f = $rs->FetchRow())
        {
            if(!isset($already_there[$f['chapitre_media_id']]))
            {
                $tableX []= array(retournerHref("".__INICROND_INCLUDE_PATH__."modules/marks/main.php?group_id=".$_GET['group_id']."&chapitre_media_id=".$f['chapitre_media_id']."&join",
                $f['chapitre_media_title']));

                $already_there[$f['chapitre_media_id']] = $f['chapitre_media_id'] ;//don't put it again later..
            }
        }

        $module_content .= retournerTableauXY($tableX);

        //
        // END OF : Marks by flash and by chapitre_media at the same time...
        //

        $query = "
        SELECT
        group_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_GET['group_id']."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $module_title =  $_LANG['marks'];

        $WHERE_CLAUSE .= " AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
        ";

        $FROM_WHAT .= ",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."";
    }
    //par date
    elseif(isset($_GET['start']) && isset($_GET["end"]) && is_numeric($_GET['cours_id'])
    && is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id']))//par date
    {
        $it_is_ok = TRUE;
        $base .= "&start=".$_GET['start']."&end=".$_GET["end"]."&cours_id=".$_GET['cours_id'];

        $WHERE_CLAUSE .= " AND
        time_stamp_start>=".$_GET['start']."
        AND
        time_stamp_start<".$_GET["end"]."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_GET['cours_id']."";

        $module_title =  $_LANG['marks'];

        $module_content .= "<br /><br />".$_LANG['start_date']." : ".format_time_stamp($_GET['start']);

        $module_content .= "<br />".$_LANG['end_date']." : ".format_time_stamp($_GET["end"])."<br /><br />";
    }
    elseif($_SESSION['SUID'])
    //toutes les notes...
    {
        $it_is_ok = TRUE;
        $module_title =  $_LANG['marks'];

        $module_content .= "<a href=\"swf_marks_graphics.php\">".$_LANG['swf_marks_graphics']."</a>";
    }

    if(!$it_is_ok)
    {
        exit();
    }

    //tableau
    $fields = array(
    'usr_nom' => array(
    "col_title" => $_LANG['usr_nom'],
    "col_data" => "\$unit =  \$f['usr_nom'];"
    ),

    'usr_prenom' => array(
    "col_title" => $_LANG['usr_prenom'],
    "col_data" => "\$unit = \$f['usr_prenom'];"
    ),

    'score_id' => array(
    "col_title" => $_LANG['score_id'],
    "col_data" => "\$unit  = \$f[\"score_id\"];"
    ),

    'usr_name' => array(
    "col_title" => $_LANG['usr_name'],
    "col_data" => "\$unit  = retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]);"
    ),

    'cours_name' => array(
    "col_title" => $_LANG['cours_name'],
    "col_data" => "\$unit  =  \"<a href=\\\"../../modules/courses/chapters.php?cours_id=\".\$f['cours_id'].\"\\\">\".\$f['cours_name'].\"</a>\";"
    ),

    'chapitre_media_title' => array(
    "col_title" => $_LANG['title'],
    "col_data" => "\$unit  = retournerHref(\"javascript:popup('../../modules/course_media/flash.php?chapitre_media_id=\".\$f[\"chapitre_media_id\"].\"', 790, 590)\",\$f[\"chapitre_media_title\"]);"
    ),

    'session_id' => array(
    "col_title" => $_LANG['sess_id'],
    "col_data" => "
    \$unit =  \"<a href=\\\"../../modules/seSSi/one_session_page_views.php?session_id=\".\$f[\"session_id\"].\"\\\">\".
    \$f[\"session_id\"].\"</a>\";"
    ),

    "time_stamp_start" => array(
    "col_title" => $_LANG['date'],
    "col_data" => "\$unit  = format_time_stamp(\$f['time_stamp_start']);"
    ),

    "time_stamp_end-time_stamp_start" => array(
    "col_title" => $_LANG['elapsed_time'],
    "col_data" => "\$unit  = format_time_length(\$f['time_stamp_end-time_stamp_start']);"
    ),

    'points_obtenu' => array(
    "col_title" => $_LANG['points_obtenu'],
    "col_data" => "\$unit  = \$f[\"points_obtenu\"];"
    ),

    'points_max' => array(
    "col_title" => $_LANG['points_max'],
    "col_data" => "\$unit  = \$f[\"points_max\"];"
    ),

    'points_obtenu/points_max*100' => array(
    "col_title" => $_LANG['points_obtenu/points_max*100'],
    "col_data" => "\$unit  =  sprintf(\"".__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__."\", \$f[\"points_obtenu/points_max*100\"]).\"%\";"
    )
    );

    if(isset($_GET['usr_id']) && !isset($_GET['join']))
    {
        $base .= "usr_id=".$_GET['usr_id'];
    }
    elseif(isset($_GET['chapitre_media_id']) && !isset($_GET['join']))
    {
        $base .= "chapitre_media_id=".$_GET['chapitre_media_id'];
    }

    $module_content .=  "<script language=\"javascript\">
    <!--

    function popup(url,w,h)
    {
            params ='width='+w+',height='+h+',directories=0,scrollbars=0,location=0,menubar=0,resizable=0,status=0,titlebar=0,toolbar=0';
            winPop = window.open(url,'pop_up',params);//créer l'objet winpop hehe
            winPop.moveTo(0, 0);//met la fenetre en haut à gauche
            winPop.focus();//prend le focus
    }
    //--->
    </script>
    ";

    $query = $SELECT_WHAT.$FROM_WHAT.$WHERE_CLAUSE;

    include __INICROND_INCLUDE_PATH__."includes/class/Table_columnS.class.php";

    $mon_tableau = new Table_columnS();

    $mon_tableau->sql_base = $query;//la requete de base
    $mon_tableau->cols = $fields;//les colonnes
    $mon_tableau->base_url=$base;//l'url de base pour le fichier php.
    $mon_tableau->_LANG=$_LANG;//le language...
    $mon_tableau->inicrond_db=$inicrond_db;
    $mon_tableau->per_page=$_OPTIONS['results_per_page'];

    include __INICROND_INCLUDE_PATH__."includes/functions/statistiques.function.php";//fonctions statistiques...

    $module_content .= $mon_tableau->OUTPUT();
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
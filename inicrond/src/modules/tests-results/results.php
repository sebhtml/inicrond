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

include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/access.function.php";//fonction pour savoir si un �udiant peut faire un test.

include "includes/functions/conversion.function.php";//conversions

//conversions
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/conversion.function.php";
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';

if (isset ($_SESSION['usr_id']) && isset ($_GET['usr_id']))
{
    $is_in_charge_of_user=is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']);
}
elseif (isset ($_SESSION['usr_id']) && isset ($_GET['group_id']))
{
    $is_in_charge_of_group=is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']);
}

if(isset($_GET['session_id']) && $_GET['session_id'] != "" && (int) $_GET['session_id'])
{
    include __INICROND_INCLUDE_PATH__."modules/seSSi/includes/functions/conversion.inc.php";//session function

    include __INICROND_INCLUDE_PATH__."includes/functions/is_author_of_session_id.php";//session function
}

if(isset($_GET['test_id']) && $_GET['test_id'] != "" && (int) $_GET['test_id'])
{
    $is_teacher_of_cours_real = is_teacher_of_cours($_SESSION['usr_id'],test_2_cours($_GET['test_id'])) ;
}

if (isset ($is_teacher_of_cours_real))
{
    $is_teacher_of_cours = $is_teacher_of_cours_real ? "TRUE":"FALSE";
}
else
{
    $is_teacher_of_cours = false ;
}

$SELECT_WHAT = "
SELECT
cours_name,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id,
result_id,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id,
usr_name,
test_name,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id,
time_GMT_start,
time_GMT_end-time_GMT_start,
your_points,
max_points,
your_points/max_points*100,
usr_number,
usr_nom,
usr_prenom
";

$FROM_WHAT = "
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."";

$WHERE_CLAUSE = "
WHERE
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
and
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id
AND
time_GMT_start<time_GMT_end
AND
max_points>0
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
";

$base = __INICROND_INCLUDE_PATH__."modules/tests-results/results.php?";
$it_is_ok = FALSE;

if(isset($_GET['test_id']) && isset($_GET['test_id']) && $_GET['test_id'] != "" && (int)  $_GET['test_id']
&&  ($is_in_charge_of_user
    || //group leader
    (isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
    && isset($_GET['join']) && $is_in_charge_of_group)
    ||
    $is_teacher_of_cours_real
    ))
{
    $it_is_ok = TRUE;
    include "includes/kernel/with_test_id.inc.php";//for a chapitre_media
}

//un membre...
elseif(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id'] && !isset($_GET['join'])
&& $is_in_charge_of_user)
{
    if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])
    {
        $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_GET['cours_id'];
    }

    $it_is_ok = TRUE;

    $sql2 = "
    SELECT
    usr_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
    WHERE
    usr_id=".$_GET['usr_id']."
    ";

    $rs = $inicrond_db->Execute($sql2);
    $f = $rs->FetchRow();

    //-----------------------
    // titre
    //---------------------

    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/correl_time_vs_score.php?usr_id=".$_GET['usr_id']."\">".$_LANG['correlation_between_time_and_score']."</a><br />";

    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['GD_distribution_of_score']."</a><br />";

    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['distribution_of_time']."</a><br />";

    $module_title =  $_LANG['tests-results'];

    $WHERE_CLAUSE  .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_GET['usr_id'];
    $base .= "&usr_id=".$_GET['usr_id'];

    //
    // results for a usrs, show the tes t list for him.
    //
    $query = "
    SELECT
    test_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_GET['usr_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
    AND
    time_GMT_start<time_GMT_end
    AND
    max_points>0
    ";

    if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])
    {
        $query .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_GET['cours_id'];
    }

    $rs = $inicrond_db->Execute($query);

    $tableX = array(array($_LANG['tests-php-mysql']));
    $already_there = array();

    while ($f = $rs->FetchRow())
    {
        if(!isset($already_there[$f['test_id']]))
        {
            $tableX []= array(retournerHref("".__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?usr_id=".$_GET['usr_id']."&test_id=".$f['test_id']."&join",
            $f['test_name']));

            $already_there[$f['test_id']] = $f['test_id'] ;//don't put it again later..
        }
    }

    $module_content .= retournerTableauXY($tableX);

    //
    // END OF : results for a usrs, show the tes t list for him.
    //
}

elseif(isset($_GET['session_id']) && $_GET['session_id'] != "" && (int) $_GET['session_id']
&&  (is_author_of_session_id($_SESSION['usr_id'], $_GET['session_id'])
    || is_in_charge_of_user($_SESSION['usr_id'], session_id_to_usr($_GET['session_id']))))
{
    $it_is_ok = TRUE;

    $sql2 = "
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

    $rs = $inicrond_db->Execute($sql2);
    $fetch_result = $rs->FetchRow();

    //title
    $module_title =  $_LANG['tests-results'];

    $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id=".$_GET['session_id']."
    ";
}//end of select with session_id

elseif(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
&& !isset($_GET['join']) && $is_in_charge_of_group)
{
    $it_is_ok = TRUE;

    $base .= '&group_id='.$_GET['group_id'] ;
    //
    //START OF  : tests results for a test and a group at the same time...
    //

    $sql_4_groups = "
    SELECT
    test_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
    AND
    time_GMT_start<time_GMT_end
    AND
    max_points>0
    ";

    $rs = $inicrond_db->Execute($sql_4_groups);

    $tableX = array(array($_LANG['tests-php-mysql']));
    $already_there = array();

    while($f = $rs->FetchRow())
    {
        if(!isset($already_there[$f['test_id']]))
        {
            $tableX []= array(retournerHref("".__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?group_id=".$_GET['group_id']."&test_id=".$f['test_id']."&join",
            $f['test_name']));

            $already_there[$f['test_id']] = $f['test_id'] ;//don't put it again later..
        }
    }

    $module_content .= retournerTableauXY($tableX);

    //
    // END OF : tests results for a test and a group at the same time...
    //

    $FROM_WHAT .= ",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."";

    $query = "
    SELECT
    group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    group_id=".$_GET['group_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $module_title = $_LANG['tests-results'];

    $WHERE_CLAUSE .= " AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    ";
}

//par date, avec un intervalle
if (isset($_GET['start']) && $_GET['start'] != "" && (int) $_GET['start'] && isset($_GET["end"])
&& $_GET["end"] != "" && (int) $_GET["end"] && is_numeric($_GET['cours_id'])
&& (is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id'])
    || (isset ($_GET['usr_id']) && ($_SESSION['usr_id'] == $_GET['usr_id']))))//par date
{
    $module_content .= "<br /><br />".$_LANG['start_date']." : ".format_time_stamp($_GET['start']);

    $module_content .= "<br />".$_LANG['end_date']." : ".format_time_stamp($_GET["end"])."<br /><br />";

    $it_is_ok = TRUE;
    $base .= "&start=".$_GET['start']."&end=".$_GET["end"]."&cours_id=".$_GET['cours_id'];

    $WHERE_CLAUSE .= " AND
    time_GMT_start>=".$_GET['start']."
    AND
    time_GMT_start<".$_GET["end"]."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id = ".$_GET['cours_id']."";

    $module_title =  $_LANG['tests-results'];
}
elseif($_SESSION['SUID'] && $it_is_ok)//toutes les notes.
{
    $it_is_ok = TRUE;
    $module_content .= "<a href=\"tests_marks_graphics.php\">".$_LANG['tests_marks_graphics']."</a>";
}

if(!$it_is_ok)
{
    exit();
}

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/test_id_2_inode_id.php";

$fields = array(
'usr_nom' => array(
"col_title" => $_LANG['usr_nom'],
"col_data" => "\$unit =  \$f['usr_nom'];"
),

'usr_prenom' => array(
"col_title" => $_LANG['usr_prenom'],
"col_data" => "\$unit = \$f['usr_prenom'];"
),

'usr_name' => array(
"col_title" => $_LANG['usr_name'],
"col_data" => "\$unit = retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=\".\$f['usr_id'], \$f['usr_name']);"
),

"time_GMT_start" => array(
"col_title" => $_LANG['date'],
"col_data" => "\$unit = format_time_stamp(\$f['time_GMT_start']);"
),

"time_GMT_end-time_GMT_start" => array(
"col_title" => $_LANG['elapsed_time'],
"col_data" => "\$unit = format_time_length(\$f['time_GMT_end-time_GMT_start']);"
),

'cours_name' => array(
"col_title" => $_LANG['courses'],
"col_data" => "\$unit  =  \"<a href=\\\"".__INICROND_INCLUDE_PATH__."modules/courses/chapters.php?cours_id=\".\$f['cours_id'].\"\\\">\".\$f['cours_name'].\"</a>\";"
),

'test_name' => array(
"col_title" => $_LANG['title'],
"col_data" => "
\$unit = \"\";

if(is_in_inode_group(".$_SESSION['usr_id'].", test_id_2_inode_id(\$f[\"test_id\"])))
{
    \$unit .= retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/tests-php-mysql/do_it.php?test_id=\".\$f[\"test_id\"], \$f[\"test_name\"]);
}
else
{
    \$unit .= \$f[\"test_name\"];
}

"
)
,
"your_points/max_points*100" => array(
"col_title" => $_LANG['points'],
"col_data" => "
\$unit = \"\";

if(can_usr_check_result(".$_SESSION['usr_id'].", \$f[\"result_id\"]))
{
    \$unit = \$f[\"your_points\"].\"/\".\$f[\"max_points\"].\" = \".sprintf(\"".__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__."\",\$f[\"your_points/max_points*100\"]).\"%\";
}
else
{
    \$unit .= \$_LANG[\"waiting_to_get_result\"];
}
\$unit .= \"<br />\";
if(can_usr_check_sheet(".$_SESSION['usr_id'].", \$f[\"result_id\"]))
{
    \$unit .= \" \".retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/tests-results/result.php?result_id=\".\$f[\"result_id\"], \$_LANG[\"see_ex\"]);
}
else
{
    \$unit .= \" \".\$_LANG[\"see_ex\"];
}
",
"stat_col" => "\$unit = (sprintf('".__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__."',\$f[\"your_points/max_points*100\"])).\"%\";"
)
);

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

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>

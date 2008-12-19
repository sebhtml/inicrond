<?php
/*
    $Id: one.php 87 2006-01-01 02:20:14Z sebhtml $

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

/*
    FROM_WHAT ET WHERE_CLAUSE
*/

$now_GMT = inicrond_mktime();

$SELECT_WHAT =
//requ�e pour toutes les sessions...
"
SELECT
session_id,
start_gmt_timestamp,
end_gmt_timestamp,
REMOTE_ADDR,
end_gmt_timestamp-start_gmt_timestamp,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
dns,
usr_name,
HTTP_USER_AGENT,
usr_number,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
cours_name
";

$FROM_WHAT = "
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
";

$WHERE_CLAUSE = "
WHERE
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
";

$it_is_ok = FALSE;

//base url pour le tableau
$base = __INICROND_INCLUDE_PATH__.'modules/seSSi/one.php';

//un membre...
if(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
&& is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
{
    if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])
    {
        $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id=".$_GET['cours_id'];
    }

    $module_content .= "<a href=\"../../modules/seSSi/sessions_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['GD_sessions_for_ppl']."</a><br />";

    $module_content .= "<a href=\"../../modules/seSSi/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['distribution_of_session_length']."</a><br />";

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

    $module_title =  $_LANG['seSSi'];

    $WHERE_CLAUSE  .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_GET['usr_id'];
    $base .= "?usr_id=".$_GET['usr_id'];
}
elseif(isset($_GET['group_id']) && $_GET['group_id'] != "" && (int) $_GET['group_id']
&& is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']))//un groupe...
{
    $it_is_ok = TRUE;

    $sql2 = "
    SELECT
    group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    group_id=".$_GET['group_id']."
    ";

    $rs = $inicrond_db->Execute($sql2);
    $fetch_result = $rs->FetchRow();

    //-----------------------
    // titre
    //---------------------

    $module_title =  $_LANG['seSSi'];

    $WHERE_CLAUSE .= "
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    ";

    $FROM_WHAT .= ",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."";//table groups_usrs
    $base .= "?group_id=".$_GET['group_id']."";
}

if (isset($_GET['start']) && $_GET['start'] != "" && (int) $_GET['start'] && isset($_GET["end"])
&& $_GET["end"] != "" && (int) $_GET["end"] && is_numeric($_GET['cours_id'])
&&  (is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id'])
    || (isset ($_GET['usr_id']) && ($_SESSION['usr_id'] == $_GET['usr_id']))))//par date
{
    $it_is_ok = TRUE;
    $base .= "?start=".$_GET['start']."&end=".$_GET["end"]."&cours_id=".$_GET['cours_id'];

    $WHERE_CLAUSE .= "
    AND
    start_gmt_timestamp>=".$_GET['start']."
    AND
    start_gmt_timestamp<".$_GET["end"]."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id = ".$_GET['cours_id']."";

    $module_title =  $_LANG['seSSi'];
    $module_content .= "<br /><br />".$_LANG['start_date']." : ".format_time_stamp($_GET['start']);

    $module_content .= "<br />".$_LANG['end_date']." : ".format_time_stamp($_GET["end"])."<br /><br />";
}
elseif ($_SESSION['SUID'])//tous les membres
{
    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/sessions_img.php\" >".$_LANG['GD_sessions_for_ppl']."</a><br />";

    $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/normal_dist_time_img.php\" >".$_LANG['distribution_of_session_length']."</a><br />";

    $module_title =  $_LANG['seSSi'];

    $it_is_ok = TRUE;

    $base .= "?";
}

if (!$it_is_ok)
{
    exit();
}

$font_size = 14 ; //for the text that is small.

include "includes/functions/infos_for_session.php";

if(isset($_GET['usr_id']))//for  usr
{
    $show_scores = "FALSE";
    $show_results = "FALSE";
    $show_dl_acts = "FALSE";

    if(is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
    {
        $show_scores = "TRUE";
    }

    $show_results = "TRUE";

    $show_dl_acts = "TRUE";

    $infos_session_txt = ".infos_for_session(\$f[\"session_id\"], $show_scores, $show_results, $show_dl_acts)";
}

$session_link = "<a href=\\\"one_session_page_views.php?session_id=\".\$f[\"session_id\"].\"\\\">\".\$f[\"session_id\"].\"</a>";

$fields = array(

'session_id' => array(
"col_title" => $_LANG['sess_id'],
"col_data" => "
\$unit =  \"$session_link\"$infos_session_txt;"
),

'usr_name' => array(
"col_title" => $_LANG['usr_name'],
"col_data" => "\$unit =  retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]);"
),

'start_gmt_timestamp' => array(
"col_title" => $_LANG['start_gmt_timestamp'],
"col_data" => "\$unit = format_time_stamp(\$f['start_gmt_timestamp']);",
"no_statistics" => TRUE
),

'end_gmt_timestamp' => array(
"col_title" => $_LANG['end_gmt_timestamp'],
"col_data" => "\$unit = format_time_stamp(\$f['end_gmt_timestamp']);",
"no_statistics" => TRUE
),
'cours_name' => array(
"col_title" => $_LANG['cours_name'],
"col_data" => "\$unit =  \"<a href=\\\"".__INICROND_INCLUDE_PATH__."modules/courses/inode.php?cours_id=\".\$f[\"cours_id\"].\"\\\">\".\$f[\"cours_name\"].\"</a>\";"
),

"end_gmt_timestamp-start_gmt_timestamp" => array(
"col_title" => $_LANG['elapsed_time'],
"col_data" => "\$unit = format_time_length(\$f[\"end_gmt_timestamp-start_gmt_timestamp\"]);"
),

'REMOTE_ADDR' => array(
"col_title" => $_LANG['REMOTE_ADDR'],
"col_data" => "\$unit = \$f[\"REMOTE_ADDR\"];",
"no_statistics" => TRUE
),

'dns' => array(
"col_title" => $_LANG['dns'],
"col_data" => "\$unit = \$f[\"dns\"];",
"no_statistics" => TRUE
),

'HTTP_USER_AGENT' => array(
"col_title" => $_LANG['HTTP_USER_AGENT'],
"col_data" => "\$unit =  \"<span style=\\\"font-size: $font_size;\\\" title=\\\"\".\$f[\"HTTP_USER_AGENT\"].\"\\\">\".\$f[\"HTTP_USER_AGENT\"].\"</span>\";",
"no_statistics" => TRUE
)
);

include __INICROND_INCLUDE_PATH__."includes/class/Table_columnS.class.php";

$mon_tableau = new Table_columnS ();

$query = $SELECT_WHAT.$FROM_WHAT.$WHERE_CLAUSE;

$mon_tableau->sql_base = $query;//la requete de base
$mon_tableau->cols = $fields;//les colonnes
$mon_tableau->base_url=$base;//l'url de base pour le fichier php.
$mon_tableau->_LANG=$_LANG;//le language...
$mon_tableau->inicrond_db=$inicrond_db;
$mon_tableau->per_page=$_OPTIONS['results_per_page'];

include __INICROND_INCLUDE_PATH__."includes/functions/usr_scored.function.php";

include __INICROND_INCLUDE_PATH__."includes/functions/statistiques.function.php";//fonctions statistiques...

$module_content .= $mon_tableau->OUTPUT();

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
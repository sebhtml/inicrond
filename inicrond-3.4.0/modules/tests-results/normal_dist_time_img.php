<?php
/*
    $Id: normal_dist_time_img.php 85 2005-12-27 03:22:23Z sebhtml $

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

$_GET['image'] = "png.png";
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';

include 'includes/languages/'.$_SESSION['language'].'/lang.php';

//conversions
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/conversion.function.php";

include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

$_GET['image'] = $_LANG['test_lengths'];

$query = "
SELECT
time_GMT_end-time_GMT_start AS value
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
WHERE
time_GMT_end>time_GMT_start
and
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
";

//validation
$ok = FALSE;

if(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
&& is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']))
{
    $query2 = "
    SELECT
    usr_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
    WHERE
    usr_id=".$_GET['usr_id']."";

    $rs = $inicrond_db->Execute($query2);
    $fetch_result = $rs->FetchRow();

    $_GET["image"] .= "_".$fetch_result['usr_name'];//the file name...

    $ok = TRUE;
    $query .= " AND usr_id=".$_GET['usr_id']."";
}

if(isset($_GET['test_id']) && $_GET['test_id'] != "" && (int) $_GET['test_id']
&& (isset($_GET['usr_id']) || is_teacher_of_cours($_SESSION['usr_id'],test_2_cours($_GET['test_id']))))
{
    $query2 = "
    SELECT
    test_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
    WHERE
    test_id=".$_GET['test_id']."
    ";

    $rs = $inicrond_db->Execute($query2);
    $fetch_result = $rs->FetchRow();

    $_GET["image"] .= "_".str_replace(" ", "_", $fetch_result['test_name']);//the file name...

    $ok = TRUE;
    $query .= " AND test_id=".$_GET['test_id']."";
}
elseif(is_numeric($_GET['group_id']) && is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']))
{
    $ok = 1 ;
    //////////////////
    //get the cours id for this group.


    //define the query in one shot...



    $query = "
    SELECT
    time_GMT_end-time_GMT_start AS value
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id = ".$_GET['group_id']."
    AND
    time_GMT_end>time_GMT_start
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
    ";
}

$_GET["image"] .= ".png";


if(!$ok)//access denied
{
    exit();
}

include __INICROND_INCLUDE_PATH__."includes/class/Histogram_graphic.php";

$Histogram_graphic = new Histogram_graphic;
$Histogram_graphic->inicrond_db = &$inicrond_db;
$Histogram_graphic->title = &$_LANG['GD_distribution_of_time'];
$Histogram_graphic->query = &$query;
$Histogram_graphic->preprocessor = "format_time_length";
$Histogram_graphic->render();

?>
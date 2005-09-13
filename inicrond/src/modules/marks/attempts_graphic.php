<?php
//$Id$

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
//pear
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";//function to transfer ids of differents dnatures.
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
$_GET['image'] = $_LANG['attempts_graphic'];

$ok = FALSE;

$query = "SELECT time_stamp_start AS time_t FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
WHERE 
time_stamp_end>time_stamp_start 
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id

";

if(isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
(
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])
)
)
{
        $query2 = "SELECT
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


if(
isset($_GET['cours_id']) AND//add cours_id clause.
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id']

)
{
        
        $query .= " AND cours_id=".$_GET['cours_id']."";
}

if(isset($_GET['chapitre_media_id']) AND
$_GET['chapitre_media_id'] != "" AND
(int) $_GET['chapitre_media_id'] AND
(
is_teacher_of_cours($_SESSION['usr_id'],chapitre_media_to_cours($_GET['chapitre_media_id']))
OR
isset($_GET['usr_id'])

)
)
{
        $query2 = "
	SELECT
        
        
	file_name
        
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
        
	WHERE
	chapitre_media_id=".$_GET['chapitre_media_id']."
	
	";
	
	$rs = $inicrond_db->Execute($query2);
        $fetch_result = $rs->FetchRow();
        
        $_GET["image"] .= "_".$fetch_result['file_name'];//the file name...
        
        $ok = TRUE;
        $query .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_GET['chapitre_media_id']."";
}


elseif(is_numeric($_GET['group_id']) AND
is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']) 
)
{
        $ok = 1 ;
        //////////////////
        //get the cours id for this group.
        
        
        //define the query in one shot...
        
        
        
        $query = "SELECT 
        time_stamp_start AS time_t
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id = ".$_GET['group_id']."
        AND
        time_stamp_end>time_stamp_start
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
        
        ";
        /*
        echo $query;
        exit;
        */
}
if(!$ok)
{
        exit();
}
$_GET["image"] .= ".png";




include __INICROND_INCLUDE_PATH__."includes/class/Peaks_graphic.php";

$Peaks_graphic = new Peaks_graphic;

$Peaks_graphic->inicrond_db = &$inicrond_db;
$Peaks_graphic->title = &$_LANG['attempts_graphic'];
$Peaks_graphic->query = &$query;
$Peaks_graphic->render();


?>
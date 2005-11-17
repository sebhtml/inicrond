<?php
//$Id$

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';

include 'includes/languages/'.$_SESSION['language'].'/lang.php';
//pear
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";//function to transfer ids of differents dnatures.

$_GET['image'] = $_LANG['flash_time_vs_score_correlation'];	


$query = "SELECT 
time_stamp_end-time_stamp_start AS x_val,
points_obtenu/points_max*100 AS y_val
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
WHERE 
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = '3'
and
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
and

time_stamp_end>time_stamp_start
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
";
$ok = FALSE;



if(isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])

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
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])
OR
is_teacher_of_cours($_SESSION['usr_id'],chapitre_media_to_cours($_GET['chapitre_media_id']))
)




)

//can he see a usr and a test at the same time ?



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
        time_stamp_end-time_stamp_start AS x_val,
        points_obtenu/points_max*100 AS y_val
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
         ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
         ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = '3'
         and
          ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id =  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id
          and
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
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

$_GET["image"] .= ".png";

if(!$ok)//access denied
{
        echo "boo";
        exit();
}

include __INICROND_INCLUDE_PATH__."includes/class/Correlation_plot.php";
$Correlation_plot = new Correlation_plot;
$Correlation_plot->inicrond_db = &$inicrond_db;
$Correlation_plot->title = &$_LANG['GD_correlation_between_time_and_score'];
$Correlation_plot->query = &$query;
$Correlation_plot->x_preprocessor = "format_time_length";
$Correlation_plot->y_preprocessor = "Y_func";
$Correlation_plot->render();

?>
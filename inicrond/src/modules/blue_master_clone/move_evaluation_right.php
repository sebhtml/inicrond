<?php
//$Id$


define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_cours_id.php";//init inicrond kernel


if(//list all groups for a course.
isset($_GET['ev_id']) AND
$_GET['ev_id'] != "" AND
(int) $_GET['ev_id'] AND
$cours_id = ev_id_to_cours_id($_GET['ev_id']) AND
is_teacher_of_cours($_SESSION['usr_id'], $cours_id)//a teacher only can see this very page.
)
{
        //------------
        //Here I get the course in which the thing is...
        //----------
        
        
        
        //
        
        $query = "
        SELECT
        group_id,
        order_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
        WHERE
        ev_id=".$_GET['ev_id'].
        "
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $group_id = $fetch_result['group_id'];
        $order_id_present = $fetch_result["order_id"];
        
        //Get the one just before this one.
        $query = "
        SELECT
        MIN(order_id) AS order_id_other
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
        WHERE
        order_id>$order_id_present
        AND
        group_id=$group_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        
	if(isset($fetch_result["order_id_other"]))//est-ce qu'il y a quelque chose avant.
	{
                
                $order_id_avant = $fetch_result["order_id_other"];
                //on va chercher la discussion avant.
                $query = "
                SELECT
                ev_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                WHERE
                order_id=".$fetch_result["order_id_other"].//celui qui est avant
                "
                ";
                
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                
                $inode_id_before = $fetch_result['ev_id'];
                
                //we put this one to the left.
                $query =
                "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                SET
                order_id=".$order_id_avant."
                WHERE
                ev_id=".$_GET['ev_id'].//celui qui est avant
                "
                ";
                
                $inicrond_db->Execute($query);
                
                
                
                
                $query = //celui qui est en haut descend
                "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                SET
                order_id=".$order_id_present."
                WHERE
                ev_id=".$inode_id_before."
                
                ";
                
                $inicrond_db->Execute($query);
                
	}
        
        
        
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir("view_evaluations_with_a_group.php?group_id=$group_id");
        
}
?>


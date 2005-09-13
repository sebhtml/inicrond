<?php
//$Id$
error_reporting(E_ALL^E_NOTICE);


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

//
//---------------------------------------------------------------------
*/
define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');

include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if($_RUN_TIME['debug_mode'])
{
        echo "\$_RUN_TIME[\"usr_id\"]=".$_SESSION['usr_id']."<br />";
        echo "\$_RUN_TIME[\"session_id\"]=".$_SESSION['session_id']."<br />";
}
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";//transfer IDs
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/chapitre_media_id_2_inode_id.php";//transfer IDs
if(isset($_SESSION['usr_id']) && //session
isset($_GET['chapitre_media_id']) && //demande quelque chose ??
$_GET['chapitre_media_id'] != "" && //pas de chaine vide
(int) $_GET['chapitre_media_id'] AND //changement de type : integer AND
//verify here...
is_in_inode_group($_SESSION['usr_id'], chapitre_media_id_2_inode_id($_GET['chapitre_media_id']))
)
{
        
        $_SESSION['chapitre_media_id'] = $_GET['chapitre_media_id'];
        
        
        $inicrond_mktime = inicrond_mktime();
        include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";
	$HEXA_TAG = hex_gen_32();//hexadecimal string
	
	$_SESSION["secure_str"] = $HEXA_TAG;//for security reaosns.
	
	$_SESSION['chapitre_media_id'] = $_GET['chapitre_media_id'] ;//store it for later...
	//die($_SESSION['session_id']);
        
        $query = "INSERT INTO ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
        (
        usr_id,
        session_id,
        chapitre_media_id,
        time_stamp_start,
        time_stamp_end,
        secure_str
        )
        VALUES
        (
        ".$_SESSION['usr_id'].",
        ".$_SESSION['session_id'].",
        ".$_GET['chapitre_media_id'].",
        ".$inicrond_mktime.",
        ".$inicrond_mktime.",
        '$HEXA_TAG'
        );";
        $inicrond_db->Execute($query);
        
        $score_id = $inicrond_db->Insert_ID();//for later
        $_SESSION['score_id'] = $score_id;
        
        //
        //VARIABLES DE SESSIONS
        //
        //stocker score_id dans la base de data.
        /*$query = "
        SELECT
        php_session_id
        FROM
        ".
        $_OPTIONS['table_prefix'].$_OPTIONS['tables']["courses_sess_vars"]."
        WHERE
        
        php_session_id='".session_id()."'
        ";
        
	
	
	if(!isset($f["php_session_id"]))
	{
                $query = "
                INSERT INTO
                ".
                $_OPTIONS['table_prefix'].$_OPTIONS['tables']["courses_sess_vars"]."
                (php_session_id)
                VALUES
                ('".session_id()."')
                ";
                
                $inicrond_db->Execute($query);
	}
	
	$query = "
	UPDATE
	".
	$_OPTIONS['table_prefix'].$_OPTIONS['tables']["courses_sess_vars"]."
	SET
	score_id=".$score_id."
	WHERE
	php_session_id='".session_id()."'
	";
	
	$inicrond_db->Execute($query);*/
	
        
        
        if(isset($_GET["question_ordering_id"]) AND
        $_GET["question_ordering_id"] != "" AND
        (int) $_GET["question_ordering_id"]
        )//it yes, put it in a session into mysql...
        {
                
                /*	$query = "
                UPDATE
                ".
                $_OPTIONS['table_prefix'].$_OPTIONS['tables']["courses_sess_vars"]."
                SET
                question_ordering_id=".$_GET["question_ordering_id"]."
                WHERE
                php_session_id='".session_id()."'
                ";
                
                $inicrond_db->Execute($query);*/
                $_SESSION["question_ordering_id"] = $_GET["question_ordering_id"];	
                
        }
        /*
        $query = "
	UPDATE
	".
	$_OPTIONS['table_prefix'].$_OPTIONS['tables']["courses_sess_vars"]."
	SET
	chapitre_media_id=".$_GET['chapitre_media_id']."
	WHERE
	php_session_id='".session_id()."'
	";
	
	$inicrond_db->Execute($query);
	*/
	$_SESSION['chapitre_media_id'] = $_GET['chapitre_media_id'];	
        
        
        if($_OPTIONS['smarty_cache_config']['course_media']["flash.tpl"])// != 0
        {
                $smarty->caching = 1;
                $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['course_media']["flash.tpl"];
        }
        $cache_id = md5($_SESSION['language'].$_GET['chapitre_media_id']) ;
        if(!$smarty->is_cached($_OPTIONS['theme']."/flash.tpl", $cache_id))
        {
                $query = "SELECT
                
                chapitre_media_title
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
                WHERE
                chapitre_media_id=".$_GET['chapitre_media_id']."
                
                ";
                
                
                $rs = $inicrond_db->Execute($query);
                $f = $rs->FetchRow();
                
                
                
                
                
                
                $smarty->assign('chapitre_media_title', $f['chapitre_media_title']);
                $smarty->assign('chapitre_media_id', $_GET['chapitre_media_id']);
                
                $module_title = $f['chapitre_media_title'] ;
                
                
                
                
                include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";
                
                $smarty->display($_OPTIONS['theme']."/flash.tpl", $cache_id);
                
                $smarty->caching = 0;
        }
        else
        {
                echo "acces denied (1)";
        }
        
}
else
{
        echo "acces denied (2)";
}


?>


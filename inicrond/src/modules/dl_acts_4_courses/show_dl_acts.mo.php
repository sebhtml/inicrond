<?php
//$Id$


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
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

$is_in_charge_of_user=is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']) ;
$is_in_charge_of_group=is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']);

if(isset($_GET['session_id']) AND
$_GET['session_id'] != "" AND
(int) $_GET['session_id'] 
)
{
 include __INICROND_INCLUDE_PATH__."includes/functions/is_author_of_session_id.php";//session function
 include __INICROND_INCLUDE_PATH__."modules/seSSi/includes/functions/conversion.inc.php";//session function

}
if(isset($_GET['file_id']) AND
$_GET['file_id'] != "" AND
(int) $_GET['file_id'] 
)
{
        include __INICROND_INCLUDE_PATH__."modules/files_4_courses/includes/functions/conversion.function.php";//transfer IDs
}



$SELECT_WHAT = "SELECT
cours_name,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id,

".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id,
act_id,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id,
usr_name,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id,
file_name,
gmt_ts,
usr_nom,
usr_prenom

";

$FROM_WHAT = "
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].",

".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."";


$WHERE_CLAUSE = "
WHERE

".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".session_id


AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".session_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id

AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id

";


$base = __INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/show_dl_acts.mo.php?";
$it_is_ok = FALSE;

if(isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
!isset($_GET['join']) AND

$is_in_charge_of_user

)
{
	
        if(isset($_GET['cours_id']) AND
        $_GET['cours_id'] != "" AND
        (int) $_GET['cours_id']
        )
        {
                $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".cours_id=".$_GET['cours_id'];
                
        }
	$it_is_ok = TRUE;
	
	$WHERE_CLAUSE  .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_GET['usr_id'];
	$base .= "&usr_id=".$_GET['usr_id'];
	
	$sql2 = "SELECT 
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
	
	
	
	
        
	$module_title =  $_LANG['dl_acts_4_courses'];
	
	$base .= "&usr_id=".$_GET['usr_id'];
	
	//list all the file that the usr downloaded.
	$query = "SELECT
	DISTINCT
	
	file_name,
	
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id AS file_id
	FROM
	
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
        
	WHERE
	
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id=".$_GET['usr_id']."
	AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id
        
	";
        
        if(isset($_GET['cours_id']) AND
        $_GET['cours_id'] != "" AND
        (int) $_GET['cours_id']
        )
        {
                $query .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".cours_id=".$_GET['cours_id'];
                
        }	
	$tableX = array(array($_LANG['file_name']));
	//$already_there = array();
	
	$rs = $inicrond_db->Execute($query);
	while($f = $rs->FetchRow())
	{
		//if(!isset($already_there[$f['file_id']]))
		//{
                        $tableX []= array(retournerHref("../../modules/dl_acts_4_courses/show_dl_acts.mo.php?usr_id=".$_GET['usr_id']."&file_id=".$f['file_id']."&join",
                        $f['file_name']));
                        
                        //$already_there[$f['file_id']] = $f['file_id'] ;//don't put it again later..
		//}
	}
	//PASTE HERE DUDE.
	$module_content .= retournerTableauXY($tableX);
	//end of file listing...
	
	
}//end for user

elseif(isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND
!isset($_GET['join']) AND

$is_in_charge_of_group
)
{
        $it_is_ok = TRUE;
        
	$FROM_WHAT .= ",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        ";
        
	$query = "SELECT 
        group_name
        
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	
	WHERE
	group_id=".$_GET['group_id']."
	
	
	";
	
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
	
        
        $module_title =  $_LANG['dl_acts_4_courses'];
	
	$WHERE_CLAUSE .= " AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
        ";
        $base .= "&group_id=".$_GET['group_id'];
        
        //here a list all the file that this group have downloaded.
        {			
                //
                
                //
                $query = "SELECT
                
                
                file_name,
                
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id AS file_id
                FROM
                
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".file_id
                GROUP BY file_id
                ";
                
                
                $tableX = array(array($_LANG['file_name']));
                //$already_there = array();
                
                $rs = $inicrond_db->Execute($query);
                while($f = $rs->FetchRow())
                {
                        //if(!isset($already_there[$f['file_id']]))
                        //{
                                $tableX []= array(retournerHref("../../modules/dl_acts_4_courses/show_dl_acts.mo.php?group_id=".$_GET['group_id']."&file_id=".$f['file_id']."&join",
                                $f['file_name']));
                                
                                //$already_there[$f['file_id']] = $f['file_id'] ;//don't put it again later..
                        //}
                }
                
                
                $module_content .= retournerTableauXY($tableX);
                
                //
                // END OF : Marks by flash and by chapitre_media at the same time...
                //
        }
        //end of file listing.
}//end for group


elseif(isset($_GET['session_id']) AND
$_GET['session_id'] != "" AND
(int) $_GET['session_id'] AND
(
is_author_of_session_id($_SESSION['usr_id'], $_GET['session_id'])
OR
is_in_charge_of_user($_SESSION['usr_id'], session_id_to_usr($_GET['session_id']))

)

)

{
        $it_is_ok = TRUE;
	$query = "SELECT 
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
        
        $module_title =  $_LANG['dl_acts_4_courses'];
        
        $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading'].".session_id=".$_GET['session_id']." 
	";
	$base .= "&session_id=".$_GET['session_id'];
}//end for session

elseif(isset($_GET['file_id']) AND
$_GET['file_id'] != "" AND
(int) $_GET['file_id'] AND
(
is_teacher_of_cours($_SESSION['usr_id'], file_2_cours($_GET['file_id']))
OR
(
isset($_GET['usr_id']) AND
$is_in_charge_of_user
)
)

)

{
	$it_is_ok = TRUE;
	
        include "includes/kernel/dl_acts_with_a_file.php";
        
}//end for file
if(!$it_is_ok)
{
        exit();
}



$fields = array(
'usr_nom' => array(
"col_title" => $_LANG['usr_nom'],
"col_data" => "\$unit =  \$f['usr_nom'];"
)
,

'usr_prenom' => array(
"col_title" => $_LANG['usr_prenom'],
"col_data" => "\$unit = \$f['usr_prenom'];"
)
,
'usr_name' => array(
"col_title" => $_LANG['usr_name'],
"col_data" => "\$unit = retournerHref(\"../../modules/members/one.php?usr_id=\".\$f['usr_id'], \$f['usr_name']);"
)
,

'session_id' => array(
"col_title" => $_LANG['sess_id'],
"col_data" => "

\$unit =  \"<a href=\\\"../../modules/seSSi/one_session_page_views.php?session_id=\".\$f[\"session_id\"].\"\\\">\".
\$f[\"session_id\"].\"</a>\";"
),

'file_name' => array(
"col_title" => $_LANG['file'],
"col_data" => "

\$unit =  \"<a href=\\\"../../modules/files_4_courses/download.php?file_id=\".\$f[\"file_id\"].\"\\\">\".\$f[\"file_name\"].\"</a>\";"
),
"gmt_ts" => array(
"col_title" => $_LANG['date'],
"col_data" => "\$unit = format_time_stamp(\$f['gmt_ts']);"
)
,

'cours_name' => array(
"col_title" => $_LANG['courses'],
"col_data" => "\$unit  =  \"<a href=\\\"../../modules/courses/chapters.php?cours_id=\".\$f['cours_id'].\"\\\">\".\$f['cours_name'].\"</a>\";"
)



);
/*

your_points DOUBLE UNSIGNED,

max_points INT UNSIGNED

*/


$query = $SELECT_WHAT.$FROM_WHAT.$WHERE_CLAUSE;
include __INICROND_INCLUDE_PATH__."includes/class/Table_columnS.class.php";
$mon_tableau = new Table_columnS;
$mon_tableau->sql_base=($query);//la requete de base
$mon_tableau->inicrond_db=&$inicrond_db;//ok
$mon_tableau->base_url=($base);//ok
$mon_tableau->cols=($fields);//ok
$mon_tableau->_LANG=($_LANG);//ok
$mon_tableau->per_page=$_OPTIONS['results_per_page'];


$module_content .= $mon_tableau->OUTPUT();

//$module_content .= nl2br($sql);



include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
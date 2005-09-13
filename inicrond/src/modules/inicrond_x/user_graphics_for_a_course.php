<?php
/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/
define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
if(
isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id']) 

/*AND//is in charge of user??????

isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND
// is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id'] )//is in charge in course ??????*/
)
{
        
        $module_title = $_LANG['user_graphics_for_a_course'];
        
        
        /////////////////////////////////
        //select the usrname, usr id, usr prenom, usr nom, 
        $query = "SELECT
        usr_id,
        usr_name,
        usr_nom,
        usr_prenom
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE 
        usr_id=".$_GET['usr_id']."";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $module_content .= $_LANG['usr_id']." : ".$fetch_result['usr_id']."<br />";
        $module_content .= $_LANG['usr_name']." : ".$fetch_result['usr_name']."<br />";
        
        $module_content .= $_LANG['usr_prenom']." : ".$fetch_result['usr_prenom']."<br />";
	$module_content .= $_LANG['usr_nom']." : ".$fetch_result['usr_nom']."<br />";
        
        //select cours id, cours code, cours name.
        $query = "SELECT
        cours_id,
        cours_name,
        cours_code
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE 
        cours_id=".$_GET['cours_id']."";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $module_content .= $_LANG['cours_id']." : ".$fetch_result['cours_id']."<br />";
        $module_content .= $_LANG['cours_name']." : ".$fetch_result['cours_name']."<br />";
        
        $module_content .= $_LANG['cours_code']." : ".$fetch_result['cours_code']."<br />";
        
        
        
        
        /////////////////////////////////////////////////////////
        //Sessions.
        
        //link to the sessions of this user.
        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/one.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><h2>".$_LANG['visits']."</h2></a><br /><br />";
        
        //image of visits...
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/sessions_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //image of time length of vvisits.
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/seSSi/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        /////////////////////////////////////////////////////////
        //Flash results.
        
        //link to brute results.
        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/marks/main.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><h2>".$_LANG['marks']."</h2></a><br /><br />";
        
        ////////////////
        //correlation
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/time_vs_score_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        
        //marks
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //length
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //attempts
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/marks/attempts_graphic.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        /////////////////////////////////////////////////////////
        //Tests results.
        
        //link to brute results.
        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><h2>".$_LANG['tests-results']."</h2></a><br /><br />";
        
        //correlation
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/correl_time_vs_score.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //marks
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //length
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //attempts
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/attempts_graphic.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //////////////////////////////////
        //Forums stuff
        
        $module_content .= "<h2>".$_LANG['mod_forum']."</h2>";
        //lthreads views
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/threads_views.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        //posts.
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/posts_graphic.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        ///////////////////////
        //File downloads.
        //link to the sessions of this user.
        $module_content .= "<a href=\"".__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/show_dl_acts.mo.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><h2>".$_LANG['dl_acts_4_courses']."</h2></a><br /><br />";
        
        $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/dl_acts_4_courses/downloads_graphic.php?usr_id=".$_GET['usr_id']."&cours_id=".$_GET['cours_id']."\"><br /><br />";
        
        
        
}

include "../../includes/kernel/post_modulation.php";
?>
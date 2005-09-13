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
define("__INICROND_INCLUDED__", TRUE);//security
define("__INICROND_INCLUDE_PATH__", "../../");//path
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";//init inicrond kernel
include "includes/languages/".$_SESSION["language"]."/lang.php";//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.

$module_title = $_LANG['remove'];
$module_content = "";

//INSERT CODE HERE.
$granted_questions = array();
$granted_answers = array();
$granted_short_answers = array();


include 'includes/functions/check_question_granted.php';
include 'includes/functions/check_answer_granted.php';
include 'includes/functions/check_short_answer_granted.php';




if(check_question_granted($_SESSION['usr_id'], $_GET["question_id"]))
{
        //get the cours_id.
        $query = "SELECT 
        cours_id
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']." 
        
        WHERE
        question_id=".$_GET['question_id']."
        
        ";
        
        
        
	$rs = $inicrond_db->Execute($query);
	$fetch_result = $rs->FetchRow();
	
	$cours_id = $fetch_result['cours_id'];
	
        include 'includes/functions/drop_question.php';
        
        
        drop_question( $_GET["question_id"]);
        
        
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection		
        
        js_redir(__INICROND_INCLUDE_PATH__."modules/course_admin/list_questions.php?cours_id=$cours_id");
        
        
        
}//end of check if can edit the question...

include "".__INICROND_INCLUDE_PATH__."includes/kernel/post_modulation.php";
?>

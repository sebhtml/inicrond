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

if(__INICROND_INCLUDED__ AND
isset($_GET['test_id']))
{
        
        
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
	foreach($_POST AS $key => $value)//pour chaque donnéess.
	{	
                
		if(preg_match("/answer_ordering_id=(.+)/", $key, $tokens))
		//les answer_id
		{
                        
                        $query = "SELECT
                        usr_id
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering'].",
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
                        
                        WHERE 
                        answer_ordering_id=".$tokens["1"]."
                        AND
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering'].".question_ordering_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".question_ordering_id
                        AND
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".result_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".result_id
                        
                        ";
                        
                        $rs = $inicrond_db->Execute($query);
                        $fetch_result = $rs->FetchRow();
                        
                        
                        
                        if($_SESSION['usr_id'] == $fetch_result['usr_id'])
                        {
                                $query = "UPDATE 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                                SET
                                a_checked_flag='1'
                                WHERE
                                answer_ordering_id=".$tokens["1"]."
                                
                                ";
                                
                                $inicrond_db->Execute($query);	
                        }
                        
                        
		}
		elseif(preg_match("/question_ordering_id=(.+)&short_answer/", $key, $tokens))
		//les réponses courtes
		{
                        $query = "INSERT INTO
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
                        (question_ordering_id, short_answer)
                        VALUES
                        (".$tokens["1"].", \"".filter($value)."\")
                        
                        ";
                        
                        
                        $inicrond_db->Execute($query);	
                        
                        //echo $sql ;
		}
		
		
	}
	
        $query = "SELECT
        usr_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
        
        WHERE 
        result_id=".$_POST['result_id']."
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        
	if($_SESSION['usr_id'] == $fetch_result['usr_id'])
	{
                $query = "UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
                SET
                time_GMT_end=".inicrond_mktime()."
                
                WHERE
                result_id=".$_POST['result_id']."
                ";
                
                $inicrond_db->Execute($query);
	}
}
?>

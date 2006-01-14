<?php
/*
    $Id$

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
/*
Changes :

december 15, 2005
	I formated the code correctly.
	
		--sebhtml

*/

class Group_property_checkbox
{
        var $_OPTIONS;
        var $inicrond_db;
        var $_LANG;
        
        //real variables.
        var $cours_id;
        
        
        var $elm_field_name;
        
        function Execute()
        {
                
                $_OPTIONS = $this->_OPTIONS;
                $_LANG = $this->_LANG ;
                
                $module_content = "";
                
                if(isset($_POST["data_sent"]))
                {
                        //echo "update stuff";
                        //remove all groups participants.
                        
                        $query = "UPDATE 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                        SET
                        ".$this->elm_field_name." = '0'
                        WHERE
                        cours_id=".$this->cours_id."
                        ";

                        $this->inicrond_db->Execute($query);
                        
                        foreach($_POST AS $key => $value)
                        {
                                if(preg_match("/&group_id=(.+)&".$this->elm_field_name."/", $key, $tokens))
                                //les txt pour les answer.
                                {
                                        $query = "UPDATE 
                                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                                        SET
                                        ".$this->elm_field_name." = '1'
                                        WHERE
                                        group_id=".$tokens["1"]."
                                        AND
                                        cours_id=".$this->cours_id."
                                        ";
                                        
                                        $this->inicrond_db->Execute($query);
                                }
                        }
                }
                
                //get all group...
                $query = "SELECT
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id, 
		group_name,
		".$this->elm_field_name."
		FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
		WHERE
		cours_id=".$this->cours_id."
		
		";
                
                $rs = $this->inicrond_db->Execute($query);
                $module_content .= "<form method=\"POST\">";
                
                $tab = array(array($_LANG['group_name'], $_LANG['checkbox']));
                
		while($fetch_result = $rs->FetchRow())
		{
                        $checked = $fetch_result[$this->elm_field_name] ? "CHECKED" : "" ;
                        
                        $tab []= array($fetch_result['group_name'], " <input $checked type=\"checkbox\" name=\"&group_id=".$fetch_result['group_id']."&".$this->elm_field_name."\" value=\"\" />");		
		}
                
		$module_content .= retournerTableauXY($tab);
		
                $module_content .= "<input  type=\"submit\" name=\"data_sent\" /> </form>
                <h2><a href=\"course_users.php?&cours_id=".$_GET['cours_id']."\">".$_LANG['course_users']."</a></h2>";
                
                return $module_content ;
        }
}

?>
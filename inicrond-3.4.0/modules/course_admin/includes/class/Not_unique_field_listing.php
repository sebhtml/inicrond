<?php
/*
    $Id: Not_unique_field_listing.php 82 2005-12-24 21:48:25Z sebhtml $

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

class Not_unique_field_listing
{
    var $_OPTIONS;
    var $inicrond_db;
    var $field;
    var $cours_id;

    function Render ()
    {
        $module_content = '';

        ////////////select all email that are not unique. for the course.
        $query = '
        SELECT
        T1.'.$this->field.' AS NOT_UNIQUE_ENTRY
        FROM
        '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['usrs'].' AS T1, '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['usrs'].' AS T2,
        '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['groups'].',
        '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['groups_usrs'].'
        WHERE
        '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['groups'].'.cours_id = '.$this->cours_id.'
        AND
        '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['groups'].'.group_id='.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['groups_usrs'].'.group_id
        AND
        '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['groups_usrs'].'.usr_id=T2.usr_id
        AND
        T1.'.$this->field.' = T2.'.$this->field.'
        AND
        T1.usr_id!= T2.usr_id
        GROUP BY T1.'.$this->field.'
        ';

        $rs = $this->inicrond_db->Execute ($query);

        while ($fetch_result = $rs->FetchRow ())//foreach not unique email
        {
            //show the email.
            $module_content .= $fetch_result['NOT_UNIQUE_ENTRY'].'<br />';
            //list all usr_name. with usr_id...

            $query = '
            SELECT
            usr_name, usr_id
            FROM
            '.$this->_OPTIONS['table_prefix'].$this->_OPTIONS['tables']['usrs'].'
            WHERE
            '.$this->field.'=\''.$fetch_result['NOT_UNIQUE_ENTRY'].'\'
            ';

            $rs2 = $this->inicrond_db->Execute ($query);

            while ($fetch_result2 = $rs2->FetchRow ())//foreach not unique email
            {
                //list all usr_name. with usr_id...
                $module_content .= '&nbsp;&nbsp;&nbsp;<a href="'.
                __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result2['usr_id']."&cours_id=".$_GET['cours_id'].'">'.$fetch_result2['usr_name'].'</a><br />';
            }
        }

        return $module_content;
    }
}

?>
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

define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');

include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if (!isset($_SESSION['usr_id']))// you have to be loggued to see this page
{
    exit();
}

$module_title = $_LANG['courses'];
$module_content = '' ;

if ($_SESSION['SUID']) //admin can add a course
{
    $module_content .= '<br />';
    $module_content .= retournerHref ('../../modules/courses/add_edit_course.php', $_LANG['add_course']);
    $module_content .= '<br />';

    $query = '  SELECT 
	        cours_id,
                cours_name,
                cours_code
                FROM
	'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].' AS t1
	';

}
//get all the course with only one query!!!!!!!!!!.
else		//not suid
{
    $query = 'SELECT 
	DISTINCT 
	t1.cours_id AS cours_id,
        cours_name,
        cours_code
	FROM
	'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].' AS t1,
	'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].' AS t2,
	'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].' AS t3
	WHERE
	usr_id = '.$_SESSION['usr_id'].'
	AND
	t3.cours_id = t1.cours_id
	AND
	t3.group_id = t2.group_id
	AND
	(is_teacher_group = \'1\' OR is_student_group = \'1\')
	';
}

$rs = $inicrond_db->Execute ($query);

$courses = array (array ($_LANG['cours_code'], $_LANG['cours_name']));

while ($fetch_result = $rs->FetchRow ())
{
    $course = array ();

    $course['cours_code'] = $fetch_result['cours_code'];
    $course['cours_name'] =
      retournerHref (__INICROND_INCLUDE_PATH__.'modules/courses/inode.php?cours_id='.
		     $fetch_result['cours_id']."",
		     $fetch_result['cours_name']);
    
    $courses[] = $course;


}

$smarty->assign ('courses', $courses);

$module_content .=  $smarty->fetch ($_OPTIONS['theme']."/courses_splash.tpl");

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
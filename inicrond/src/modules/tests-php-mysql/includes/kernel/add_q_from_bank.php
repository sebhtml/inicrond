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

if(__INICROND_INCLUDED__)
{
    $query = "  INSERT INTO
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
    (test_id, question_id, q_order_id)
    VALUES
    (".$_GET['test_id'].", ".$_POST["question_id"].", ".$_POST["question_id"].")
    " ;

    //insert the q_link.
    $inicrond_db->Execute($query);

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

    js_redir("edit_a_test_GOLD.php?test_id=".$_GET['test_id']);
}

?>
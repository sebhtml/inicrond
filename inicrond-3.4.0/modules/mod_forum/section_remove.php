<?php
/*
    $Id: section_remove.php 85 2005-12-27 03:22:23Z sebhtml $

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

define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.

include "includes/functions/access.php";
include "includes/functions/conversion.inc.php";

if(isset($_GET["forum_section_id"]) //on demande-tu ??
&& $_GET["forum_section_id"] != "" //pas de chaine vide
&& (int) $_GET["forum_section_id"] //chagnement de type
&& can_usr_admin_section($_SESSION['usr_id'], $_GET["forum_section_id"]))//enlever une section
{
    //find if there is some forum in there...
    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
    WHERE
    forum_section_id=".$_GET["forum_section_id"]."
    ";

    $rs = $inicrond_db->Execute($query);
    $f2 = $rs->FetchRow();

    $cours_id = $f2['cours_id'];

    $query = "
    SELECT
    forum_section_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    forum_section_id=".$_GET["forum_section_id"]."
    ";

    $rs = $inicrond_db->Execute($query);
    $f = $rs->FetchRow();

    if(isset($f["forum_section_id"]))//error msg
    {
        $module_content .= $_LANG['this_section_contains_forums'];
    }
    else//delete the section
    {
        $query = "
        DELETE
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        WHERE
        forum_section_id=".$_GET["forum_section_id"]."
        ";

        $inicrond_db->Execute($query);

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

        js_redir("main_inc.php?&cours_id=$cours_id");
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
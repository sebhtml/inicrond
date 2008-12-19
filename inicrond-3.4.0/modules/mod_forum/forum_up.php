<?php
/*
    $Id: forum_up.php 88 2006-01-03 21:09:08Z sebhtml $

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

if(isset($_GET["forum_discussion_id"])  //on demande-tu ??
&& $_GET["forum_discussion_id"] != ""  //pas de chaine vide
&& (int) $_GET["forum_discussion_id"] //chagnement de type
&& can_usr_admin_section($_SESSION['usr_id'], forum_2_section($_GET["forum_discussion_id"])))//
{
    $forum_section_id = forum_2_section($_GET["forum_discussion_id"]) ;

    //------------
    //on trouve dans quelle section est la discussion demandée.
    //----------

    //echo "forum_section_id ".$forum_section_id;
    //

    //get the current order_id.

    $query = "
    SELECT
    order_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    forum_discussion_id=".$_GET["forum_discussion_id"].//celui qui est avant
    "
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $order_id_present = $fetch_result["order_id"];

    //the one just before...
    $query = "
    SELECT
    MAX(order_id)
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    order_id<".$order_id_present.//celui qui est avant
    "
    AND
    forum_section_id=".$forum_section_id."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $order_id_avant = $fetch_result["MAX(order_id)"];

    if(isset($fetch_result["MAX(order_id)"]))//est-ce qu'il y a quelque chose avant.
    {
        //on va chercher la discussion avant.
        $query = "
        SELECT
        forum_discussion_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
        WHERE
        order_id=".$order_id_avant.//celui qui est avant
        "
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $forum_discussion_id_avant = $fetch_result["forum_discussion_id"];

        //on met le order id avant �celui pr�ent.

        $query =
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
        SET
        order_id=".$order_id_avant."
        WHERE
        forum_discussion_id=".$_GET["forum_discussion_id"].//celui qui est avant
        "
        ";

        $inicrond_db->Execute($query);

        $query = //celui qui est en haut descend
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
        SET
        order_id=".$order_id_present."
        WHERE
        forum_discussion_id=".$forum_discussion_id_avant."
        ";

        $inicrond_db->Execute($query);
    }

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id,
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
    WHERE
    forum_discussion_id=".$_GET["forum_discussion_id"].
    "
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $cours_id = $fetch_result['cours_id'];

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
    js_redir("main_inc.php?&cours_id=$cours_id");
}

?>
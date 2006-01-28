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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include "includes/functions/access.php";
include "includes/functions/conversion.inc.php";

/*
0 : new
1 : edit
*/

if($_GET["mode_id"] == 0 && isset($_GET["forum_section_id"]) && $_GET["forum_section_id"] != ""
&& (int) $_GET["forum_section_id"] && can_usr_admin_section($_SESSION['usr_id'], ($_GET["forum_section_id"])))
{
    //-------------------
    // ajouter une discussion
    //--------------------

    $forum_section_id = $_GET["forum_section_id"];

    $query = "
    SELECT count(forum_section_id)
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
    WHERE
    forum_section_id=$forum_section_id";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if($fetch_result["count(forum_section_id)"] == 1)//est-ce que la section existe ?
    {
        $query = "
        SELECT
        forum_section_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        WHERE
        forum_section_id=".$_GET["forum_section_id"]."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        //-----------------------
        // titre
        //---------------------

        $module_title =$_LANG['add'];

        if(!isset($_POST["envoi"]))
        {
            $forum_discussion_name = "";

            include "includes/forms/forum_inc.form.php";
        }
        else
        {
            include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

            $forum_discussion_name = filter($_POST["forum_discussion_name"]);
            $forum_discussion_description = filter($_POST["forum_discussion_description"]);

            $query = "
            INSERT INTO ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
            (
            forum_discussion_name,
            forum_discussion_description,
            forum_section_id,
            order_id
            )
            VALUES
            (
            '$forum_discussion_name',
            '$forum_discussion_description',
            $forum_section_id,
            0
            )
            ";

            $inicrond_db->Execute($query);

            $order_id = $inicrond_db->Insert_ID();//le numéro de la discussion

            //---------------
            //met à jour le order by
            //-------------

            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
            SET
            order_id=$order_id
            WHERE
            forum_discussion_id=$order_id
            ";

            $inicrond_db->Execute($query);

            $query = "
            SELECT
            cours_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id=  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id
            AND
            forum_discussion_id=$order_id
            ";

            $rs = $inicrond_db->Execute($query);
            $fetch_result = $rs->FetchRow();

            include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
            js_redir("main_inc.php?&cours_id=".$fetch_result['cours_id']);
        }
    }
}
elseif($_GET["mode_id"] == 1 && isset($_GET["forum_discussion_id"]) && $_GET["forum_discussion_id"] != ""
&& (int) $_GET["forum_discussion_id"]
&& can_usr_admin_section($_SESSION['usr_id'], forum_2_section($_GET["forum_discussion_id"])))
{
    //editer une discussion

    $query = "
    SELECT
    forum_section_name,
    forum_discussion_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']." ,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    forum_discussion_id=".$_GET["forum_discussion_id"]."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']." .forum_section_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    //-----------------------
    // titre
    //---------------------

    $module_title = $fetch_result["forum_discussion_name"];


    //--------------
    // existe-il ??
    //-------------

    $forum_discussion_id = $_GET["forum_discussion_id"];

    $query = "
    SELECT
    forum_discussion_name,
    forum_discussion_description,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id AS forum_section_id,
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id =
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
    AND
    forum_discussion_id=".$_GET["forum_discussion_id"]."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $cours_id = $fetch_result['cours_id'];

    if(!isset($_POST["envoi"]))
    {
        $forum_discussion_name = $fetch_result["forum_discussion_name"];
        $forum_discussion_description = $fetch_result["forum_discussion_description"];

        include "includes/forms/forum_inc.form.php";
    }
    else // on apporte les chagements
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $forum_discussion_name = filter($_POST["forum_discussion_name"]);
        $forum_discussion_description = filter($_POST["forum_discussion_description"]);

        if(can_usr_admin_section($_SESSION['usr_id'], ($_POST["forum_section_id"])))
        {
            $query = "
            UPDATE ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
            SET
            forum_discussion_name='$forum_discussion_name',
            forum_discussion_description='$forum_discussion_description'
            WHERE
            forum_discussion_id=$forum_discussion_id
            ";

            $inicrond_db->Execute($query);
        }

        $query = "
        UPDATE ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
        SET
        forum_section_id=".$_POST["forum_section_id"]."
        WHERE
        forum_discussion_id=$forum_discussion_id
        ";

        $inicrond_db->Execute($query);

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir("main_inc.php?&cours_id=$cours_id");
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
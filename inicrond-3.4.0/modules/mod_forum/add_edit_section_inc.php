<?php
/*
    $Id: add_edit_section_inc.php 85 2005-12-27 03:22:23Z sebhtml $

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

/*
    0 : new
    1 : edit
*/


if ($_GET["mode_id"] == 0 && isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id']
&& (is_teacher_of_cours($_SESSION['usr_id'],  $_GET['cours_id']) || $_SESSION['SUID']))
{
    //-------------------
    // ajouter une section dans le forum
    //--------------------

    //-----------------------
    // titre
    //---------------------

    $module_title = $_LANG['add'];

    if (!isset($_POST["envoi"]))
    {
        $forum_section_name = "";

        $fetch_result["order_id"] = "";

        include "includes/forms/section_inc.form.php";
    }
    elseif($_POST["forum_section_name"] != ""//changement de type
    )
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $forum_section_name = filter($_POST["forum_section_name"]);

        $query = "
        INSERT INTO ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        (
        forum_section_name,
        order_id,
        cours_id
        )
        VALUES
        (
        '$forum_section_name',
        "."0".",
        ".$_GET['cours_id']."
        )";

        $inicrond_db->Execute($query);

        $order_id = $inicrond_db->Insert_ID();//le numéro de la discussion

        //---------------
        //met à jour le order by
        //-------------

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        SET
        order_id=$order_id
        WHERE
        forum_section_id=$order_id
        ";

        $inicrond_db->Execute($query);

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

        js_redir("main_inc.php?&cours_id=".$_GET['cours_id']);
    }
}
//éditer
elseif($_GET["mode_id"] == 1 && isset($_GET["forum_section_id"]) && $_GET["forum_section_id"] != ""
&& (int) $_GET["forum_section_id"] && can_usr_admin_section($_SESSION['usr_id'], ($_GET["forum_section_id"])))
{
    //--------------
    // existe-il ??
    //-------------

    $forum_section_id = $_GET["forum_section_id"];

    $query = "
    SELECT
    forum_section_name,
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
    WHERE
    forum_section_id=".$_GET["forum_section_id"]."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();
    $cours_id = $fetch_result['cours_id'];

    if(isset($fetch_result["forum_section_name"]))//est-ce qu'elle existe ?
    {
        //-----------------------
        // titre
        //---------------------

        $module_title = $fetch_result["forum_section_name"];

        if(!isset($_POST["envoi"]))
        {
            $forum_section_name = $fetch_result["forum_section_name"];

            include "includes/forms/section_inc.form.php";
        }
        elseif($_POST["forum_section_name"] != "")// on apporte les chagements
        {
            include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
            $forum_section_name = filter($_POST["forum_section_name"]);

            $query = "
            UPDATE ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
            SET
            forum_section_name='$forum_section_name'
            WHERE
            forum_section_id=$forum_section_id
            ";

            $inicrond_db->Execute($query);

            //javascript redirection
            include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";

            js_redir("main_inc.php?&cours_id=$cours_id");
        }
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
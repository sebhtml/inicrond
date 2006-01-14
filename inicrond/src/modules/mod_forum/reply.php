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

include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_mail.php";

$forum_sujet_id = message2sujet($_GET["forum_message_id"]);

//peut-il replier ?
if(isset($_GET["forum_message_id"]) && $_GET["forum_message_id"] != ""
&& (int) $_GET["forum_message_id"] && peut_il_replier($_SESSION['usr_id'], $forum_sujet_id))
{
    $_GET["forum_sujet_id"] = $forum_sujet_id;

    $query = "
    SELECT
    forum_message_titre
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
    WHERE
    forum_sujet_id=".$_GET["forum_sujet_id"]."
    ORDER BY forum_message_id ASC
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $sujet_name = $fetch_result["forum_message_titre"];

    $query = "
    SELECT
    forum_discussion_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id,
    forum_message_titre,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_message_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id=".$_GET["forum_sujet_id"]."
    ORDER BY forum_message_id ASC
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    //titre
    $module_title = $_LANG['reply'];

    if(isset($_POST["sent"]) && $_POST["forum_message_titre"] != "")
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $usr_id = isset($_SESSION['usr_id']) ? $_SESSION['usr_id'] : $_OPTIONS['usr_id']['nobody'];
        $forum_message_titre = filter($_POST["forum_message_titre"]);
        $forum_message_contenu = filter_html_preserve($_POST['forum_message_contenu']);

        $forum_message_add_gmt_timestamp = inicrond_mktime();
        $forum_message_edit_gmt_timestamp = inicrond_mktime();

        $query = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
        (
        usr_id,
        forum_message_titre,
        forum_message_contenu,
        forum_message_add_gmt_timestamp,
        forum_message_edit_gmt_timestamp,
        forum_sujet_id,
        forum_message_id_reply_to
        )
        VALUES
        (
        $usr_id,
        '$forum_message_titre',
        '$forum_message_contenu',
        $forum_message_add_gmt_timestamp,
        $forum_message_edit_gmt_timestamp,
        $forum_sujet_id,
        ".$_GET["forum_message_id"]."
        )
        ";

        $inicrond_db->Execute($query);

        // forum_subscription

        $query = '
        select
        usr_email
        from
        '.$_OPTIONS['table_prefix'].'usrs,
        '.$_OPTIONS['table_prefix'].'thread_subscription
        where
        forum_sujet_id = '.$forum_sujet_id.'
        and
        '.$_OPTIONS['table_prefix'].'thread_subscription.usr_id = '.$_OPTIONS['table_prefix'].'usrs.usr_id
        ' ;

        $rs = $inicrond_db->Execute ($query);

        while($fetch_result = $rs->FetchRow())
        {
            $mail = $fetch_result['usr_email'];

            $object = $forum_message_titre;

            $body = $forum_message_contenu."<br />".$_RUN_TIME['usr_signature'];

            inicrond_mail($mail, $object, $body);
        }

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

        js_redir("thread_inc.php?forum_sujet_id=".$_GET["forum_sujet_id"]);
    }
    else//le formulaire
    {
        include "includes/forms/postit_inc.form.php";
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
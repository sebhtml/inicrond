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

//start thread
if(isset($_GET["forum_discussion_id"]) && $_GET["forum_discussion_id"] != ""
&& (int) $_GET["forum_discussion_id"]
&& can_usr_start_thread($_SESSION['usr_id'], $_GET["forum_discussion_id"]))//in a group
{
    include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_mail.php";

    $forum_discussion_id = $_GET["forum_discussion_id"];

    $query = "
    SELECT
    forum_discussion_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    forum_discussion_id=$forum_discussion_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if(isset($fetch_result["forum_discussion_id"])) //est ce que le massage existe ?
    {
        $query = "
        SELECT
        forum_discussion_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
        WHERE
        forum_discussion_id=".$_GET["forum_discussion_id"]."";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        //titre
        $module_title = $_LANG['start'];

        if(isset($_POST["sent"]) && $_POST["forum_message_titre"] != ""
        && $_POST['forum_message_contenu'] != "")
        {
            $query = "
            INSERT INTO ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
            (forum_discussion_id)
            VALUES
            ($forum_discussion_id)
            ";

            $inicrond_db->Execute($query);

            $forum_sujet_id = $inicrond_db->Insert_ID();

            include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

            $forum_message_titre = filter($_POST["forum_message_titre"]);

            $forum_message_contenu = filter_html_preserve($_POST['forum_message_contenu']);

            $forum_message_edit_gmt_timestamp = inicrond_mktime();
            $forum_message_add_gmt_timestamp = $forum_message_edit_gmt_timestamp;

            $usr_id = isset($_SESSION['usr_id']) ? $_SESSION['usr_id'] : $_OPTIONS['usr_id']['nobody'];

            $query = "
            INSERT INTO ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
            (
            usr_id,
            forum_message_titre,
            forum_message_contenu,
            forum_message_add_gmt_timestamp,
            forum_message_edit_gmt_timestamp,
            forum_sujet_id
            )
            VALUES
            (
            $usr_id,
            '$forum_message_titre',
            '$forum_message_contenu',
            $forum_message_add_gmt_timestamp,
            $forum_message_edit_gmt_timestamp,
            $forum_sujet_id
            )
            ";

            $inicrond_db->Execute($query);

            if(isset($_POST["send_email"]) //do we send emails???
            && is_teacher_of_forum($_SESSION['usr_id'], $_GET["forum_discussion_id"]))
            {
                foreach($_POST AS $key=>$value)
                {
                    if(preg_match("/&group_id=(.+)&/", $key, $tokens))//les txt pour questions
                    {
                        $group_id = $tokens["1"] ;

                        $query = "
                        SELECT
                        usr_email
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                        WHERE
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=$group_id
                        AND
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
                        ";

                        $rs = $inicrond_db->Execute ($query);

                        while($fetch_result = $rs->FetchRow())
                        {
                            $mail = $fetch_result['usr_email'];

                            $object = filter($_POST["forum_message_titre"]);

                            $body = filter(strip_tags($_POST['forum_message_contenu']))."<br />".$_RUN_TIME['usr_signature'];

                            inicrond_mail($mail, $object, $body);
                        }
                    }//end of if
                }//end for foreach
            }

            // forum_subscription

            $query = '
            select
            usr_email
            from
            '.$_OPTIONS['table_prefix'].'usrs,
            '.$_OPTIONS['table_prefix'].'forum_subscription
            where
            forum_discussion_id = '.$_GET["forum_discussion_id"].'
            and
            '.$_OPTIONS['table_prefix'].'forum_subscription.usr_id = '.$_OPTIONS['table_prefix'].'usrs.usr_id
            ' ;

            $rs = $inicrond_db->Execute ($query);

            while($fetch_result = $rs->FetchRow())
            {
                $mail = $fetch_result['usr_email'];

                $object = filter($_POST["forum_message_titre"]);

                $body = filter(strip_tags($_POST['forum_message_contenu']))."<br />".$_RUN_TIME['usr_signature'];

                inicrond_mail($mail, $object, $body);
            }

            include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

            js_redir("forum_inc.php?&forum_discussion_id=". $_GET["forum_discussion_id"]    );
        }
        else//le formulaire pour starter un thread
        {
            include "includes/forms/postit_inc.form.php";
        }
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>


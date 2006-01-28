{*
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005, 2006  Sébastien Boisvert

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

*}

{smarty_array_to_html_function php_array=$course_infos}

{$date_of_last_visit}


{section name=section_number loop=$section}

    <!--{$section[section_number].forum_section_id}-->
    <h2>{$section[section_number].forum_section_name}</h2><br />
    <small>{$section[section_number].forum_section_description}</small><br />

    {section name=forum_number loop=$section[section_number].forum}

        <!--{$section[section_number].forum[forum_number].forum_discussion_id}-->
        <h3>{$section[section_number].forum[forum_number].forum_discussion_name}</h3><br />

        {*
            Add a link to the usr
            Add a link to the post
        *}

        {section name=post_number loop=$section[section_number].forum[forum_number].post}

            <i>{$section[section_number].forum[forum_number].post[post_number].forum_message_add_gmt_timestamp}</i>
            :
            <a href="{$__INICROND_INCLUDE_PATH__}modules/mod_forum/thread_inc.php?forum_sujet_id={$section[section_number].forum[forum_number].post[post_number].forum_sujet_id}#{$section[section_number].forum[forum_number].post[post_number].forum_message_id}"><b>{$section[section_number].forum[forum_number].post[post_number].forum_message_titre}</b></a>

            {$_LANG.by}
            {$section[section_number].forum[forum_number].post[post_number].usr_prenom}
            {$section[section_number].forum[forum_number].post[post_number].usr_nom}
            (<a href="{$__INICROND_INCLUDE_PATH__}modules/members/one.php?usr_id={$section[section_number].forum[forum_number].post[post_number].usr_id}">{$section[section_number].forum[forum_number].post[post_number].usr_name}</a>)

            <br />
            <!--{$section[section_number].forum[forum_number].post[post_number].forum_message_contenu}-->

        {/section}

    {/section}

{/section}

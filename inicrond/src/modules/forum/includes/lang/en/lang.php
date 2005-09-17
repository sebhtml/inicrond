<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : fichier fr
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : inicrond
//
//---------------------------------------------------------------------
*/

/*


http://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.


*/
if(isset($_OPTIONS["INCLUDED"]))
{




$_LANG["33"] = array(
"ajouter" => "Add a moderator",
"enlever" => "Remove a moderator",
"titre" => "Moderators"

);
$_LANG["23"] = array(
"titre" => "Forums",

"discussion" => "Forum",
"description" => "Description",
"nb_messages" => "Posts",
"nb_sujets" => "Threads",
"last_post" => "Last post",

"removed_section" => "The section has been removed",
"not_removed_section" => "The section cannot be removed : there is remaining forum.",
"remove" => $_LANG["common"]["remove"],
"discussion_deleted" => "The forum has been removed",
"where" => "You must change the threads of discussion",
"rm_discussion" =>  $_LANG["common"]["remove"],

"go_up" => "Up",
"go_down" => "Down",

"removed_forum" => "The forum has been removed",
"not_removed_forum" => "The forum contains thread(s)",

"cbparser_info" => " (<a href=\"docs/repository/BBcode.txt\" target=\"blank\">BBcode</a>)",
"droits" => "Rights"
);

$_LANG["24"] = array(
"sujet" => "Thread",
"starter" => "Starter",
"nb_answer" => "Replies",
"nb_views" => "Hits",
"closed" => "Closed",
"open" => "Open",
"status" => "Status"
);

$_LANG["25"] = array(
"changer_de_discussion" => "Change this thread of forum",
"close_open" => "Close/open"
);

$_LANG["26"] = array(
"titre" => "Reply",

"forum_message_titre" => "Title",
"forum_message_contenu" => "Body",
"start" => "Start"
);

$_LANG["27"] = array(
"add" => "Add a section",
"forum_section_name" => "Title",
"edit" => $_LANG["common"]["edit"],
//"order_id" => "Ordre"
);

$_LANG["28"] = array(
"edit" => $_LANG["common"]["edit"],
"add" => "Add a forum",
"right_thread_start" => "Start",
"right_thread_reply" => "Reply",
"all" => "All",
"author" => "Author"
);

$_LANG["28"]["curve"] = "Views versus time";
}

?>

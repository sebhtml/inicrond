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

//-----------------------
// titre
//---------------------

$module_title =   $_LANG['disconnect'];

//v�ifie si il y a une session valide
if (isset($_SESSION['usr_id']))
{
    $query = "
    UPDATE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
    SET
    is_online='0'
    WHERE
    session_id=".$_SESSION['session_id']."
    AND
    is_online='1'
    ";

    $inicrond_db->Execute($query);

    $_SESSION = NULL ; //destroy the session.

    session_destroy(); // kill -9 session (lol)

    /*
        This is a Unix joke..
    */

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
    js_redir($_OPTIONS["log_out_redirection"]);
}
else
{
    //affiche la déconnexion
    $module_content .=  $_LANG['deconnected'];
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
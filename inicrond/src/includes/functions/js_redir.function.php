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
/*
Changes :

december 15, 2005
        I formated the code correctly.

                --sebhtml

*/

if(!__INICROND_INCLUDED__)
{
        die();
}

/**
 * Use smarty to redirect a url.
 *
 * @param        string  $url     the url to redirect to
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function  js_redir($url, $redir_body_msg = '')
{
        global $_OPTIONS, $smarty, $_LANG;

        header("Location: $url");//with http headers.

        $smarty->template_dir = __INICROND_INCLUDE_PATH__.'templates/';

        $smarty->assign('redir_body_msg', $redir_body_msg);
        $smarty->assign('redir_url', $url);
        $smarty->assign('redir_msg', $_LANG['redir_msg']);
        $smarty->assign('redir_here', $_LANG['redir_here']);

        echo $smarty->fetch($_OPTIONS['theme'].'/js_redir.tpl');
        exit();
}


?>

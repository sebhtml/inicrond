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


if(!__INICROND_INCLUDED__)
{
    die("hacking attempt!!");
}


/**
* delete a chapter media
*
* @param        integer  $chapitre_media_id    id of a chapter media
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function delete_chapitre_media($chapitre_media_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    HEXA_TAG
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
    WHERE
    chapitre_media_id=".$chapitre_media_id."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    include "includes/etc/files.php";
    $file_path = $_OPTIONS["file_path"]["courses_mod_upload_dir"]."/".$fetch_result["HEXA_TAG"] ;

    if(is_file($file_path))
    {
        unlink($file_path);
    }

    //supprime le média
    $query = "
    DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
    WHERE
    chapitre_media_id=$chapitre_media_id
    ";

    $inicrond_db->Execute($query);

    return TRUE;//pas d'erreur
}

?>
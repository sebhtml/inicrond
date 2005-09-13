<?php
//$Id$


if(!__INICROND_INCLUDED__)
{
        die("hacking attempt!!");
}
/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/


/**
* transfor a chapter media id in a cours id
*
* @param        integer  $chapitre_media_id     id of a chapter media
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/	
function chapitre_media_to_cours($chapitre_media_id)
{
        global $_OPTIONS, $inicrond_db;
	
        
        $query = "
        SELECT 
        cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
        WHERE
        chapitre_media_id=$chapitre_media_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        return $fetch_result['cours_id'];
        
        
}


/**
* transfor a inode id in a course id
*
* @param        integer  $inode_id     id of an inode
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/	
function inode_to_course($inode_id)
{
        
        global $_OPTIONS, $_RUN_TIME, $inicrond_db;
        $query = "SELECT
	cours_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
	WHERE
	inode_id=".$inode_id."
	";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
  	
	return $fetch_result['cours_id'];
	
}


?>
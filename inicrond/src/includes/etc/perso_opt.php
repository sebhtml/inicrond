<?php
//$Id$

//-----------------------------------
//Config file...
//---------------------------

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
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

if(isset($_OPTIONS["INCLUDED"]))
{
  

 //--------------------------
//inclusion pour connexion
//----------------------------



$sql = 
"SELECT 
titre,
separator,
news_forum_discussion_id,
 usr_time_decal, 
 language,
preg_email, 
preg_usr, 
preg_agent,
header_txt,
footer_txt
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_options"]."
";

  
  $query_result = $mon_objet->query($sql);

    
$fetch_result = $mon_objet->fetch_assoc($query_result);
  $mon_objet->free_result($query_result);


$_OPTIONS["titre"] =  $fetch_result["titre"];
$_OPTIONS["separator"] =  $fetch_result["separator"];
$_OPTIONS["preg_usr"] =   $fetch_result["preg_usr"];
$_OPTIONS["preg_email"] = $fetch_result["preg_email"];
$_OPTIONS["preg_agent"] = $fetch_result["preg_agent"];
$_OPTIONS["news_forum_discussion_id"] =  $fetch_result["news_forum_discussion_id"];
$_OPTIONS["header_txt"] = $fetch_result["header_txt"];
$_OPTIONS["footer_txt"] = $fetch_result["footer_txt"];
$_OPTIONS["usr_time_decal"] = $fetch_result["usr_time_decal"];
$_OPTIONS["language"] = $fetch_result["language"];


}

//
//les tables disponibles...
//


?>
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
  

$_OPTIONS["project_name"] = "inicrond";//version du moteur du site
$_OPTIONS["project_version"] = "2.20.3-dev";//version

$_OPTIONS["usr_id"]["nobody"] = 1 ;

$_OPTIONS["flush_visit_delta"] = 5*60;

$_OPTIONS["max_len"] = 30;


$_OPTIONS["group_admin"] = 1 ;//le groupe administrateur.

$_OPTIONS["default_module_id"] = 32 ;


}

//
//les tables disponibles...
//


?>
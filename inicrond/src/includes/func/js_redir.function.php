<?php
//$Id$

if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : traiter des tavbleau en 2D
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
/*
* $contenu .= un tableau en 2 dimensions
*/

function  js_redir($url)
{
global $_LANG;


$output =
"<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>



<!--mÃ©ta tags -->
		<META NAME=\"Author\" CONTENT=\"sebastien boisvert (oloko.cjb.net)\" />
		<META NAME=\"Description\" CONTENT=\"mon site web\" />
		<META NAME=\"Keywords\" LANG=\"fr\" CONTENT=\"sebhtml, php, MySQL\" />
		<META NAME=\"Identifier-URL\" CONTENT=\"http://membres.lycos.fr/\" />
		<META NAME=\"Date-Creation-yyyymmdd\" content=\"".gmdate("Ymd")."\" />

		<META NAME=\"Date-Revision-yyyymmdd\" content=\"".gmdate("Ymd")."\" />
		<META NAME=\"Robots\" CONTENT=\"index,follow,all\" />
		<META NAME=\"revisit-after\" CONTENT=\"30 days\" />
		<META NAME=\"Reply-to\" CONTENT=\"sebhtml@yahoo.ca\" />
		<META NAME=\"Category\" CONTENT=\"dev\" />
		<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=ISO-8859-1\" />
<style  type=\"text/css\">";
  include "includes/css_style/css_inc.php";

  $output .= "
</style>
	
  <title>


  </title>
</head>
<body>
<p align=\"center\">
<table cellspacing=\"5\" cellpadding=\"5\" bgcolor=\"#EEEEEE\">
	<tr>
		<td align=\"center\">
		".$_LANG["redir"]["msg"]."<br />
		<a href=\"$url\">".$_LANG["redir"]["here"]."</a>
		</td>
	</tr>
</table>

</p>
<SCRIPT language=\"JavaScript\"> 
<!--
 function getgoing()
  {
window.location=\"$url\";
   }
 
   
   
   setTimeout('getgoing()',1000);
     
//--> 
</SCRIPT> 
</body>
</html>

";

return $output;

}

		
?>

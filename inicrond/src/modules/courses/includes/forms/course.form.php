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


$module_content .=  "<form  method=\"POST\">
<table border =\"0\" >

<tr>
<td>".$_LANG['cours_code']."</td>
<td><input type=\"text\" name=\"cours_code\"  value=\"".
($fetch_result['cours_code'])."\" /></td>
</tr>

<tr>
<td >".$_LANG['title']."</td>
<td ><input type=\"text\" name=\"cours_name\"  value=\"".
($fetch_result['cours_name'])."\" /></td>
</tr>
<tr>
<td >".$_LANG['description']."<p align=\"justify\">".
$_LANG['BB_code_info_main']."</p></td>
<td ><textarea cols=\"40\" rows=\"15\" name=\"cours_description\">".
($fetch_result['cours_description'])."</textarea></td>
</tr>";



$module_content .= "
<tr>
<td colspan=\"2\">  <input type=\"submit\" name=\"envoi\" value=\"".$_LANG['txtBoutonForms_ok']."\" />    </td>
</tr>

</table  >
</form>" ;


?>
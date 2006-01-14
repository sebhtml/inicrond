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

$module_content .=  "<form method=\"POST\">
<table border =\"0\" >
<tbody>" ;

$module_content .=  "

<tr>
<td >".$_LANG['usr_name']."<td />
<td ><input type=\"text\" name=\"usr_name\"  value=\"\" /></td>
</tr>


<tr>
<td colspan=\"2\">  <input type=\"submit\" name=\"envoi\" value=\"".$_LANG['txtBoutonForms_ok']."\" />	  </td> 
</tr>
</tbody>
</table  >
</form>" ;

?>
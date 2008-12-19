<?php
//$Id: change_usr_names.php 8 2005-09-13 17:44:21Z sebhtml $

/*---------------------------------------------------------------------
sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

kovistaz Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/

 mysql_pconnect("darkstar", "root", "");

 mysql_query("USE zs8");
 
$r = mysql_query("
SELECT usr_nom, usr_prenom, usr_name
 FROM ooo_usrs, ooo_groups_usrs
WHERE ooo_usrs.usr_id= ooo_groups_usrs.usr_id AND
(
group_id=3
OR
group_id=4

)
");

$i = 1;

//exit();
while($f = mysql_fetch_assoc($r))
{
/*
I take the the nom and I add the first letter of the prenom
*/
$f["usr_prenom"] = str_replace("&eacute;", "e", $f["usr_prenom"]);
$f["usr_nom"] = str_replace("&eacute;", "e", $f["usr_nom"]);
$f["usr_prenom"] = str_replace("&Eacute;", "e", $f["usr_prenom"]);
$f["usr_nom"] = str_replace("&Eacute;", "e", $f["usr_nom"]);

$prenom_inherit = $f["usr_prenom"][0];//first char

$nom_inherit = explode(" ", $f["usr_nom"]);//explode with spaces
$nom_inherit = $nom_inherit[0];//the first name...
$nom_inherit = explode("-", $nom_inherit);//explode with minus
$nom_inherit = $nom_inherit[0];//the first name...

$new_usr_name = $prenom_inherit.$nom_inherit;//merge the two string.

//I must lower case them...

$new_usr_name = strtolower($new_usr_name);

echo "#$i<br />
#".$f["usr_name"]." ".$f["usr_prenom"]." ".$f["usr_nom"]."<br />
UPDATE ooo_usrs SET usr_name='$new_usr_name' WHERE usr_name='".$f["usr_name"]."' ;<br />
<br />
";
$i++;
	if(isset($t[$new_usr_name]))
	{
	echo "danger";
	}
	else
	{
	$t[$new_usr_name] = $f["usr_name"];
	$hy[$f["usr_name"]] = $new_usr_name;
	}
}

mysql_free_result($r);

echo nl2br(print_r($hy, TRUE));

?>
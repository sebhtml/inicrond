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

session_start();
/*
if(isset($HTTP_RAW_POST_DATA))
{
        $_SESSION["my_xml"] = $HTTP_RAW_POST_DATA;
}
*/
//it is better to use the php://input url wrapper

if (isset($_GET["debug"]))
{
    echo $_SESSION['my_xml'];
    echo 'end of RAW XML\n';
}

$fp = fopen('php://input', 'r');
$_SESSION['my_xml'] = fread($fp, 2048);
fclose($fp);

$xml_parser = xml_parser_create();

$data =$_SESSION['my_xml'];

xml_parse_into_struct($xml_parser, $data, $vals, $index);
xml_parser_free($xml_parser);

echo '<XML>';

$score = 0;

foreach ($index["PREG_EXP"] AS $key => $value)
{
    echo "<ELEMENT>";
    $score =  preg_match($vals[$index["PREG_EXP"][$key]]["value"], $vals[$index["STRING_ANALYSIS"][$key]]["value"]) ? 1 : 0;
    echo "<SCORE>".$score."</SCORE>";
    echo "</ELEMENT>";

    if(isset($_GET["debug"]))
    {
        echo "exp =".$vals[$index["PREG_EXP"][$key]]["value"].", ";
        echo "string =".$vals[$index["STRING_ANALYSIS"][$key]]["value"].", ";
        echo "value =".$score.", ";
    }
}

echo '</XML>';

?>
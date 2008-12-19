<?php
/*
    $Id: update_config.php 78 2005-12-21 03:16:28Z sebhtml $

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

if(__INICROND_INCLUDED__)
{
	echo "<table border=\"0\" cellpadding=\"5\" bgcolor=\"#FEFADB\" width=\"100%\"><tr><td>";
	$_OPTIONS["modules_dir"] = array();
	
	$fp = openDir($_OPTIONS["file_path"]["mod_dir"]);
	
	echo "reading modules dir...<br />";
	
	while($module_name = readDir($fp))
	{
		echo "<table border=\"0\" cellpadding=\"5\"  bgcolor=\"#ADCDAE\" width=\"100%\"><tr><td>";
		$tmp = $_OPTIONS["modules"];
		unset($_OPTIONS["modules"]);
	
		$file = $_OPTIONS["file_path"]["mod_dir"]."/".$module_name."/includes/module_id.inc.php";
		
		if(is_file($file))
		{
			echo "configuring module named $module_name...<br />";
			echo "<table border=\"0\" cellpadding=\"5\"  bgcolor=\"#AABCFE\" width=\"100%\"><tr><td>";
			echo "getting modules ids ...<br />";
	
			$_OPTIONS["modules_dir"] []= $module_name;
		
			include $file;
			
			//on ajoute le chemi du module...
			foreach($_OPTIONS["modules"] AS $key => $value)
			{
				$tmp["$key"] = $_OPTIONS["file_path"]["mod_dir"]."/".$module_name."/".$value;
			}
			
			echo "</td></tr></table>";	
		}
		//on remet les modules_id...
	
		$_OPTIONS["modules"] = $tmp;	
	
		//le nom des tables...
		$tab_sql_file = $_OPTIONS["file_path"]["mod_dir"]."/".$module_name."/sql/tables.php";
		
		if(is_file($tab_sql_file))
		{
			echo "<table border=\"0\" cellpadding=\"5\"  bgcolor=\"#ADBEDD\" width=\"100%\"><tr><td>";
			echo "getting the name of the tables ...<br />";
			include $tab_sql_file;	
			echo "</td></tr></table>";
		}
		
		echo "</td></tr></table>";
	}	
	
	$table_list_file_content = "";
	
	foreach($_OPTIONS["tables"] AS $key => $value)
	{
		$table_list_file_content .= "\$_OPTIONS[\"tables\"][\"$key\"] = \"$value\";
";
	}
	
	$fp = fopen($_OPTIONS["file_path"]["sql_tables"] , "w+");
	fwrite($fp, "<?php\n$table_list_file_content\n?>");
	fclose($fp);
	echo "<table border=\"0\"  cellpadding=\"5\" bgcolor=\"#FAAEDD\" width=\"100%\"><tr><td>";
	echo $_OPTIONS["file_path"]["sql_tables"] ." has been written ...<br />";
	echo "</td></tr></table>";
	
	$module_id_file_content = "";
		
	
	foreach($_OPTIONS["modules"] AS $key => $value)
	{
		$module_id_file_content .= "\$_OPTIONS[\"modules\"][\"$key\"] = \"$value\";
";
	
	}
	
	$fp = fopen($_OPTIONS["file_path"]["modules_id"], "w+");
	fwrite($fp, "<?php\n$module_id_file_content?>");
	fclose($fp);
	//
	echo "<table border=\"0\"  cellpadding=\"5\" bgcolor=\"#FAFEDD\" width=\"100%\"><tr><td>";
	echo $_OPTIONS["file_path"]["modules_id"] ." has been written ...<br />";
	echo "</td></tr></table>";
	
	$module_dir_file_content = "";
		
	foreach($_OPTIONS["modules_dir"] AS $key => $value)
	{
		$module_dir_file_content .= "\$_OPTIONS[\"modules_dir\"][\"$key\"] = \"$value\";
";
	}
	
	$fp = fopen($_OPTIONS["file_path"]["mod_dirs"], "w+");
	fwrite($fp, "<?php\n$module_dir_file_content?>");
	fclose($fp);
	echo "<table border=\"0\"  cellpadding=\"5\" bgcolor=\"#ABFEDD\" width=\"100%\"><tr><td>";
	echo $_OPTIONS["file_path"]["mod_dirs"] ." has been written ...<br />";
	echo "</td></tr></table>";
	
	echo "</td></tr></table>";
}

?>
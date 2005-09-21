<?php
//$Id$


//exit();

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : search this site argh
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

include "modules/search/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";

if(isset($_OPTIONS["INCLUDED"]) //inclusion obligatoire
)
{//début du if
	
$elements_titre = array(
$_LANG["35"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



	if(isset($_GET["what"]) AND
	$_GET["what"] != ""
	)
	{
	
//$_GET["fichiers"] = 1;

	
	$_GET["what"] = filter($_GET["what"]);//les entités html.
	
		//if(isset($_GET["fichiers"]) )
		//{
			
			$queries[0] =
			"SELECT
				uploaded_file_title AS data2, uploaded_file_id AS data1
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	AND
	(usr_name LIKE '%".$_GET["what"]."%'
	OR
	uploaded_file_title LIKE '%".$_GET["what"]."%'
	OR
	uploaded_file_description LIKE '%".$_GET["what"]."%'
	OR
	 uploaded_file_name LIKE '%".$_GET["what"]."%')
	 ";
			
			
			
			
			
			$queries[1] =
			"SELECT
				forum_message_titre AS data3, forum_sujet_id AS data1,
				forum_message_id AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	AND
	(usr_name LIKE '%".$_GET["what"]."%'
	OR
	forum_message_titre LIKE '%".$_GET["what"]."%'
	OR
	forum_message_contenu LIKE '%".$_GET["what"]."%')
	
	 ";
						
			
			
			$queries[2] =
			"SELECT
			image_id AS data1,	
image_title AS data2
 
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	AND
	(usr_name LIKE '%".$_GET["what"]."%'
	OR
	image_title LIKE '%".$_GET["what"]."%'
	OR
	image_description LIKE '%".$_GET["what"]."%'
	OR
	file_name LIKE '%".$_GET["what"]."%')
	 ";
			
			
			
			$queries[3] =
			"SELECT
			wiki_id AS data1,
			wiki_title  AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	AND
	(usr_name LIKE '%".$_GET["what"]."%'
	OR
	wiki_title LIKE '%".$_GET["what"]."%'
	OR
	wiki_content LIKE '%".$_GET["what"]."%')
	;";
		
			
			
			$queries[4] =
			"SELECT
			usr_id AS data1,
			usr_name  AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	(usr_name LIKE '%".$_GET["what"]."%'
	OR
	usr_communication_language LIKE '%".$_GET["what"]."%'
	OR
	usr_localisation LIKE '%".$_GET["what"]."%'
	OR
	usr_web_site LIKE '%".$_GET["what"]."%'
	OR
	usr_job LIKE '%".$_GET["what"]."%'
	OR
	usr_hobbies LIKE '%".$_GET["what"]."%'
	OR
	usr_status LIKE '%".$_GET["what"]."%'
	OR
	usr_signature LIKE '%".$_GET["what"]."%')
	;";
			
			
			

			$queries[5] =
			"SELECT
			link_id AS data1,
			link_title  AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	AND
	(usr_name LIKE '%".$_GET["what"]."%'
	OR
	usr_communication_language LIKE '%".$_GET["what"]."%'
	OR
link_title LIKE '%".$_GET["what"]."%'
OR
link_description LIKE '%".$_GET["what"]."%'
OR
link_url LIKE '%".$_GET["what"]."%')
	;";
			
			
	
include "includes/class/Search_layout.class.php";

$mon_bobu = new  Search_layout($queries, $_LANG, $mon_objet, $_OPTIONS);
 $module_content .= $mon_bobu->output();
 
		//}
	}
	else//formulaire
	{//début du else
	
   include "modules/search/includes/forms/search_my.form.php";
   
            $module_content .= "<br />".$_LANG["35"]["info"];
     
	}
}//fin du if
?>
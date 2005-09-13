<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : * MODULE DE DÉCONNEXION
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
if(isset($_OPTIONS["INCLUDED"]))
{


//analyse la soumission		
	if (isset($_POST["log_in_as_usr"]))//demande de login
	{
	
		
	$query = "SELECT
	usr_id,
	usr_time_decal,
	usr_communication_language,
	usr_activation

	FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	usr_name='".$_POST["usr_name"]."'
	AND
	usr_md5_password='".md5($_POST["usr_password"])."'
	";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);

		
		if(isset($fetch_result["usr_id"] ) AND
		$fetch_result["usr_id"] != $_OPTIONS["usr_id"]["nobody"] AND
		$fetch_result["usr_activation"] == 1
		)//on a trouv�??
		{

//print_r($fetch_result);


			//variable de session
			$_SESSION["sebhtml"]["usr_id"] = $fetch_result["usr_id"] ;
			$_SESSION["sebhtml"]["usr_name"] = $_POST["usr_name"];
			$_SESSION["sebhtml"]["usr_communication_language"] = $fetch_result["usr_communication_language"] ;
			$_SESSION["sebhtml"]["usr_time_decal"] = $fetch_result["usr_time_decal"] ;
			


			//$layout_contenu .= $r["windows_width"];

			//$_SESSION["sebhtml"]["windows_width"] = $fetch_result["windows_width"] ;//;largeur
			
		if(isset($_SESSION["sebhtml"]["session_id"]))//si il y avait des sessions anonymes...
		{	
$sql = //on enlève le visiteur
"
	UPDATE 
	 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]." 
	SET
	is_online=0
	WHERE
	 session_id=".$_SESSION["sebhtml"]["session_id"] ."
;";
	$mon_objet->query($sql);
		}//fin du if.
		
$start_gmt = gmmktime();
$end_gmt = $start_gmt;

			$query = "INSERT INTO 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_sessions"]." 
	(
usr_id,
php_session_id,	

HTTP_USER_AGENT ,

HTTP_ACCEPT ,
HTTP_ACCEPT_LANGUAGE ,
HTTP_ACCEPT_ENCODING ,
HTTP_ACCEPT_CHARSET ,

HTTP_KEEP_ALIVE   ,

HTTP_CONNECTION,


REMOTE_ADDR,
REMOTE_PORT,

dns,
start_gmt, 
end_gmt

	 ) 
	VALUES
	(
	".$fetch_result["usr_id"].",
'".session_id()."',	

'".$_SERVER["HTTP_USER_AGENT"]."' ,

'".$_SERVER["HTTP_ACCEPT"]."' ,
'".$_SERVER["HTTP_ACCEPT_LANGUAGE"]."' ,
'".$_SERVER["HTTP_ACCEPT_ENCODING"]."' ,
'".$_SERVER["HTTP_ACCEPT_CHARSET"]."' ,

'".$_SERVER["HTTP_KEEP_ALIVE"]."'  ,

'".$_SERVER["HTTP_CONNECTION"]."',


'".$_SERVER["REMOTE_ADDR"]."',
'".$_SERVER["REMOTE_PORT"]."',
'".gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
$start_gmt, 
$end_gmt
	   );";

		$mon_objet->query($query);
		
	$_SESSION["sebhtml"]["session_id"] = $mon_objet->insert_id();//la variable de session.
	
	
	//print_r($_SERVER);
	echo js_redir("?".""."".base64_decode($_POST["redirect"]));
	exit();
/*
	
	//print_R($_SERVER);		
	echo js_redir(""."?"."".base64_decode($_POST["redirect"]));
	exit();
	
	*/		
			//exit();
		}
		elseif($fetch_result["usr_activation"] == 0)//pas activ�.
		{
		$tmp["error"] = $_LANG["msg_error"]["not_activated"];
		//$layout_contenu .= $_LANG["msg_error"]["not_activated"];
		}
		else
		{
		 $tmp["error"] = $_LANG["msg_error"]["acces_denied"];
		
		}

	}


}


	
?>

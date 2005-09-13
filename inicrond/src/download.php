<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : 
//----------------------------
// module de téléchargement
// recoit un id et permet de downloader ce fichier avec la database ou image
//-------------------------
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet :inicrond
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





$_OPTIONS["INCLUDED"] = 1; // sécurité
//--------------------------
//inclusion
//----------------------------

session_start();

include "includes/kernel/db_init.php";
include $_OPTIONS["file_path"]["opt_in_mysql"];//les options comme l'heure...
include "includes/kernel/visits_tracker_inc.php" ;//met à jour les sessions.

if( 
isset($_GET["uploaded_file_id"]) AND
$_GET["uploaded_file_id"] != "" AND
(int) $_GET["uploaded_file_id"]
)
{


$query = "SELECT 
 uploaded_file_name
 FROM
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]." 
 WHERE 
 uploaded_file_id=".$_GET["uploaded_file_id"]  ."
 ;";

$query_result = $mon_objet->query($query);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);


	if(is_file($_OPTIONS["uploaded_files_dir"]."/".$_GET["uploaded_file_id"]) )//erreur ?
	{
	
	//--------------
	//en-tête http...
	//--------------
	
//header("Content-disposition: attachment; filename=$Fichier_a_telecharger");
header("Content-Disposition: attachment; filename=".$fetch_result["uploaded_file_name"]);
	
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: application/octet-stream\n"); // Surtout ne pas enlever le \n
header("Content-Length: ".filesize($_OPTIONS["uploaded_files_dir"]."/".$_GET["uploaded_file_id"]));
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
header("Expires: 0"); 

	//header("Content-type: application/force-download");

	
	readfile($_OPTIONS["uploaded_files_dir"]."/".$_GET["uploaded_file_id"]);//contenu du fichier
	
	//------------------
	//on augment le nb_dl
	//------------------
	
	//$queries["UPDATE"] ++; // comptage
	if(!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))
	{	
		$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["downloads_of_files"]."
		(session_id, uploaded_file_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["uploaded_file_id"].", ".gmmktime().")
		";
//die($tmp);

		$mon_objet->query($query);
		/*$query = "
		UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
		SET
		nb_downloads=nb_downloads+1
		WHERE
		uploaded_file_id=".$_GET["uploaded_file_id"]."
		;";

		$query_result = $mon_objet->query($query);
		*/
	
	}
	exit();//sort d'ici argh!!!
		
	}
	else
	{
	
	echo "error";
	}

}

elseif( 
isset($_GET["image_id"]) AND
$_GET["image_id"] != "" AND
(int) $_GET["image_id"]
)
{




$query = "SELECT 
file_name
 FROM
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
 WHERE 
 image_id=".$_GET["image_id"]  ."
 ;";

$query_result = $mon_objet->query($query);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

	if(is_file($_OPTIONS["images_dir"]."/".$_GET["image_id"]) )//erreur ?
	{

	//header("Content-type: image/JPEG");
$file = $_OPTIONS["images_dir"]."/".$_GET["image_id"];

//$image_size = getimagesize($file);
//exit();//debug

//header("Content-type: ".$image_size["mime"]);

	header("Content-Disposition: attachment; filename=".$fetch_result["file_name"]);
	
	readfile($_OPTIONS["images_dir"]."/".$_GET["image_id"]);//contenu du fichier

	}

}


elseif( 
isset($_GET["usrs_pics"]) AND
$_GET["usrs_pics"] != "" AND
(int) $_GET["usrs_pics"]
)
{

$file = $_OPTIONS["usrs_pics"]."/".$_GET["usrs_pics"];


	if(is_file($file) )//erreur ?
	{

$image_size = getimagesize($file);

//die($image_size["mime"]);

header("Content-type: ".$image_size["mime"]);
	
readfile($_OPTIONS["usrs_pics"]."/".$_GET["usrs_pics"]);//contenu du fichier

	}

}


elseif( 
isset($_GET["miniatures"]) AND
$_GET["miniatures"] != "" AND
(int) $_GET["miniatures"]
)
{

if(is_file($_OPTIONS["images_dir"]."/".$_GET["miniatures"]) )//on cr�r le miniature.
{


$file = $_OPTIONS["images_dir"]."/".$_GET["miniatures"];

$image_size = getimagesize($file);//pour le mime type.



	if($image_size["mime"] == "image/jpeg")
	{
	$src_img = imagecreatefromJPEG($file);
	}
	elseif($image_size["mime"] == "image/png")
	{
	$src_img = imagecreatefromPNG($file);
	}
	elseif($image_size["mime"] == "image/gif")
	{
	$src_img = imagecreatefromGIF($file);
	}
	
	$width = imagesx($src_img); 
	$height = imagesy($src_img); 
	$dest_width = 80; 
	$dest_height = $dest_width*$height/$width; 
	$dest_img = imagecreate($dest_width, $dest_height); 
	imagecopyresized( $dest_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height); 
	header("Content-type: "."image/jpeg");
	imageJPEG($dest_img);//output 


   
}
	
	

}

elseif(isset($_GET["loi_normal"]))
{
include "includes/class/plotter/Loi_normal.class.php";

$test = new Loi_normal();


$test->set_data($_SESSION["sebhtml"]["loi_normal"]);



//print_r($_SESSION["sebhtml"]["loi_normal"]);

$_SESSION["sebhtml"]["loi_normal"] = "";

$test->gd_graph();
}
elseif(isset($_GET["calib_curve"]))
{
include "includes/class/plotter/Calib_curve.class.php";

$test = new Calib_curve();
//print_r($_SESSION);
//print_r($_SESSION["sebhtml"]["calib_curve"]);

$test->set_data($_SESSION["sebhtml"]["calib_curve"]);



//$_SESSION["sebhtml"]["calib_curve"] = "";


$test->gd_graph();
}

?>
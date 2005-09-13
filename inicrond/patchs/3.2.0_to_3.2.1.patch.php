<?php
//$Id$

/*

* Copy all new src/* files into your installation.
* Change the prefix table by doing a mass replace of ooo_ in this very file.
* COpy this file into your root installation directory.
* Run the file via a browser
* Change the double quote for single quotes in db_Config file.
* Remove the dbquery.php script if you only paste the new files on the old files.

*/ 

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");

include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";


$sql = "

CREATE TABLE ooo_inicrond_images (
  img_id int(10) unsigned NOT NULL auto_increment,
  img_title varchar(32) NOT NULL default '',
  img_file_name varchar(255) NOT NULL default '',
  img_hexa_path varchar(32) NOT NULL default '',
  img_description text NOT NULL,
  cours_id int(10) unsigned NOT NULL default '0',
  add_time_t int(10) unsigned NOT NULL default '0',
  edit_time_t int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (img_id),
  KEY cours_id (cours_id)
) TYPE=MyISAM;";

$inicrond_db->Execute($sql);

$sql = "

CREATE TABLE ooo_inicrond_texts (
  text_id int(10) unsigned NOT NULL auto_increment,
  text_title varchar(32) NOT NULL default '',
  text_description text NOT NULL,
  cours_id int(10) unsigned NOT NULL default '0',
  add_time_t int(10) unsigned NOT NULL default '0',
  edit_time_t int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (text_id),
  KEY cours_id (cours_id)
) TYPE=MyISAM;";
$inicrond_db->Execute($sql);

//get all images and insert them in the good table, then, delete the entry.
//get all texts and insert them in the good table, then, delete the entry.


	$query = "SELECT
	chapitre_media_id, 
	 chapitre_media_title,

	 file_name,
	 chapitre_media_edit_gmt_timestamp,
	 chapitre_media_add_gmt_timestamp,
	 chapitre_media_description,
content_id,
HEXA_TAG,
chapitre_media_type,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"].".cours_id AS cours_id,
inode_id

	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"].",
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
	WHERE
	chapitre_media_id = content_id
	AND
	(chapitre_media_type='2' OR chapitre_media_type = '3')
	AND
	content_type='3'
	";

	$rs = $inicrond_db->Execute($query);
	while($fetch_result = $rs->FetchRow())
	{ 
	/*
	foreach of them,
	insert the data in the new table
	update the content  id.,. 
	update the content type = '4'
	*/
		if($fetch_result["chapitre_media_type"] == 2)//it is an image
		{
		

$query = "INSERT INTO
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inicrond_images"]."
	(
	img_title,
	img_file_name,
	img_hexa_path,
	img_description,
	cours_id,
	add_time_t,
	edit_time_t
	)
	VALUES
	(
	'".$fetch_result["chapitre_media_title"]."',
	'".$fetch_result["file_name"]."',
	'".$fetch_result["HEXA_TAG"]."',
	'".$fetch_result["chapitre_media_description"]."',
	".$fetch_result["cours_id"].",
	".$fetch_result["chapitre_media_add_gmt_timestamp"].",
	".$fetch_result["chapitre_media_edit_gmt_timestamp"]."
	)
	";

	 $inicrond_db->Execute($query);

	 $content_id = $inicrond_db->Insert_ID();
	 
	 $query = "UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
	SET
	content_type = '4',
	content_id = $content_id
	WHERE
	inode_id = ".$fetch_result["inode_id"]."
	";

	 $inicrond_db->Execute($query);
	 
		}
		elseif($fetch_result["chapitre_media_type"] == 3)//it is a text.
		{
	
	$query = "INSERT INTO
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inicrond_images"]."
	(
	text_title,
	text_description,
	cours_id,	
	add_time_t,
	edit_time_t
	)
	VALUES
	(
	'".$fetch_result["chapitre_media_title"]."',
	'".$fetch_result["chapitre_media_description"]."',
	".$fetch_result["cours_id"].",
	".$fetch_result["chapitre_media_add_gmt_timestamp"].",
	".$fetch_result["chapitre_media_edit_gmt_timestamp"]."
	)
	";

	 $inicrond_db->Execute($query);

	 $content_id = $inicrond_db->Insert_ID();
	 
	 $query = "UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
	SET
	content_type = '5',
	content_id = $content_id
	WHERE
	inode_id = ".$fetch_result["inode_id"]."
	";

	 $inicrond_db->Execute($query);
	 	
		}
	

	}

$sqls = array();
//delete all images and all texts from chapitre_media
$sqls[] = "DELETE FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"]."
	WHERE
	chapitre_media_type='2' 
	OR 
	chapitre_media_type = '3'
	";



$sqls[] = "ALTER TABLE `ooo_chapitre_media`
  DROP `chapitre_media_type`;";

$sqls[] = "ALTER TABLE `ooo_chapitre_media` CHANGE `chapitre_media_description` `chapitre_media_description` VARCHAR( 255 ) NOT NULL ";


$sqls[] = "update ooo_inode_elements set order_id=inode_id;";

$sqls[] = "ALTER TABLE `ooo_chapitre_media`
  DROP `CHECK_FOR_TEST_LINKAGE`;";

/*
$sqls[] = "";
$sqls[] = "";
$sqls[] = "";
$sqls[] = "";
 */



//$sqls[] = "";

  //foreach query, query the query.
  foreach($sqls AS $sql)
  {
   $inicrond_db->Execute($sql);
  }
?>


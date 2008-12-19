<?php
//$Id: 3.2.2_to_3.3.0.php 8 2005-09-13 17:44:21Z sebhtml $

/*
This patch add a new table to hold the virtual directory names.

THis is the analysis/conception of this patch.

//* create the virtual directories table
//* Get all the directories from inode_elements (content_type = 0)
//* Foreach directory
	//*insert a row in directory table
	//*update the content_id  in inode_Elements
//*delete the  inode_name column from inode_elements

*/

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";


//* create the virtual directories table
$sql = "

CREATE TABLE 
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['virtual_directories']." (
	dir_id int(10) unsigned NOT NULL auto_increment,
	dir_name varchar(64) DEFAULT '',
	PRIMARY KEY  (dir_id)

) ;";

$inicrond_db->Execute($sql);

//* Get all the directories from inode_elements (content_type = 0)
$sql = "
SELECT inode_name, inode_id
FROM
 ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']." 
	
 WHERE
 content_type = '0'

";
$rs = $inicrond_db->Execute($sql);
	
	
	while($fetch_result = $rs->FetchRow())
	{ 

//* Foreach directory
	//*insert a row in directory table
	$sql = "

INSERT INTO
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['virtual_directories']." 
(dir_name)
VALUES
('".addSlashes($fetch_result['inode_name'])."')
";

$inicrond_db->Execute($sql);
	
$content_id =$inicrond_db->Insert_ID();

	//*update the content_id  in inode_Elements
	
	$sql = "

UPDATE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']." 
SET
content_id=".$content_id."
WHERE
inode_id =".$fetch_result['inode_id']."
";

$inicrond_db->Execute($sql);
	}

	

//*delete the  inode_name column from inode_elements


$sql = "

ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']." 
DROP
 inode_name 
";

$inicrond_db->Execute($sql);



?>
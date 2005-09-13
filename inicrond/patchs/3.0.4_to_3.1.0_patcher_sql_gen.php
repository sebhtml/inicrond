<?php
//$Id$
/*
paste the new files and run this file...
*/
$_RUN_TIME["INCLUDED"] = TRUE;
$_RUN_TIME["include_prefix"] = "../src/";//change if the script is run else where
include $_RUN_TIME["include_prefix"]."includes/kernel/db_init.php";



$_RUN_TIME["db"]->query("DROP TABLE  ".$_OPTIONS["table_prefix"]."downloads_of_files".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."views_of_files".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."sebhtml_uploaded_files".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."sebhtml_uploaded_files_sections".";");


$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."sebhtml_images".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."sebhtml_galeries;");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."views_of_images;");


$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."links".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."directory_sections".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."clicks_for_links".";");
$_RUN_TIME["db"]->query("DROP TABLE ".$_OPTIONS["table_prefix"]."views_of_links".";");

$_RUN_TIME["db"]->query("CREATE TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]."  (
mod_alias VARCHAR (32),

caching TINYINT UNSIGNED DEFAULT 0,

#this field is used to order by entries
cache_lifetime INT UNSIGNED 

);");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]." (mod_alias, caching, cache_lifetime) VALUES ('about_it', 1, 3600);");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]." (mod_alias, caching, cache_lifetime) VALUES ('translations', 1, 3600);");


$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]." (mod_alias, caching, cache_lifetime) VALUES ('credits', 1, 3600);");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]." (mod_alias, caching, cache_lifetime) VALUES ('docs_info', 1, 3600);");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]." (mod_alias, caching, cache_lifetime) VALUES ('help', 1, 3600);");


//update the question for bank of questions...




$_RUN_TIME["db"]->query("ALTER TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]." ADD `cours_id` BIGINT UNSIGNED NOT NULL ;");

$_RUN_TIME["db"]->query("ALTER TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]." ADD INDEX ( `cours_id` ) ;");


$_RUN_TIME["db"]->query("CREATE TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["question_linking"]." (


#liaison avec les tests.
test_id BIGINT UNSIGNED ,
KEY test_id (test_id),

#liaison avec les tests.
question_id BIGINT UNSIGNED ,
KEY question_id (question_id),

q_order_id BIGINT UNSIGNED


)");



$sql = "SELECT
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".cours_id,
question_id,
q_order_id,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].".test_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"]."
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].".chapitre_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".chapitre_id
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"].".test_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].".test_id

";

$query_result = $_RUN_TIME["db"]->query($sql);	
while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{

//update the cours_id in the question table
$_RUN_TIME["db"]->query("UPDATE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]." 
 SET 
 cours_id=".$fetch_result["cours_id"]."
  WHERE
   test_id=".$fetch_result["test_id"].";
  ");
  
  //insert the q_link.
$_RUN_TIME["db"]->query("  INSERT INTO
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["question_linking"]." 
 (test_id, question_id, q_order_id)
 VALUES
 (".$fetch_result["test_id"].", ".$fetch_result["question_id"].", ".$fetch_result["q_order_id"].");
   ");
   
}
$_RUN_TIME["db"]->free_result($query_result);
	
$_RUN_TIME["db"]->query(" ALTER TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]." DROP `test_id` ,
DROP `q_order_id` ;");

//end of bank qestion update

//update of media place...



$sql = "SELECT
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".cours_id,
chapitre_media_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"]."
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"].".chapitre_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".chapitre_id


";

$query_result = $_RUN_TIME["db"]->query($sql);	
$queries = array();

while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{

$queries []=
//update the cours_id in the question table
"UPDATE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"]." 
 SET 
 cours_id=".$fetch_result["cours_id"]."
  WHERE
   chapitre_media_id=".$fetch_result["chapitre_media_id"]."
  ";
  

   
}

$_RUN_TIME["db"]->query("ALTER TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"]." CHANGE `chapitre_id` `cours_id` BIGINT( 20 ) UNSIGNED DEFAULT '0' NOT NULL 
");

$_RUN_TIME["db"]->query("ALTER TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"]." DROP `chapitre_media_numero`
 ;");



foreach($queries AS $sql)
{
$_RUN_TIME["db"]->query($sql);//query it now.


}
//end of update media place...


//update of files place...



$sql = "SELECT
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".cours_id,
file_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["courses_files"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"]."
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["courses_files"].".chapitre_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".chapitre_id


";

$query_result = $_RUN_TIME["db"]->query($sql);	
$queries = array();

while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{

$queries []=
//update the cours_id in the question table
"UPDATE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["courses_files"]."
 SET 
 cours_id=".$fetch_result["cours_id"]."
  WHERE
   file_id=".$fetch_result["file_id"]."
  ";
  

   
}

$_RUN_TIME["db"]->query("ALTER TABLE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["courses_files"]."
  CHANGE `chapitre_id` `cours_id` BIGINT( 20 ) UNSIGNED DEFAULT '0' NOT NULL 
");

foreach($queries AS $sql)
{
$_RUN_TIME["db"]->query($sql);//query it now.


}
//end of update file place...



//update of tests place...



$sql = "SELECT
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".cours_id,
test_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"]."
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].".chapitre_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"].".chapitre_id


";

$query_result = $_RUN_TIME["db"]->query($sql);	
$queries = array();

while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{

$queries []=
//update the cours_id in the question table
"UPDATE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"]."
 SET 
 cours_id=".$fetch_result["cours_id"]."
  WHERE
   test_id=".$fetch_result["test_id"]."
  ";
  

   
}

$_RUN_TIME["db"]->query("ALTER TABLE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"]."
  CHANGE `chapitre_id` `cours_id` BIGINT( 20 ) UNSIGNED DEFAULT '0' NOT NULL 
");

foreach($queries AS $sql)
{
$_RUN_TIME["db"]->query($sql);//query it now.


}
//end of update tests place...

$_RUN_TIME["db"]->query("DROP TABLE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitres"]."
  ;");

  
 $_RUN_TIME["db"]->query(" CREATE TABLE 
 ".$_OPTIONS["table_prefix"]."inode_elements"."
  (
inode_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (inode_id),

inode_id_location BIGINT UNSIGNED,
KEY inode_id_location (inode_id_location),
inode_name VARCHAR(255),
# 0 : dir
# 1 : file
# 2 : test
# 3 : swf
content_type TINYINT UNSIGNED,

#link to other tables...
content_id BIGINT UNSIGNED,
KEY content_id (content_id),

cours_id BIGINT UNSIGNED NOT NULL,
KEY cours_id (cours_id),

IS_VISIBLE TINYINT UNSIGNED DEFAULT 0


);
;");


//insert the already done objects in inodes..

//insert the files 
/*

CREATE TABLE inode_elements (
inode_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (inode_id),

inode_id_location BIGINT UNSIGNED,
KEY inode_id_location (inode_id_location),
inode_name VARCHAR(255),
# 0 : dir
# 1 : file
# 2 : test
# 3 : media
content_type TINYINT UNSIGNED,

#link to other tables...
content_id BIGINT UNSIGNED,
KEY content_id (content_id),


cours_id BIGINT UNSIGNED NOT NULL,
KEY cours_id (cours_id)


);
*/

$sql = "SELECT
file_id,
cours_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["courses_files"]."
";

$query_result = $_RUN_TIME["db"]->query($sql);	


while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{


  $_RUN_TIME["db"]->query("INSERT INTO 
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
  (inode_id_location, content_type, content_id, cours_id)
  VALUES
  (0, 1, ".$fetch_result["file_id"].", ".$fetch_result["cours_id"].")
  ");	

   
}

//end of insert files


//insert the tests in inodes...
$sql = "SELECT
test_id,
cours_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"]."
";

$query_result = $_RUN_TIME["db"]->query($sql);	


while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{


  $_RUN_TIME["db"]->query("INSERT INTO 
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
  (inode_id_location, content_type, content_id, cours_id)
  VALUES
  (0, 2, ".$fetch_result["test_id"].", ".$fetch_result["cours_id"].")
  ");	

   
}

//end of insert tests

//insert the media_content
$sql = "SELECT
chapitre_media_id,
cours_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["chapitre_media"]."
";

$query_result = $_RUN_TIME["db"]->query($sql);	


while($fetch_result = $_RUN_TIME["db"]->fetch_assoc($query_result))
{


  $_RUN_TIME["db"]->query("INSERT INTO 
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
  (inode_id_location, content_type, content_id, cours_id)
  VALUES
  (0, 3, ".$fetch_result["chapitre_media_id"].", ".$fetch_result["cours_id"].")
  ");	

   
}

//end of insert tests

 $_RUN_TIME["db"]->query("INSERT INTO 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_blocks"]."
  (block_alias, x_position, y_position) VALUES ('calendar_block', 4, 4);");
  
  $_RUN_TIME["db"]->query(" INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 353); 
  ");

 $_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 353); 
 ");


$_RUN_TIME["db"]->query("DROP TABLE  ".$_OPTIONS["table_prefix"]."comments".";");

$_RUN_TIME["db"]->query("ALTER TABLE 
".$_OPTIONS["table_prefix"]."sebhtml_options"."
 
 ADD `preg_file_name` VARCHAR( 255 ) DEFAULT '/[^ ]+/' NOT NULL ;");

$_RUN_TIME["db"]->query("DELETE FROM
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_blocks"]."
WHERE
block_alias='about';
");

$_RUN_TIME["db"]->query("DELETE FROM 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_mod_conf"]."
 WHERE 1 ");

$_RUN_TIME["db"]->query(" ALTER TABLE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"]."
  ADD `time_GMT_add` BIGINT UNSIGNED NOT NULL ,
ADD `time_GMT_edit` BIGINT UNSIGNED NOT NULL ;");

$_RUN_TIME["db"]->query("ALTER TABLE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["cours"]."
  ADD `news_forum_id` INT UNSIGNED NOT NULL ;");
  
$_RUN_TIME["db"]->query("CREATE TABLE 
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sections_groups_admin"]."
 
 (
forum_section_id SMALLINT UNSIGNED,
KEY forum_section_id( forum_section_id ) ,
group_id INT UNSIGNED,
KEY group_id( group_id )
)");
  

$_RUN_TIME["db"]->query("INSERT INTO  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 355);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 356);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 357);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 358);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 359);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 360);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 361);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 362);
");

$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 355);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 356);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 357);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 358);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 359);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 360);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 361);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 362);
");

$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 364);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 364);
");


$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 365);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (1, 366);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 365);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 366);
");


$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 367);
");

$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 370);
");
$_RUN_TIME["db"]->query("INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups_actions"]." (group_id, action_id) VALUES (2, 371);
");


?>
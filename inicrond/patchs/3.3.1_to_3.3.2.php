<?php
//$Id$

/*
put this file in the inicrond root installation.
THe root is in fact the src.
*/

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";


$sql = "INSERT INTO
 ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['sebhtml_options']."

(opt_name, opt_value) VALUES ('html_output_on_one_line', '1')
";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['chapitre_media']."
  DROP `cours_id`;";


$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_images']."
  DROP `cours_id`;";


$inicrond_db->Execute($sql);



$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['tests']."
  DROP `cours_id`;";


$inicrond_db->Execute($sql);





$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_texts']."
  DROP `cours_id`;";


$inicrond_db->Execute($sql);


$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['courses_files']."
  DROP `cours_id`;";

$inicrond_db->Execute($sql);

$sql = "
create table ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['register_random_validation']."  (
        usr_id int unsigned,
        register_random_validation varchar(32) default NULL,
        key usr_id (usr_id)
) ;" ;

$inicrond_db->Execute($sql);

$sql = "
create table ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['new_password_secure_str']." (
        usr_id int unsigned,
        new_password_secure_str varchar(32) default NULL,
        key usr_id (usr_id)
) ;
" ;

$inicrond_db->Execute($sql);

// select all register random validation from usrs

$sql = "select usr_id, register_random_validation from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['usrs']."
where register_random_validation is not null" ;

$rs = $inicrond_db->Execute($sql);

while($row = $rs->FetchRow ())
{
        $sql = "insert into ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['register_random_validation']."
        (usr_id, register_random_validation)
        values
        (".$row['usr_id'].", '".$row['register_random_validation']."') ";

        $inicrond_db->Execute($sql);
}

// select all new_password_secure_str from user .

$sql = "select usr_id, new_password_secure_str from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['usrs']."
where new_password_secure_str is not null" ;

$rs = $inicrond_db->Execute($sql);

while($row = $rs->FetchRow ())
{
        $sql = "insert into ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['new_password_secure_str']."
        (usr_id, new_password_secure_str)
        values
        (".$row['usr_id'].", '".$row['new_password_secure_str']."') ";

        $inicrond_db->Execute($sql);
}

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['usrs']."
  DROP register_random_validation;";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['usrs']."
  DROP new_password_secure_str;";

$inicrond_db->Execute($sql);

// remove the usr_id where it'S useless...

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['scores']."
  DROP usr_id;";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['results']."
  DROP usr_id;";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['page_views']."
  DROP usr_id;";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['acts_of_downloading']."
  DROP usr_id;";

$inicrond_db->Execute($sql);


/*******************************
add inode_id to several tables
************************************/

//chapitre_media
$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['chapitre_media']."
  add inode_id int unsigned";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['chapitre_media']."
  add index (inode_id) ";

$inicrond_db->Execute($sql);

//inicrond_images
$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_images']."
  add inode_id int unsigned";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_images']."
  add index (inode_id) ";

$inicrond_db->Execute($sql);
// tests
$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['tests']."
  add inode_id int unsigned";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['tests']."
  add index (inode_id) ";

$inicrond_db->Execute($sql);
// inicrond_texts
$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_texts']."
  add inode_id int unsigned";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_texts']."
  add index (inode_id) ";

$inicrond_db->Execute($sql);
// courses_files
$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['courses_files']."
  add inode_id int unsigned";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['courses_files']."
  add index (inode_id) ";

$inicrond_db->Execute($sql);
// virtual_directories
$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['virtual_directories']."
  add inode_id int unsigned";

$inicrond_db->Execute($sql);

$sql = "ALTER TABLE
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['virtual_directories']."
  add index (inode_id) ";

$inicrond_db->Execute($sql);

/*****************************
Now it is time to fill the inode_id stuff with mass updates.
*******************************/

/*
        0 : directory
        1 : file
        2 : test
        3 : flash
        4 : image
        5 : text
*/


//virtual_directories
$sql = "select inode_id, content_id from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']."
where content_type = '0'" ;

$rs = $inicrond_db->Execute($sql);

while ($row = $rs->FetchRow ())
{
        $sql = "update ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['virtual_directories']."
        set inode_id = ".$row['inode_id']." where dir_id = ".$row['content_id']."" ;

        $inicrond_db->Execute($sql);
}

//chapitre_media
$sql = "select inode_id, content_id from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']."
where content_type = '3'" ;

$rs = $inicrond_db->Execute($sql);

while ($row = $rs->FetchRow ())
{
        $sql = "update ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['chapitre_media']."
        set inode_id = ".$row['inode_id']." where chapitre_media_id = ".$row['content_id']."" ;

        $inicrond_db->Execute($sql);
}

//inicrond_images
$sql = "select inode_id, content_id from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']."
where content_type = '4'" ;

$rs = $inicrond_db->Execute($sql);

while ($row = $rs->FetchRow ())
{
        $sql = "update ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_images']."
        set inode_id = ".$row['inode_id']." where img_id = ".$row['content_id']."" ;

        $inicrond_db->Execute($sql);
}
// tests
$sql = "select inode_id, content_id from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']."
where content_type = '2'" ;

$rs = $inicrond_db->Execute($sql);

while ($row = $rs->FetchRow ())
{
        $sql = "update ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['tests']."
        set inode_id = ".$row['inode_id']." where test_id = ".$row['content_id']."" ;

        $inicrond_db->Execute($sql);
}
// inicrond_texts
$sql = "select inode_id, content_id from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']."
where content_type = '5'" ;

$rs = $inicrond_db->Execute($sql);

while ($row = $rs->FetchRow ())
{
        $sql = "update ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inicrond_texts']."
        set inode_id = ".$row['inode_id']." where text_id = ".$row['content_id']."" ;

        $inicrond_db->Execute($sql);
}

// courses_files
$sql = "select inode_id, content_id from
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']."
where content_type = '1'" ;

$rs = $inicrond_db->Execute($sql);

while ($row = $rs->FetchRow ())
{
        $sql = "update ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['courses_files']."
        set inode_id = ".$row['inode_id']." where file_id = ".$row['content_id']."" ;

        $inicrond_db->Execute($sql);
}

// now, delete content_id + content_type from inode_elements

$sql = "alter table ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']." drop content_id" ;
$inicrond_db->Execute($sql);

$sql = "alter table ".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['inode_elements']." drop content_type" ;
$inicrond_db->Execute($sql);

$query = "
alter table
".$_OPTIONS["table_prefix"].$_OPTIONS['tables']['groups']."
add add_time_t int unsigned
" ;

$inicrond_db->Execute($query);



?>
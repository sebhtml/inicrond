<?php
//$Id: 3.1.7_to_3.2.0.patch.php 8 2005-09-13 17:44:21Z sebhtml $

/*

COpy this file into your root installation directory.
Change the prefix table by doing a mass replace of ooo_

*/ 
define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");

include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";

$sql = "ALTER TABLE `ooo_groups` ADD `is_student_group` ENUM(\"0\",\"1\") NOT NULL, ADD `is_teacher_group` ENUM(\"0\",\"1\") NOT NULL";


$inicrond_db->Execute($sql);

//select all teacher groups.

$query = "SELECT
		group_id
		FROM
		 ooo_groups_cours_for_ensei
		";

		
			
		$rs = $inicrond_db->Execute($query);

		while($fetch_result = $rs->FetchRow())//foreach teacher group, update the is teacher field.
		{
		
		
		$query = "UPDATE
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups"]."
		 SET
		 `is_teacher_group`='1'
		 WHERE
		 group_id=".$fetch_result["group_id"]."";
		 $inicrond_db->Execute($query);
		}
		
//select all student groups.

$query = "SELECT
		group_id
		FROM
		 ooo_groups_cours
		";

			
		$rs = $inicrond_db->Execute($query);

		while($fetch_result = $rs->FetchRow())//foreach teacher group, update the is teacher field.
		{
		$query = "UPDATE
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["groups"]."
		 SET
		 `is_student_group`='1'
		 WHERE
		 group_id=".$fetch_result["group_id"]."";
		$inicrond_db->Execute($query);
		}

		//array of queries.
		$sqls = array();		
$sqls[] = 'DROP TABLE `ooo_groups_actions`, `ooo_groups_cours`, `ooo_groups_cours_for_ensei`';
 

 
  $sqls[] = 'ALTER TABLE `ooo_course_group_in_charge` DROP `course_group_id`';

   
   $sqls[] = ' ALTER TABLE `ooo_course_group_in_charge` ADD `group_in_charge_group_id` INT UNSIGNED NOT NULL ;';
   

 
 $sqls[] = 'ALTER TABLE `ooo_course_group_in_charge` ADD INDEX ( `group_in_charge_group_id` ) ;';
 

 
  $sqls[] = "ALTER TABLE `ooo_answer_ordering` CHANGE `a_checked_flag` `a_checked_flag` ENUM(\"0\",\"1\")";
  

   
    $sqls[] = "ALTER TABLE `ooo_answers` CHANGE `is_good_flag` `is_good_flag` ENUM(\"0\",\"1\") DEFAULT \"0\"";
    

   
     $sqls[] = "ALTER TABLE `ooo_chapitre_media` CHANGE `CHECK_FOR_TEST_LINKAGE` `CHECK_FOR_TEST_LINKAGE` ENUM(\"0\",\"1\") DEFAULT \"1\" NOT NULL";
     

    
    $sqls[] = "ALTER TABLE `ooo_groups` CHANGE `default_pending` `default_pending` ENUM(\"0\",\"1\") DEFAULT \"1\"";
    

       
     $sqls[] = 'ALTER TABLE `ooo_groups_usrs` DROP `usr_pending`';
     
  
   
  $sqls[] = 'ALTER TABLE `ooo_multiple_short_answers` DROP `usr_id`';
  
   $sqls[] = "ALTER TABLE `ooo_online_time` CHANGE `is_online` `is_online` ENUM(\"0\",\"1\") DEFAULT \"1\"";
   
  $sqls[] = 'ALTER TABLE `ooo_online_time` DROP `php_session_id`';
  
$sqls[] = "ALTER TABLE `ooo_questions` CHANGE `q_type` `q_type` ENUM(\"0\",\"1\",\"2\",\"3\") DEFAULT \"0\", CHANGE `a_rand_flag` `a_rand_flag` ENUM(\"0\",\"1\") DEFAULT \"1\", CHANGE `correcting_method` `correcting_method` ENUM(\"0\",\"1\") DEFAULT \"0\"";

 $sqls[] = "ALTER TABLE `ooo_sebhtml_forum_sujets` CHANGE `locked` `locked` ENUM(\"0\",\"1\") DEFAULT \"0\"";
 
 $sqls[] = "ALTER TABLE `ooo_tests` CHANGE `available_results` `available_results` ENUM(\"0\",\"1\") DEFAULT \"0\", CHANGE `available_sheet` `available_sheet` ENUM(\"0\",\"1\") DEFAULT \"0\", CHANGE `q_rand_flag` `q_rand_flag` ENUM(\"0\",\"1\") DEFAULT \"1\", CHANGE `do_you_show_good_answers` `do_you_show_good_answers` ENUM(\"0\",\"1\") DEFAULT \"0\"";
 
 $sqls[] = "ALTER TABLE `ooo_usrs` CHANGE `usr_activation` `usr_activation` ENUM(\"0\",\"1\") DEFAULT \"0\", CHANGE `show_email` `show_email` ENUM(\"0\",\"1\") DEFAULT \"0\", CHANGE `SUID` `SUID` ENUM(\"0\",\"1\") DEFAULT \"0\"";
 
 $sqls[]  = "ALTER TABLE `ooo_chapitre_media` CHANGE `chapitre_media_type` `chapitre_media_type` ENUM(\"1\",\"2\",\"3\") DEFAULT \"1\" NOT NULL";
 
  $sqls[] = "ALTER TABLE `ooo_chapitre_media` COMMENT = \"1 : swf, 2 : img, 3 : txt\"";
  
 $sqls[] = "ALTER TABLE `ooo_groups` COMMENT = \"the formula are in blue master clone\"";
 
 $sqls[] = "ALTER TABLE `ooo_inode_elements` CHANGE `content_type` `content_type` ENUM(\"0\",\"1\",\"2\",\"3\") DEFAULT \"0\"";
 
 $sqls[] = "ALTER TABLE `ooo_inode_elements` COMMENT = \"0 : directory, 1 : file, 2 : test, 3 : media\"";
 
 $sqls[] = "DELETE FROM `ooo_groups` WHERE `group_id` = 1 LIMIT 1;";
$sqls[] = "DELETE FROM `ooo_groups` WHERE `group_id` = 2 LIMIT 1;";

$sqls[] = "ALTER TABLE `ooo_answer_ordering` CHANGE `a_checked_flag` `a_checked_flag` CHAR( 1 )";

$sqls[] = "ALTER TABLE `ooo_answers` CHANGE `is_good_flag` `is_good_flag` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `pts_amount_for_good_answer` `pts_amount_for_good_answer` SMALLINT DEFAULT '1' NOT NULL ,
CHANGE `pts_amount_for_bad_answer` `pts_amount_for_bad_answer` SMALLINT DEFAULT '0' NOT NULL ";



$sqls[] = "ALTER TABLE `ooo_chapitre_media` CHANGE `chapitre_media_type` `chapitre_media_type` CHAR( 1 ) DEFAULT '1' NOT NULL ,
CHANGE `CHECK_FOR_TEST_LINKAGE` `CHECK_FOR_TEST_LINKAGE` CHAR( 1 ) DEFAULT '1' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_courses_files` CHANGE `filesize` `filesize` INT UNSIGNED";
$sqls[] = "ALTER TABLE `ooo_evaluations` CHANGE `available` `available` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `ev_final` `ev_final` CHAR( 1 ) DEFAULT '0' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_groups` CHANGE `default_pending` `default_pending` CHAR( 1 ) DEFAULT '1' NOT NULL ,
CHANGE `final_mark_formula` `final_mark_formula` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `is_student_group` `is_student_group` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `is_teacher_group` `is_teacher_group` CHAR( 1 ) DEFAULT '0' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_inode_elements` CHANGE `content_type` `content_type` CHAR( 1 ) DEFAULT '0'";
$sqls[] = "ALTER TABLE `ooo_online_time` CHANGE `is_online` `is_online` CHAR( 1 ) DEFAULT '1' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_questions` CHANGE `q_type` `q_type` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `a_rand_flag` `a_rand_flag` CHAR( 1 ) DEFAULT '1' NOT NULL ,
CHANGE `correcting_method` `correcting_method` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `good_points` `good_points` SMALLINT DEFAULT '1' NOT NULL ,
CHANGE `bad_points` `bad_points` SMALLINT DEFAULT '0' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_results` CHANGE `max_points` `max_points` SMALLINT UNSIGNED NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_scores` CHANGE `points_max` `points_max` SMALLINT UNSIGNED DEFAULT '0',
CHANGE `points_obtenu` `points_obtenu` SMALLINT UNSIGNED DEFAULT '0'";
$sqls[] = "ALTER TABLE `ooo_sebhtml_forum_messages` CHANGE `forum_message_id` `forum_message_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `forum_sujet_id` `forum_sujet_id` INT UNSIGNED DEFAULT '0' NOT NULL ,
CHANGE `usr_id` `usr_id` INT UNSIGNED DEFAULT '0' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_sebhtml_forum_sections` CHANGE `cours_id` `cours_id` INT UNSIGNED DEFAULT '1' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_sebhtml_forum_sujets` CHANGE `locked` `locked` CHAR( 1 ) DEFAULT '0' NOT NULL
";
$sqls[] = "ALTER TABLE `ooo_tests` CHANGE `available_results` `available_results` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `available_sheet` `available_sheet` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `q_rand_flag` `q_rand_flag` CHAR( 1 ) DEFAULT '1' NOT NULL
";
$sqls[] = "ALTER TABLE `ooo_tests` CHANGE `do_you_show_good_answers` `do_you_show_good_answers` CHAR( 1 ) DEFAULT '0' NOT NULL
";
$sqls[] = "ALTER TABLE `ooo_usrs` CHANGE `usr_activation` `usr_activation` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `show_email` `show_email` CHAR( 1 ) DEFAULT '0' NOT NULL ,
CHANGE `SUID` `SUID` CHAR( 1 ) DEFAULT '0' NOT NULL ";
$sqls[] = "ALTER TABLE `ooo_chapitre_media` ADD INDEX ( `cours_id` ) ";
$sqls[] = "ALTER TABLE `ooo_chapitre_media` DROP INDEX `chapitre_id` ";
$sqls[] = "ALTER TABLE `ooo_multiple_short_answers` CHANGE `pts_amount_for_good_answer` `pts_amount_for_good_answer` SMALLINT DEFAULT '1',
CHANGE `pts_amount_for_bad_answer` `pts_amount_for_bad_answer` SMALLINT DEFAULT '0'
";
$sqls[] = "OPTIMIZE TABLE `ooo_acts_of_downloading` , `ooo_answer_ordering` , `ooo_answers` , `ooo_chapitre_media` , `ooo_cours` , `ooo_course_group_in_charge` , `ooo_courses_files` , `ooo_evaluations` , `ooo_forums_groups_reply` , `ooo_forums_groups_start` , `ooo_forums_groups_view` , `ooo_groups` , `ooo_groups_usrs` , `ooo_inode_elements` , `ooo_inode_groups` , `ooo_media_linkage` , `ooo_multiple_short_answers` , `ooo_online_time` , `ooo_page_views` , `ooo_question_linking` , `ooo_question_ordering` , `ooo_questions` , `ooo_results` , `ooo_scores` , `ooo_sebhtml_forum_discussions` , `ooo_sebhtml_forum_messages` , `ooo_sebhtml_forum_sections` , `ooo_sebhtml_forum_sujets` , `ooo_sebhtml_moderators` , `ooo_sebhtml_options` , `ooo_sections_groups_view` , `ooo_short_answers` , `ooo_smarty_cache_config` , `ooo_tests` , `ooo_user_evaluation_scores` , `ooo_usrs` , `ooo_views_of_threads` ";

$sqls[] = "ALTER TABLE `ooo_groups` ADD `md5_pw_to_join` CHAR( 32 ) NOT NULL ;";
$sqls[] = "INSERT INTO ooo_sebhtml_options (opt_name, opt_value) VALUES ('theme', 'inicrond_default');";
$sqls[] = "
CREATE TABLE ooo_lang_dev (
  id int(10) unsigned NOT NULL auto_increment,
  language varchar(16) NOT NULL default '',
  string varchar(128) NOT NULL default '',
  content text NOT NULL,
  lang_file varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='for edevelopment purpose only, this is use less in productio'  ;
  ";


    
//$sqls[] = "";


  //foreach query, query the query.
  foreach($sqls AS $sql)
  {
   $inicrond_db->Execute($sql);
  }
?>


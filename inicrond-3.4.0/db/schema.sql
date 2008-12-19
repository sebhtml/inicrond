-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3-Debian-1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 17, 2006 at 10:40 PM
-- Server version: 4.1.14
-- PHP Version: 4.3.10-16
-- 
-- Database: `spockcorgis`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_acts_of_downloading`
-- 

CREATE TABLE `ooo_acts_of_downloading` (
  `act_id` int(10) unsigned NOT NULL auto_increment,
  `session_id` int(10) unsigned default NULL,
  `file_id` int(10) unsigned default NULL,
  `gmt_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`act_id`),
  KEY `session_id` (`session_id`),
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4208 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_answer_ordering`
-- 

CREATE TABLE `ooo_answer_ordering` (
  `answer_ordering_id` int(10) unsigned NOT NULL auto_increment,
  `question_ordering_id` int(10) unsigned default NULL,
  `answer_id` int(10) unsigned default NULL,
  `a_order_id` int(10) unsigned default NULL,
  `a_checked_flag` char(1) character set latin1 default NULL,
  PRIMARY KEY  (`answer_ordering_id`),
  KEY `question_ordering_id` (`question_ordering_id`),
  KEY `answer_id` (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=341524 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_answers`
-- 

CREATE TABLE `ooo_answers` (
  `answer_id` int(10) unsigned NOT NULL auto_increment,
  `answer_name` varchar(255) default NULL,
  `question_id` int(10) unsigned default NULL,
  `a_order_id` int(10) unsigned default NULL,
  `is_good_flag` char(1) NOT NULL default '0',
  `pts_amount_for_good_answer` smallint(6) NOT NULL default '1',
  `pts_amount_for_bad_answer` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`answer_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1408 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_chapitre_media`
-- 

CREATE TABLE `ooo_chapitre_media` (
  `chapitre_media_id` int(10) unsigned NOT NULL auto_increment,
  `chapitre_media_title` varchar(128) NOT NULL default '',
  `chapitre_media_description` varchar(255) NOT NULL default '',
  `chapitre_media_width` smallint(5) unsigned default '0',
  `chapitre_media_height` smallint(5) unsigned default '0',
  `chapitre_media_add_gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `chapitre_media_edit_gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `file_name` varchar(255) default NULL,
  `HEXA_TAG` varchar(32) default NULL,
  `inode_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`chapitre_media_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='1 : swf, 2 : img, 3 : txt' AUTO_INCREMENT=231 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_cours`
-- 

CREATE TABLE `ooo_cours` (
  `cours_id` int(10) unsigned NOT NULL auto_increment,
  `cours_code` varchar(16) NOT NULL default '',
  `cours_name` varchar(64) NOT NULL default '',
  `cours_description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_course_group_in_charge`
-- 

CREATE TABLE `ooo_course_group_in_charge` (
  `group_id` int(10) unsigned default NULL,
  `group_in_charge_group_id` int(10) unsigned NOT NULL default '0',
  KEY `group_id` (`group_id`),
  KEY `group_in_charge_group_id` (`group_in_charge_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_courses_files`
-- 

CREATE TABLE `ooo_courses_files` (
  `file_id` int(10) unsigned NOT NULL auto_increment,
  `file_name` varchar(255) default NULL,
  `file_infos` varchar(255) default NULL,
  `file_title` varchar(128) default NULL,
  `md5_sum` varchar(32) default NULL,
  `filesize` int(10) unsigned default NULL,
  `md5_path` varchar(32) default NULL,
  `add_gmt` int(10) unsigned default NULL,
  `edit_gmt` int(10) unsigned default NULL,
  `inode_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`file_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_evaluations`
-- 

CREATE TABLE `ooo_evaluations` (
  `ev_id` int(10) unsigned NOT NULL auto_increment,
  `available` char(1) NOT NULL default '0',
  `ev_name` varchar(64) NOT NULL default '',
  `ev_weight` float unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  `ev_max` float unsigned NOT NULL default '0',
  `comments` varchar(255) NOT NULL default '',
  `ev_final` char(1) NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ev_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_forum_subscription`
-- 

CREATE TABLE `ooo_forum_subscription` (
  `usr_id` int(10) unsigned default NULL,
  `forum_discussion_id` int(10) unsigned default NULL,
  KEY `usr_id` (`usr_id`),
  KEY `forum_discussion_id` (`forum_discussion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_forums_groups_reply`
-- 

CREATE TABLE `ooo_forums_groups_reply` (
  `forum_discussion_id` int(10) unsigned default NULL,
  `group_id` int(10) unsigned default NULL,
  KEY `forum_discussion_id` (`forum_discussion_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_forums_groups_start`
-- 

CREATE TABLE `ooo_forums_groups_start` (
  `forum_discussion_id` int(10) unsigned default NULL,
  `group_id` int(10) unsigned default NULL,
  KEY `forum_discussion_id` (`forum_discussion_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_forums_groups_view`
-- 

CREATE TABLE `ooo_forums_groups_view` (
  `forum_discussion_id` int(10) unsigned default NULL,
  `group_id` int(10) unsigned default NULL,
  KEY `forum_discussion_id` (`forum_discussion_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_groups`
-- 

CREATE TABLE `ooo_groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `group_name` varchar(32) NOT NULL default '',
  `default_pending` char(1) NOT NULL default '1',
  `cours_id` int(10) unsigned NOT NULL default '0',
  `final_mark_formula` char(1) NOT NULL default '0',
  `is_student_group` char(1) NOT NULL default '0',
  `is_teacher_group` char(1) NOT NULL default '0',
  `md5_pw_to_join` varchar(32) NOT NULL default '',
  `add_time_t` int(10) unsigned default NULL,
  PRIMARY KEY  (`group_id`),
  KEY `cours_id` (`cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='the formula are in blue master clone' AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_groups_usrs`
-- 

CREATE TABLE `ooo_groups_usrs` (
  `group_id` int(10) unsigned default NULL,
  `usr_id` int(10) unsigned default NULL,
  KEY `group_id` (`group_id`),
  KEY `usr_id` (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_inicrond_images`
-- 

CREATE TABLE `ooo_inicrond_images` (
  `img_id` int(10) unsigned NOT NULL auto_increment,
  `img_title` varchar(32) NOT NULL default '',
  `img_file_name` varchar(255) NOT NULL default '',
  `img_hexa_path` varchar(32) NOT NULL default '',
  `img_description` text NOT NULL,
  `add_time_t` int(10) unsigned NOT NULL default '0',
  `edit_time_t` int(10) unsigned NOT NULL default '0',
  `inode_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`img_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_inicrond_texts`
-- 

CREATE TABLE `ooo_inicrond_texts` (
  `text_id` int(10) unsigned NOT NULL auto_increment,
  `text_title` varchar(32) NOT NULL default '',
  `text_description` text NOT NULL,
  `add_time_t` int(10) unsigned NOT NULL default '0',
  `edit_time_t` int(10) unsigned NOT NULL default '0',
  `inode_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`text_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_inode_elements`
-- 

CREATE TABLE `ooo_inode_elements` (
  `inode_id` int(10) unsigned NOT NULL auto_increment,
  `inode_id_location` int(10) unsigned default NULL,
  `cours_id` int(10) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`inode_id`),
  KEY `inode_id_location` (`inode_id_location`),
  KEY `cours_id` (`cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='0 : directory, 1 : file, 2 : test, 3 : media' AUTO_INCREMENT=520 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_inode_groups`
-- 

CREATE TABLE `ooo_inode_groups` (
  `group_id` int(10) unsigned default NULL,
  `inode_id` int(10) unsigned default NULL,
  KEY `group_id` (`group_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_java_identifications_on_a_figure`
-- 

CREATE TABLE `ooo_java_identifications_on_a_figure` (
  `inode_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(30) NOT NULL default '',
  `at_random` char(1) NOT NULL default '',
  `available_sheet` char(1) NOT NULL default '',
  `available_result` char(1) NOT NULL default '',
  `image_file_name` varchar(255) NOT NULL default '',
  `file_name_in_uploads` varchar(32) NOT NULL default '',
  `add_time_t` int(10) unsigned NOT NULL default '0',
  `edit_time_t` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_java_identifications_on_a_figure_label`
-- 

CREATE TABLE `ooo_java_identifications_on_a_figure_label` (
  `java_identifications_on_a_figure_label_id` int(10) unsigned NOT NULL auto_increment,
  `inode_id` int(10) unsigned NOT NULL default '0',
  `label_name` varchar(30) NOT NULL default '',
  `x_position` smallint(5) unsigned NOT NULL default '0',
  `y_position` smallint(5) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`java_identifications_on_a_figure_label_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_java_identifications_on_a_figure_result`
-- 

CREATE TABLE `ooo_java_identifications_on_a_figure_result` (
  `inode_id` int(10) unsigned NOT NULL default '0',
  `java_identifications_on_a_figure_result_id` int(10) unsigned NOT NULL auto_increment,
  `usr_id` int(10) unsigned NOT NULL default '0',
  `time_t` int(10) unsigned NOT NULL default '0',
  KEY `inode_id` (`inode_id`),
  KEY `java_identifications_on_a_figure_result_id` (`java_identifications_on_a_figure_result_id`),
  KEY `usr_id` (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_java_identifications_on_a_figure_result_association`
-- 

CREATE TABLE `ooo_java_identifications_on_a_figure_result_association` (
  `java_identifications_on_a_figure_result_id` int(10) unsigned NOT NULL default '0',
  `java_identifications_on_a_figure_label_id_source` int(10) unsigned NOT NULL default '0',
  `java_identifications_on_a_figure_label_id_destination` int(10) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned NOT NULL default '0',
  KEY `java_identifications_on_a_figure_result_id` (`java_identifications_on_a_figure_result_id`),
  KEY `java_identifications_on_a_figure_label_id_source` (`java_identifications_on_a_figure_label_id_source`),
  KEY `java_identifications_on_a_figure_label_id_destination` (`java_identifications_on_a_figure_label_id_destination`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_media_linkage`
-- 

CREATE TABLE `ooo_media_linkage` (
  `question_ordering_id` int(10) unsigned default NULL,
  `score_id` int(10) unsigned default '0',
  KEY `question_ordering_id` (`question_ordering_id`),
  KEY `score_id` (`score_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_multiple_short_answers`
-- 

CREATE TABLE `ooo_multiple_short_answers` (
  `short_answer_id` int(10) unsigned NOT NULL auto_increment,
  `short_answer_name` text,
  `question_id` int(10) unsigned default NULL,
  `pts_amount_for_good_answer` smallint(6) default '1',
  `pts_amount_for_bad_answer` smallint(6) default '0',
  PRIMARY KEY  (`short_answer_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=441 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_new_password_secure_str`
-- 

CREATE TABLE `ooo_new_password_secure_str` (
  `usr_id` int(10) unsigned default NULL,
  `new_password_secure_str` varchar(32) default NULL,
  KEY `usr_id` (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_online_time`
-- 

CREATE TABLE `ooo_online_time` (
  `session_id` int(10) unsigned NOT NULL auto_increment,
  `usr_id` int(10) unsigned NOT NULL default '0',
  `start_gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `end_gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `dns` varchar(128) NOT NULL default '',
  `is_online` char(1) NOT NULL default '1',
  `HTTP_USER_AGENT` varchar(255) default NULL,
  `REMOTE_ADDR` varchar(16) NOT NULL default '',
  `cours_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `usr_id` (`usr_id`),
  KEY `cours_id` (`cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=14041 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_page_views`
-- 

CREATE TABLE `ooo_page_views` (
  `page_id` int(10) unsigned NOT NULL auto_increment,
  `session_id` int(10) unsigned NOT NULL default '0',
  `gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `requested_url` varchar(255) default NULL,
  `usr_page_title` varchar(255) default NULL,
  `REMOTE_PORT` varchar(6) NOT NULL default '',
  `generate_delta_time` float default NULL,
  `HTTP_KEEP_ALIVE` varchar(32) NOT NULL default '',
  `HTTP_CONNECTION` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`page_id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_question_linking`
-- 

CREATE TABLE `ooo_question_linking` (
  `test_id` int(10) unsigned default NULL,
  `question_id` int(10) unsigned default NULL,
  `q_order_id` int(10) unsigned default NULL,
  KEY `test_id` (`test_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_question_ordering`
-- 

CREATE TABLE `ooo_question_ordering` (
  `question_ordering_id` int(10) unsigned NOT NULL auto_increment,
  `result_id` int(10) unsigned default NULL,
  `question_id` int(10) unsigned default NULL,
  `q_order_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`question_ordering_id`),
  KEY `result_id` (`result_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=406849 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_questions`
-- 

CREATE TABLE `ooo_questions` (
  `question_id` int(10) unsigned NOT NULL auto_increment,
  `question_name` text,
  `q_type` char(1) NOT NULL default '0',
  `short_answer` varchar(255) default NULL,
  `chapitre_media_id` int(10) unsigned default NULL,
  `a_rand_flag` char(1) NOT NULL default '1',
  `correcting_method` char(1) NOT NULL default '0',
  `good_points` smallint(6) NOT NULL default '1',
  `bad_points` smallint(6) NOT NULL default '0',
  `cours_id` int(10) unsigned NOT NULL default '0',
  `question_CODE` varchar(8) NOT NULL default '',
  PRIMARY KEY  (`question_id`),
  KEY `cours_id` (`cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1681 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_register_random_validation`
-- 

CREATE TABLE `ooo_register_random_validation` (
  `usr_id` int(10) unsigned default NULL,
  `register_random_validation` varchar(32) default NULL,
  KEY `usr_id` (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_results`
-- 

CREATE TABLE `ooo_results` (
  `result_id` int(10) unsigned NOT NULL auto_increment,
  `session_id` int(10) unsigned default NULL,
  `time_GMT_start` int(10) unsigned default NULL,
  `time_GMT_end` int(10) unsigned default NULL,
  `test_id` int(10) unsigned default NULL,
  `your_points` float default NULL,
  `max_points` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`result_id`),
  KEY `session_id` (`session_id`),
  KEY `test_id` (`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=19440 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_scores`
-- 

CREATE TABLE `ooo_scores` (
  `score_id` int(10) unsigned NOT NULL auto_increment,
  `session_id` int(10) unsigned default NULL,
  `points_max` smallint(5) unsigned default '0',
  `points_obtenu` smallint(5) unsigned default '0',
  `chapitre_media_id` int(10) unsigned default NULL,
  `time_stamp_start` int(10) unsigned default NULL,
  `time_stamp_end` int(10) unsigned default NULL,
  `secure_str` char(32) default NULL,
  PRIMARY KEY  (`score_id`),
  KEY `session_id` (`session_id`),
  KEY `chapitre_media_id` (`chapitre_media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=55478 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sebhtml_forum_discussions`
-- 

CREATE TABLE `ooo_sebhtml_forum_discussions` (
  `forum_discussion_id` int(10) unsigned NOT NULL auto_increment,
  `forum_discussion_name` varchar(64) NOT NULL default '',
  `forum_discussion_description` varchar(255) NOT NULL default '',
  `forum_section_id` int(10) unsigned NOT NULL default '0',
  `order_id` int(10) unsigned default '0',
  PRIMARY KEY  (`forum_discussion_id`),
  KEY `forum_section_id` (`forum_section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sebhtml_forum_messages`
-- 

CREATE TABLE `ooo_sebhtml_forum_messages` (
  `forum_message_id` int(10) unsigned NOT NULL auto_increment,
  `forum_sujet_id` int(10) unsigned NOT NULL default '0',
  `usr_id` int(10) unsigned NOT NULL default '0',
  `forum_message_titre` varchar(64) NOT NULL default '',
  `forum_message_contenu` text NOT NULL,
  `forum_message_add_gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `forum_message_edit_gmt_timestamp` int(10) unsigned NOT NULL default '0',
  `forum_message_id_reply_to` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`forum_message_id`),
  KEY `forum_sujet_id` (`forum_sujet_id`),
  KEY `usr_id` (`usr_id`),
  KEY `forum_message_id_reply_to` (`forum_message_id_reply_to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=307 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sebhtml_forum_sections`
-- 

CREATE TABLE `ooo_sebhtml_forum_sections` (
  `forum_section_id` int(10) unsigned NOT NULL auto_increment,
  `forum_section_name` varchar(64) NOT NULL default '',
  `order_id` int(10) unsigned default '0',
  `cours_id` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`forum_section_id`),
  KEY `cours_id` (`cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sebhtml_forum_sujets`
-- 

CREATE TABLE `ooo_sebhtml_forum_sujets` (
  `forum_sujet_id` int(10) unsigned NOT NULL auto_increment,
  `forum_discussion_id` int(10) unsigned NOT NULL default '0',
  `locked` char(1) character set latin1 NOT NULL default '0',
  PRIMARY KEY  (`forum_sujet_id`),
  KEY `forum_discussion_id` (`forum_discussion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=159 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sebhtml_moderators`
-- 

CREATE TABLE `ooo_sebhtml_moderators` (
  `forum_discussion_id` int(10) unsigned default NULL,
  `group_id` int(10) unsigned default NULL,
  KEY `forum_discussion_id` (`forum_discussion_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sebhtml_options`
-- 

CREATE TABLE `ooo_sebhtml_options` (
  `opt_name` varchar(64) default NULL,
  `opt_value` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_sections_groups_view`
-- 

CREATE TABLE `ooo_sections_groups_view` (
  `forum_section_id` int(10) unsigned default NULL,
  `group_id` int(10) unsigned default NULL,
  KEY `forum_section_id` (`forum_section_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_short_answers`
-- 

CREATE TABLE `ooo_short_answers` (
  `question_ordering_id` int(10) unsigned default NULL,
  `short_answer` varchar(255) default NULL,
  KEY `question_ordering_id` (`question_ordering_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_smarty_cache_config`
-- 

CREATE TABLE `ooo_smarty_cache_config` (
  `mod_dir` varchar(32) default NULL,
  `tpl_file` varchar(32) default NULL,
  `cache_lifetime` int(10) unsigned default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_tests`
-- 

CREATE TABLE `ooo_tests` (
  `test_id` int(10) unsigned NOT NULL auto_increment,
  `test_name` varchar(128) default NULL,
  `test_info` varchar(255) default NULL,
  `available_results` char(1) NOT NULL default '0',
  `available_sheet` char(1) NOT NULL default '0',
  `q_rand_flag` char(1) NOT NULL default '1',
  `do_you_show_good_answers` char(1) NOT NULL default '0',
  `time_GMT_add` int(10) unsigned NOT NULL default '0',
  `time_GMT_edit` int(10) unsigned NOT NULL default '0',
  `inode_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`test_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_thread_subscription`
-- 

CREATE TABLE `ooo_thread_subscription` (
  `usr_id` int(10) unsigned default NULL,
  `forum_sujet_id` int(10) unsigned default NULL,
  KEY `usr_id` (`usr_id`),
  KEY `forum_sujet_id` (`forum_sujet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_user_evaluation_scores`
-- 

CREATE TABLE `ooo_user_evaluation_scores` (
  `ev_id` int(10) unsigned NOT NULL default '0',
  `usr_id` int(10) unsigned NOT NULL default '0',
  `ev_score` float unsigned NOT NULL default '0',
  `comments` varchar(255) NOT NULL default '',
  KEY `usr_id` (`usr_id`),
  KEY `ev_id` (`ev_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_usrs`
-- 

CREATE TABLE `ooo_usrs` (
  `usr_id` int(10) unsigned NOT NULL auto_increment,
  `usr_name` varchar(16) NOT NULL default '',
  `language` varchar(8) default 'fr-ca',
  `usr_time_decal` float default '-5',
  `usr_md5_password` varchar(32) NOT NULL default '',
  `usr_add_gmt_timestamp` int(10) unsigned default NULL,
  `usr_activation` char(1) NOT NULL default '0',
  `usr_email` varchar(64) default NULL,
  `usr_prenom` varchar(64) default NULL,
  `usr_nom` varchar(64) default NULL,
  `usr_signature` varchar(255) default NULL,
  `show_email` char(1) NOT NULL default '0',
  `SUID` char(1) NOT NULL default '0',
  `usr_number` varchar(16) NOT NULL default '',
  `usr_picture_file_name` varchar(32) default 'default1',
  PRIMARY KEY  (`usr_id`),
  UNIQUE KEY `usr_name` (`usr_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=338 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_views_of_threads`
-- 

CREATE TABLE `ooo_views_of_threads` (
  `forum_sujet_id` int(10) unsigned default NULL,
  `gmt_timestamp` int(10) unsigned default NULL,
  `usr_id` int(10) unsigned NOT NULL default '0',
  KEY `forum_sujet_id` (`forum_sujet_id`),
  KEY `usr_id` (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_virtual_directories`
-- 

CREATE TABLE `ooo_virtual_directories` (
  `dir_id` int(10) unsigned NOT NULL auto_increment,
  `dir_name` varchar(64) default NULL,
  `inode_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`dir_id`),
  KEY `inode_id` (`inode_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

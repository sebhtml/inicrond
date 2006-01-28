#$Id$

-- 
-- Table structure for table `ooo_tests`
-- 

CREATE TABLE tests (
  test_id int(10) unsigned NOT NULL auto_increment,
  test_name varchar(128) default NULL,
  test_info varchar(255) default NULL,
  available_results char(1) NOT NULL default '0',
  available_sheet char(1) NOT NULL default '0',
  q_rand_flag char(1) NOT NULL default '1',
  do_you_show_good_answers char(1) NOT NULL default '0',
  time_GMT_add int(10) unsigned NOT NULL default '0',
  time_GMT_edit int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (test_id),
  inode_id int unsigned,
  key inode_id (inode_id)
  ) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_short_answers`
-- 

CREATE TABLE short_answers (
  question_ordering_id int(10) unsigned default NULL,
  short_answer varchar(255) default NULL,
  KEY question_ordering_id (question_ordering_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------


-- 
-- Table structure for table `ooo_questions`
-- 

CREATE TABLE questions (
  question_id int(10) unsigned NOT NULL auto_increment,
  question_name text,
  q_type char(1) NOT NULL default '0',
  short_answer varchar(255) default NULL,
  chapitre_media_id int(10) unsigned default NULL,
  a_rand_flag char(1) NOT NULL default '1',
  correcting_method char(1) NOT NULL default '0',
  good_points smallint(6) NOT NULL default '1',
  bad_points smallint(6) NOT NULL default '0',
  cours_id int(10) unsigned NOT NULL default '0',
  question_CODE varchar(8) NOT NULL default '',
  PRIMARY KEY  (question_id),
  KEY cours_id (cours_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_question_linking`
-- 

CREATE TABLE question_linking (
  test_id int(10) unsigned default NULL,
  question_id int(10) unsigned default NULL,
  q_order_id int(10) unsigned default NULL,
  KEY test_id (test_id),
  KEY question_id (question_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_multiple_short_answers`
-- 

CREATE TABLE multiple_short_answers (
  short_answer_id int(10) unsigned NOT NULL auto_increment,
  short_answer_name text,
  question_id int(10) unsigned default NULL,
  pts_amount_for_good_answer smallint(6) default '1',
  pts_amount_for_bad_answer smallint(6) default '0',
  PRIMARY KEY  (short_answer_id),
  KEY question_id (question_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_media_linkage`
-- 

CREATE TABLE media_linkage (
  question_ordering_id int(10) unsigned default NULL,
  score_id int(10) unsigned default '0',
  KEY question_ordering_id (question_ordering_id),
  KEY score_id (score_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_answers`
-- 

CREATE TABLE answers (
  answer_id int(10) unsigned NOT NULL auto_increment,
  answer_name varchar(255) default NULL,
  question_id int(10) unsigned default NULL,
  a_order_id int(10) unsigned default NULL,
  is_good_flag char(1) NOT NULL default '0',
  pts_amount_for_good_answer smallint(6) NOT NULL default '1',
  pts_amount_for_bad_answer smallint(6) NOT NULL default '0',
  PRIMARY KEY  (answer_id),
  KEY question_id (question_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------


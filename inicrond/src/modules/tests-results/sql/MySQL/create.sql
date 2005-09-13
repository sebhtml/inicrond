#$Id$


-- 
-- Table structure for table `ooo_results`
-- 

CREATE TABLE results (
  result_id int(10) unsigned NOT NULL auto_increment,
  session_id int(10) unsigned default NULL,
  usr_id int(10) unsigned default NULL,
  time_GMT_start int(10) unsigned default NULL,
  time_GMT_end int(10) unsigned default NULL,
  test_id int(10) unsigned default NULL,
  your_points float default NULL,
  max_points smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (result_id),
  KEY session_id (session_id),
  KEY usr_id (usr_id),
  KEY test_id (test_id)
) TYPE=MyISAM;

-- --------------------------------------------------------



-- 
-- Table structure for table `ooo_question_ordering`
-- 

CREATE TABLE question_ordering (
  question_ordering_id int(10) unsigned NOT NULL auto_increment,
  result_id int(10) unsigned default NULL,
  question_id int(10) unsigned default NULL,
  q_order_id int(10) unsigned default NULL,
  PRIMARY KEY  (question_ordering_id),
  KEY result_id (result_id),
  KEY question_id (question_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


-- 
-- Table structure for table `ooo_answer_ordering`
-- 

CREATE TABLE answer_ordering (
  answer_ordering_id int(10) unsigned NOT NULL auto_increment,
  question_ordering_id int(10) unsigned default NULL,
  answer_id int(10) unsigned default NULL,
  a_order_id int(10) unsigned default NULL,
  a_checked_flag char(1) default NULL,
  PRIMARY KEY  (answer_ordering_id),
  KEY question_ordering_id (question_ordering_id),
  KEY answer_id (answer_id)
) TYPE=MyISAM;

-- --------------------------------------------------------



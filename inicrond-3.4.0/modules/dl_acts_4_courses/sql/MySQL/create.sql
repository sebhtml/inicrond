#$Id: create.sql 122 2006-01-28 15:56:48Z sebhtml $

-- 
-- Table structure for table `ooo_acts_of_downloading`
-- 

CREATE TABLE acts_of_downloading (
  act_id int(10) unsigned NOT NULL auto_increment,
  session_id int(10) unsigned default NULL,
  file_id int(10) unsigned default NULL,
  gmt_ts int(10) unsigned default NULL,
  PRIMARY KEY  (act_id),
  KEY session_id (session_id),
  KEY file_id (file_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

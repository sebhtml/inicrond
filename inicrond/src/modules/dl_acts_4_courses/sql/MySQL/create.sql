#$Id$

-- 
-- Table structure for table `ooo_acts_of_downloading`
-- 

CREATE TABLE acts_of_downloading (
  act_id int(10) unsigned NOT NULL auto_increment,
  usr_id int(10) unsigned default NULL,
  session_id int(10) unsigned default NULL,
  file_id int(10) unsigned default NULL,
  gmt_ts int(10) unsigned default NULL,
  PRIMARY KEY  (act_id),
  KEY usr_id (usr_id),
  KEY session_id (session_id),
  KEY file_id (file_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

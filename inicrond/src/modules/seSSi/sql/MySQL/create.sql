#$Id$



-- 
-- Table structure for table `ooo_online_time`
-- 

CREATE TABLE online_time (
  session_id int(10) unsigned NOT NULL auto_increment,
  usr_id int(10) unsigned NOT NULL default '0',
  start_gmt_timestamp int(10) unsigned NOT NULL default '0',
  end_gmt_timestamp int(10) unsigned NOT NULL default '0',
  dns varchar(128) NOT NULL default '',
  is_online char(1) NOT NULL default '1',
  HTTP_USER_AGENT varchar(255) default NULL,
  REMOTE_ADDR varchar(16) NOT NULL default '',
  cours_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (session_id),
  KEY usr_id (usr_id),
  KEY cours_id (cours_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_page_views`
-- 

CREATE TABLE page_views (
  page_id int(10) unsigned NOT NULL auto_increment,
  session_id int(10) unsigned NOT NULL default '0',
  gmt_timestamp int(10) unsigned NOT NULL default '0',
  requested_url varchar(255) default NULL,
  usr_page_title varchar(255) default NULL,
  REMOTE_PORT varchar(6) NOT NULL default '',
  generate_delta_time float default NULL,
  HTTP_KEEP_ALIVE varchar(32) NOT NULL default '',
  HTTP_CONNECTION varchar(255) NOT NULL default '',
  PRIMARY KEY  (page_id),
  KEY session_id (session_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


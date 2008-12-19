#$Id: create.sql 122 2006-01-28 15:56:48Z sebhtml $

-- 
-- Table structure for table `ooo_user_evaluation_scores`
-- 

CREATE TABLE user_evaluation_scores (
  ev_id int(10) unsigned NOT NULL default '0',
  usr_id int(10) unsigned NOT NULL default '0',
  ev_score float unsigned NOT NULL default '0',
  comments varchar(255) NOT NULL default '',
  KEY usr_id (usr_id),
  KEY ev_id (ev_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_evaluations`
-- 

CREATE TABLE evaluations (
  ev_id int(10) unsigned NOT NULL auto_increment,
  available char(1) NOT NULL default '0',
  ev_name varchar(64) NOT NULL default '',
  ev_weight float unsigned NOT NULL default '0',
  group_id int(10) unsigned NOT NULL default '0',
  ev_max float unsigned NOT NULL default '0',
  comments varchar(255) NOT NULL default '',
  ev_final char(1) NOT NULL default '0',
  order_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (ev_id),
  KEY group_id (group_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

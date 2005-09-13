#$Id$

-- 
-- Table structure for table `ooo_courses_files`
-- 

CREATE TABLE courses_files (
  file_id int(10) unsigned NOT NULL auto_increment,
  file_name varchar(255) default NULL,
  file_infos varchar(255) default NULL,
  file_title varchar(128) default NULL,
  cours_id int(10) unsigned NOT NULL default '0',
  md5_sum varchar(32) default NULL,
  filesize int(10) unsigned default NULL,
  md5_path varchar(32) default NULL,
  add_gmt int(10) unsigned default NULL,
  edit_gmt int(10) unsigned default NULL,
  PRIMARY KEY  (file_id),
  KEY cours_id (cours_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


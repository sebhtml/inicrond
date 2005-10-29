#$Id$

-- 
-- Table structure for table `ooo_inode_elements`
-- 

CREATE TABLE inode_elements (
  inode_id int(10) unsigned NOT NULL auto_increment,
  inode_id_location int(10) unsigned default NULL,
  content_type char(1) default '0',
  content_id int(10) unsigned default NULL,
  cours_id int(10) unsigned NOT NULL default '0',
  order_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (inode_id),
  KEY inode_id_location (inode_id_location),
  KEY content_id (content_id),
  KEY cours_id (cours_id)
) TYPE=MyISAM ;

-- --------------------------------------------------------
-- 
-- Table structure for table `ooo_virtual_directories`
-- 

CREATE TABLE virtual_directories (
  dir_id int(10) unsigned NOT NULL auto_increment,
  dir_name varchar(64) default '',
  PRIMARY KEY  (dir_id)
) TYPE=MyISAM;


-- --------------------------------------------------------

-- 
-- Table structure for table `ooo_cours`
-- 

CREATE TABLE cours (
  cours_id int(10) unsigned NOT NULL auto_increment,
  cours_code varchar(16) NOT NULL default '',
  cours_name varchar(64) NOT NULL default '',
  cours_description varchar(255) NOT NULL default '',
  PRIMARY KEY  (cours_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


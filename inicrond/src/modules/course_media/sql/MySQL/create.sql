#$Id$

-- 
-- Table structure for table `ooo_chapitre_media`
-- 

CREATE TABLE chapitre_media (
  chapitre_media_id int(10) unsigned NOT NULL auto_increment,
  chapitre_media_title varchar(128) NOT NULL default '',
  chapitre_media_description varchar(255) NOT NULL default '',
  chapitre_media_width smallint(5) unsigned default '0',
  chapitre_media_height smallint(5) unsigned default '0',
  chapitre_media_add_gmt_timestamp int(10) unsigned NOT NULL default '0',
  chapitre_media_edit_gmt_timestamp int(10) unsigned NOT NULL default '0',
  file_name varchar(255) default NULL,
  HEXA_TAG varchar(32) default NULL,
  PRIMARY KEY  (chapitre_media_id)
) TYPE=MyISAM ;
        
-- 
-- Table structure for table `ooo_inicrond_images`
-- 

CREATE TABLE inicrond_images (
  img_id int(10) unsigned NOT NULL auto_increment,
  img_title varchar(32) NOT NULL default '',
  img_file_name varchar(255) NOT NULL default '',
  img_hexa_path varchar(32) NOT NULL default '',
  img_description text NOT NULL,
  add_time_t int(10) unsigned NOT NULL default '0',
  edit_time_t int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (img_id)
) TYPE=MyISAM;

-- 
-- Table structure for table `ooo_inicrond_texts`
-- 

CREATE TABLE inicrond_texts (
  text_id int(10) unsigned NOT NULL auto_increment,
  text_title varchar(32) NOT NULL default '',
  text_description text NOT NULL,
  add_time_t int(10) unsigned NOT NULL default '0',
  edit_time_t int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (text_id)
) TYPE=MyISAM;
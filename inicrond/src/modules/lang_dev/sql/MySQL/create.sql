-- 
-- Table structure for table `ooo_lang_dev`
-- 

CREATE TABLE lang_dev (
  id int(10) unsigned NOT NULL auto_increment,
  language varchar(16) NOT NULL default '',
  string varchar(128) NOT NULL default '',
  content text NOT NULL,
  lang_file varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='for edevelopment purpose only, this is use less in productio' ;
        
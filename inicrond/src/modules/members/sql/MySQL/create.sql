#$Id$

-- 
-- Table structure for table `ooo_usrs`
-- 

CREATE TABLE usrs (
  usr_id int(10) unsigned NOT NULL auto_increment,
  usr_name varchar(16) NOT NULL default '',
  language varchar(8) default 'fr-ca',
  usr_time_decal float default '-5',
  usr_md5_password varchar(32) NOT NULL default '',
  usr_add_gmt_timestamp int(10) unsigned default NULL,
  usr_activation char(1) NOT NULL default '0',
  usr_email varchar(64) default NULL,
  usr_prenom varchar(64) default NULL,
  usr_nom varchar(64) default NULL,
  usr_signature varchar(255) default NULL,
  show_email char(1) NOT NULL default '0',
  SUID char(1) NOT NULL default '0',
  usr_number varchar(16) NOT NULL default '',
  usr_picture_file_name varchar(32) default 'default1',

  PRIMARY KEY  (usr_id),
  UNIQUE KEY usr_name (usr_name)
) TYPE=MyISAM;

-- --------------------------------------------------------

create table register_random_validation (
	usr_id int unsigned,
	register_random_validation varchar(32) default NULL,
	key usr_id (usr_id)
) ;

create table new_password_secure_str (
	usr_id int unsigned,
	new_password_secure_str varchar(32) default NULL,
	key usr_id (usr_id)
) ;


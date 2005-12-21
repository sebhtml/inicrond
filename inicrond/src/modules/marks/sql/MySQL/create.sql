#$Id$



-- 
-- Table structure for table `ooo_scores`
-- 

CREATE TABLE scores (
  score_id int(10) unsigned NOT NULL auto_increment,
  session_id int(10) unsigned default NULL,
  points_max smallint(5) unsigned default '0',
  points_obtenu smallint(5) unsigned default '0',
  chapitre_media_id int(10) unsigned default NULL,
  time_stamp_start int(10) unsigned default NULL,
  time_stamp_end int(10) unsigned default NULL,
  secure_str char(32) default NULL,
  PRIMARY KEY  (score_id),
  KEY session_id (session_id),
  KEY chapitre_media_id (chapitre_media_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

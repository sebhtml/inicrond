#$Id$

--
-- Table structure for table `ooo_inode_groups`
--

CREATE TABLE inode_groups (
  group_id int(10) unsigned default NULL,
  inode_id int(10) unsigned default NULL,
  KEY group_id (group_id),
  KEY inode_id (inode_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------




--
-- Table structure for table `ooo_groups`
--

CREATE TABLE groups (
  group_id int(10) unsigned NOT NULL auto_increment,
  group_name varchar(32) NOT NULL default '',
  default_pending char(1) NOT NULL default '1',
  cours_id int(10) unsigned NOT NULL default '0',
  final_mark_formula char(1) NOT NULL default '0',
  is_student_group char(1) NOT NULL default '0',
  is_teacher_group char(1) NOT NULL default '0',
  md5_pw_to_join varchar(32) NOT NULL default '',
  add_time_t int unsigned,
  PRIMARY KEY  (group_id),
  KEY cours_id (cours_id)
) CHARSET=utf8  TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_groups_usrs`
--

CREATE TABLE groups_usrs (
  group_id int(10) unsigned default NULL,
  usr_id int(10) unsigned default NULL,
  KEY group_id (group_id),
  KEY usr_id (usr_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_course_group_in_charge`
--

CREATE TABLE course_group_in_charge (
  group_id int(10) unsigned default NULL,
  group_in_charge_group_id int(10) unsigned NOT NULL default '0',
  KEY group_id (group_id),
  KEY group_in_charge_group_id (group_in_charge_group_id)
) CHARSET=utf8  TYPE=MyISAM;

-- --------------------------------------------------------


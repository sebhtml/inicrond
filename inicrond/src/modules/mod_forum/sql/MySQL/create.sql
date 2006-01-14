# $Id$


CREATE TABLE forum_subscription (
  usr_id int(10) unsigned default NULL,
  forum_discussion_id int(10) unsigned default NULL,
  KEY usr_id (usr_id),
  KEY forum_discussion_id (forum_discussion_id)
) TYPE=MyISAM;

CREATE TABLE thread_subscription (
  usr_id int(10) unsigned default NULL,
  forum_sujet_id int(10) unsigned default NULL,
  KEY usr_id (usr_id),
  KEY forum_sujet_id (forum_sujet_id)
) TYPE=MyISAM;


--
-- Table structure for table `ooo_sections_groups_view`
--

CREATE TABLE sections_groups_view (
  forum_section_id int(10) unsigned default NULL,
  group_id int(10) unsigned default NULL,
  KEY forum_section_id (forum_section_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_sebhtml_moderators`
--

CREATE TABLE sebhtml_moderators (
  forum_discussion_id int(10) unsigned default NULL,
  group_id int(10) unsigned default NULL,
  KEY forum_discussion_id (forum_discussion_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


--
-- Table structure for table `ooo_sebhtml_forum_discussions`
--

CREATE TABLE sebhtml_forum_discussions (
  forum_discussion_id int(10) unsigned NOT NULL auto_increment,
  forum_discussion_name varchar(64) NOT NULL default '',
  forum_discussion_description varchar(255) NOT NULL default '',
  forum_section_id int(10) unsigned NOT NULL default '0',
  order_id int(10) unsigned default '0',
  PRIMARY KEY  (forum_discussion_id),
  KEY forum_section_id (forum_section_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_sebhtml_forum_messages`
--

CREATE TABLE sebhtml_forum_messages (
  forum_message_id int(10) unsigned NOT NULL auto_increment,
  forum_sujet_id int(10) unsigned NOT NULL default '0',
  usr_id int(10) unsigned NOT NULL default '0',
  forum_message_titre varchar(64) NOT NULL default '',
  forum_message_contenu text NOT NULL,
  forum_message_add_gmt_timestamp int(10) unsigned NOT NULL default '0',
  forum_message_edit_gmt_timestamp int(10) unsigned NOT NULL default '0',
  forum_message_id_reply_to int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (forum_message_id),
  KEY forum_sujet_id (forum_sujet_id),
  KEY usr_id (usr_id),
  KEY forum_message_id_reply_to (forum_message_id_reply_to)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_sebhtml_forum_sections`
--

CREATE TABLE sebhtml_forum_sections (
  forum_section_id int(10) unsigned NOT NULL auto_increment,
  forum_section_name varchar(64) NOT NULL default '',
  order_id int(10) unsigned default '0',
  cours_id int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (forum_section_id),
  KEY cours_id (cours_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_sebhtml_forum_sujets`
--

CREATE TABLE sebhtml_forum_sujets (
  forum_sujet_id int(10) unsigned NOT NULL auto_increment,
  forum_discussion_id int(10) unsigned NOT NULL default '0',
  locked char(1) NOT NULL default '0',
  PRIMARY KEY  (forum_sujet_id),
  KEY forum_discussion_id (forum_discussion_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


--
-- Table structure for table `ooo_views_of_threads`
--

CREATE TABLE views_of_threads (
  forum_sujet_id int(10) unsigned default NULL,
  gmt_timestamp int(10) unsigned default NULL,
  usr_id int(10) unsigned NOT NULL default '0',
  KEY forum_sujet_id (forum_sujet_id),
  KEY usr_id (usr_id)
) TYPE=MyISAM;


--
-- Table structure for table `ooo_forums_groups_reply`
--

CREATE TABLE forums_groups_reply (
  forum_discussion_id int(10) unsigned default NULL,
  group_id int(10) unsigned default NULL,
  KEY forum_discussion_id (forum_discussion_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_forums_groups_start`
--

CREATE TABLE forums_groups_start (
  forum_discussion_id int(10) unsigned default NULL,
  group_id int(10) unsigned default NULL,
  KEY forum_discussion_id (forum_discussion_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `ooo_forums_groups_view`
--

CREATE TABLE forums_groups_view (
  forum_discussion_id int(10) unsigned default NULL,
  group_id int(10) unsigned default NULL,
  KEY forum_discussion_id (forum_discussion_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

-- --------------------------------------------------------


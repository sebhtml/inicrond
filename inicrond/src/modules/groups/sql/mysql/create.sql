# $Id$

#
# Table structure for table 'sebhtml_groups'
#

CREATE TABLE sebhtml_groups (
group_id SMALLINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY(group_id),

group_name VARCHAR(255) NOT NULL,

description TEXT DEFAULT '',

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id)
)TYPE=MyISAM;

#
# Table structure for table 'sebhtml_groups_usrs '
#

CREATE TABLE sebhtml_groups_usrs  (
group_id SMALLINT UNSIGNED,
KEY group_id (group_id),

usr_id BIGINT UNSIGNED,
KEY usr_id (usr_id),

usr_pending TINYINT UNSIGNED DEFAULT 1
)TYPE=MyISAM;
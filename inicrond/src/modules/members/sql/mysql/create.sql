
# $Id$


#
# Table structure for table 'sebhtml_usrs'
#

CREATE TABLE sebhtml_usrs (
usr_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (usr_id),
usr_name VARCHAR(16) NOT NULL,

usr_md5_password VARCHAR(255) NOT NULL,


usr_add_gmt_timestamp BIGINT UNSIGNED DEFAULT 0,

usr_activation TINYINT UNSIGNED DEFAULT 1,
usr_deletable TINYINT UNSIGNED DEFAULT 1,
usr_ban_warning TINYINT UNSIGNED DEFAULT 0,

usr_time_decal FLOAT DEFAULT -8,

usr_communication_language CHAR(2) DEFAULT 'fr',

usr_localisation VARCHAR(255) DEFAULT '',
usr_web_site VARCHAR(255) DEFAULT '',
usr_job VARCHAR(255) DEFAULT '',
usr_hobbies VARCHAR(255) DEFAULT '',
usr_email VARCHAR(255) DEFAULT '',
usr_status VARCHAR(255) DEFAULT '',
usr_signature VARCHAR(255) DEFAULT '',

show_email TINYINT UNSIGNED DEFAULT 0

)TYPE=MyISAM;


#--------------------------------------------------------------------------------------------------------------
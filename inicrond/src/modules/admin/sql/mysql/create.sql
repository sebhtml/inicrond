# $Id$

#
# Table structure for table 'sebhtml_options '
#

CREATE TABLE sebhtml_options  (


news_forum_discussion_id SMALLINT UNSIGNED,


usr_time_decal FLOAT,

language CHAR(2),


preg_email VARCHAR(255),

preg_usr VARCHAR(255),

titre VARCHAR(255),

separator VARCHAR(255),

preg_agent VARCHAR(255),

header_txt TEXT NOT NULL,

footer_txt TEXT NOT NULL
)TYPE=MyISAM;



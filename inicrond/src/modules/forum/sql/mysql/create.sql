# $Id$




#
# Table structure for table 'sebhtml_forum_sections'
#

CREATE TABLE sebhtml_forum_sections  (
forum_section_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY(forum_section_id),

forum_section_name VARCHAR(255) NOT NULL,

order_id BIGINT UNSIGNED DEFAULT 0
)TYPE=MyISAM;




#
# Table structure for table 'sebhtml_forum_discussions'
#

#-1 auteur 0 session, autres: groupe
#en ce moment : 
#read : all
#view all
#thread start : d?end
#thread reply : session
#delete : admin
#edit : auteur

CREATE TABLE sebhtml_forum_discussions  (
forum_discussion_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (forum_discussion_id),

forum_discussion_name VARCHAR(255) NOT NULL,
forum_discussion_description VARCHAR(255) NOT NULL,

right_read SMALLINT DEFAULT -1,
right_view SMALLINT DEFAULT -1,
right_thread_start SMALLINT DEFAULT 0,
right_thread_reply SMALLINT DEFAULT 0,
right_delete SMALLINT DEFAULT 1,
right_edit SMALLINT DEFAULT -2,

forum_section_id BIGINT UNSIGNED NOT NULL,
KEY forum_section_id (forum_section_id),


order_id BIGINT UNSIGNED DEFAULT 0

)TYPE=MyISAM;


#
# Table structure for table 'sebhtml_forum_sujets'
#

CREATE TABLE sebhtml_forum_sujets  (
forum_sujet_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY(forum_sujet_id),

forum_discussion_id BIGINT UNSIGNED NOT NULL,
KEY forum_discussion_id (forum_discussion_id),



locked TINYINT UNSIGNED DEFAULT 0
)TYPE=MyISAM;


#--------------------------------------------------------------------------------------------------------------
#
# Table structure for table 'sebhtml_forum_messages'
#

CREATE TABLE sebhtml_forum_messages  (
forum_message_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY(forum_message_id),

forum_sujet_id BIGINT UNSIGNED NOT NULL,
KEY forum_sujet_id (forum_sujet_id),

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

forum_message_titre VARCHAR(255) NOT NULL,
forum_message_contenu TEXT NOT NULL,



forum_message_add_gmt_timestamp BIGINT UNSIGNED  NOT NULL,
forum_message_edit_gmt_timestamp BIGINT UNSIGNED NOT NULL

)TYPE=MyISAM;


#--------------------------------------------------------------------------------------------------------------

#
# Table structure for table 'sebhtml_moderators '
#

CREATE TABLE sebhtml_moderators  (
forum_discussion_id SMALLINT UNSIGNED,
KEY forum_discussion_id (forum_discussion_id),

group_id INT UNSIGNED,
KEY group_id (group_id)
)TYPE=MyISAM;


#--------------------------------------------------------------------------------------------------------------

#
# Table structure for table 
#

CREATE TABLE views_of_threads  (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

forum_sujet_id BIGINT UNSIGNED,
KEY forum_sujet_id (forum_sujet_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;

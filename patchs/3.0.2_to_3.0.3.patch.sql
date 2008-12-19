#$Id: 3.0.2_to_3.0.3.patch.sql 8 2005-09-13 17:44:21Z sebhtml $






# move files upload in uploads
# move members files to uploads.
# reset smarty ,clear cache and templates_c
# sourceforge
#bakup cvs
ALTER TABLE `ooo_usrs` DROP `usr_crypted_password` ;

CREATE TABLE ooo_new_password_requests  (

usr_id BIGINT UNSIGNED,
KEY usr_id (usr_id),
secure_string CHAR(32) NOT NULL

);

ALTER TABLE `ooo_sebhtml_options` ADD `news_forum_discussion_id` INT UNSIGNED NOT NULL ;

ALTER TABLE `ooo_usrs` ADD `usr_picture_file_name` VARCHAR( 32 ) DEFAULT 'default1' ;

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 326);#MOD_FORUM_CAN_VIEW_NEWS_PAGE

UPDATE ooo_usrs SET `usr_picture_file_name`='default1';

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 328);#MOD_MEMBERS_VIEW_USR_PICTURE
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 328);#MOD_MEMBERS_VIEW_USR_PICTURE
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 329);#MOD_MEMBERS_VIEW_MY_USR_PICTURE

CREATE TABLE ooo_sections_groups_view  (
forum_section_id SMALLINT UNSIGNED,
KEY forum_section_id (forum_section_id),

group_id INT UNSIGNED,
KEY group_id (group_id)
);

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 332);#MOD_FORUM_CAN_VIEW_SECTION_WITH_PERM

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 332);#MOD_FORUM_CAN_VIEW_SECTION_WITH_PERM

CREATE TABLE ooo_page_views (
page_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY  (page_id),

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

session_id BIGINT UNSIGNED NOT NULL,
KEY session_id (session_id),

gmt_timestamp BIGINT UNSIGNED NOT NULL,
requested_url VARCHAR(255),
usr_page_title VARCHAR(255),
REMOTE_PORT VARCHAR(32) NOT NULL,
generate_delta_time FLOAT,


HTTP_KEEP_ALIVE VARCHAR(32)  NOT NULL,
HTTP_CONNECTION VARCHAR(255) NOT NULL

);

ALTER TABLE `ooo_online_time` DROP `REMOTE_PORT` ;

ALTER TABLE `ooo_online_time` DROP `HTTP_KEEP_ALIVE` ,
DROP `HTTP_CONNECTION` ;

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 336);#MOD_SESSIONS_CAN_VIEW_MY_SESSION_PAGE

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 303);#MOD_FORUM_CAN_REPLY_WITH_PERM
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 304);#MOD_FORUM_CAN_START_WITH_PERM

ALTER TABLE `ooo_answers` ADD `pts_amount_for_good_answer` TINYINT DEFAULT '1' NOT NULL ,
 ADD `pts_amount_for_bad_answer` TINYINT DEFAULT '0' NOT NULL ;
 
 ALTER TABLE `ooo_questions` ADD `correcting_method` TINYINT UNSIGNED DEFAULT '0' NOT NULL ;
 
 ALTER TABLE `ooo_scores` ADD `secure_str` VARCHAR( 32 ) DEFAULT '' ;
 
 ALTER TABLE `ooo_courses_sess_vars` ADD `chapitre_media_id` BIGINT UNSIGNED DEFAULT '0' NOT NULL ;
#$Id$

###################################################################################
#                                                                              
#  STEPS TO UPDATE TO 3.0.2 from 3.0.1   
#                                    
# > DO A back-up before proceeding...                                                      
# > make sure the prefix is the same as the one you use... (OOO_)              
# > run all those sql queries                                                  
# > copy the content of src into your website directory.                       
# > remove all templates_c compiles files...                                  
# > enjoy !!!                                                                
#                                                                                
###################################################################################

ALTER TABLE `OOO_usrs` ADD `phone_number` VARCHAR( 32 ) NOT NULL ;

ALTER TABLE `OOO_usrs` ADD `show_phone_number` TINYINT UNSIGNED DEFAULT '0' NOT NULL ;

INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 291);#CAN_VIEW_USR_EMAIL_WITH_PERMISSION
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 292);#CAN_VIEW_USR_PHONE_NUMBER_PERMISSION
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 293);#CAN_VIEW_MY_PHONE_NUMBER
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 294);#CAN_VIEW_MY_EMAIL_ADDR

ALTER TABLE `OOO_usrs` ADD `usr_number` VARCHAR( 16 ) NOT NULL ;

INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 295);#CAN_VIEW_MY_USR_NUMBER

UPDATE `OOO_usrs` SET usr_number=usr_name WHERE 1;#update the usr_number...

ALTER TABLE `OOO_usrs` CHANGE `language` `language` VARCHAR( 8 ) DEFAULT 'fr-ca';
ALTER TABLE `OOO_sebhtml_options` CHANGE `language` `language` VARCHAR( 8 ) DEFAULT 'fr-ca';
UPDATE `OOO_usrs` SET language='fr-ca' WHERE language='fr';
UPDATE `OOO_sebhtml_options` SET language='fr-ca' WHERE language='fr';

ALTER TABLE `OOO_usrs` ADD `auto_disconnect_in_min` INT UNSIGNED DEFAULT '30' NOT NULL ;
ALTER TABLE `OOO_online_time` ADD `expire_GMT_timestamp` BIGINT UNSIGNED NOT NULL ;
ALTER TABLE `OOO_usrs` ADD `auto_disconnect_in_min_with_start` INT UNSIGNED DEFAULT '90' NOT NULL ;
ALTER TABLE `OOO_sebhtml_options` ADD `auto_disconnect_in_min_with_start` INT UNSIGNED DEFAULT '90' NOT NULL ;
ALTER TABLE `OOO_online_time` ADD `re_ask_password_ts_GMT` BIGINT UNSIGNED NOT NULL ;
ALTER TABLE `OOO_sebhtml_options` ADD `results_per_page` INT UNSIGNED DEFAULT '30' NOT NULL ;
ALTER TABLE `OOO_usrs` ADD `results_per_page` INT UNSIGNED DEFAULT '30' NOT NULL ;
ALTER TABLE `OOO_sebhtml_forum_discussions` DROP `right_read` ,
DROP `right_view` ,
DROP `right_thread_start` ,
DROP `right_thread_reply` ,
DROP `right_delete` ,
DROP `right_edit` ;
CREATE TABLE OOO_forums_groups_view(
forum_discussion_id SMALLINT UNSIGNED,
KEY forum_discussion_id( forum_discussion_id ) ,
group_id INT UNSIGNED,
KEY group_id( group_id )
) TYPE = MYISAM ;# MySQL n'a retourné aucun enregistrement.
CREATE TABLE OOO_forums_groups_start(
forum_discussion_id SMALLINT UNSIGNED,
KEY forum_discussion_id( forum_discussion_id ) ,
group_id INT UNSIGNED,
KEY group_id( group_id )
) TYPE = MYISAM ;# MySQL n'a retourné aucun enregistrement.
CREATE TABLE OOO_forums_groups_reply(
forum_discussion_id SMALLINT UNSIGNED,
KEY forum_discussion_id( forum_discussion_id ) ,
group_id INT UNSIGNED,
KEY group_id( group_id )
) TYPE = MYISAM ;# MySQL n'a retourné aucun enregistrement.

#nobody
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (1, 298);#MOD_FORUM_VIEW_MAIN
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (1, 320);#MOD_FORUM_CAN_VIEW_A_FORUM_WITH_PERM

#somebody
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 298);#MOD_FORUM_VIEW_MAIN
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 303);#MOD_FORUM_CAN_REPLY_WITH_PERM
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 304);#MOD_FORUM_CAN_START_WITH_PERM
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 306);#MOD_FORUM_CAN_LOCK_THREAD_AS_MOD
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 307);#MOD_FORUM_CAN_MOVE_THREAD_AS_MOD
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 319);#MOD_FORUM_CAN_EDIT_MY_POST
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 320);#MOD_FORUM_CAN_VIEW_A_FORUM_WITH_PERM
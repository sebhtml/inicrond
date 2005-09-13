#$Id$
#
#
#Change OOO_ for your table prefix...
#
#
ALTER TABLE `OOO_chapitre_media` ADD `CHECK_FOR_TEST_LINKAGE` TINYINT UNSIGNED DEFAULT '1' NOT NULL ;

ALTER TABLE `OOO_chapitre_media` ADD `IS_VISIBLE` TINYINT UNSIGNED DEFAULT '0' NOT NULL ;
ALTER TABLE `OOO_tests` ADD `IS_VISIBLE` TINYINT UNSIGNED DEFAULT '0' NOT NULL ;


INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 281);#CAN_SEE_MEDIA_AS_COURSE_STUDENT
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 282);#CAN_SEE_MEDIA_AS_COURSE_ADMIN

INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 284);#CAN_SEE_A_TEST_AS_COURSE_ADMIN
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 285);#CAN_SEE_A_TEST_AS_COURSE_STUDENT
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (1, 286);#CAN_EDIT_WIKI_PAGE

INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 286);#CAN_EDIT_WIKI_PAGE
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 287);#CAN_VIEW_WIKI_PAGE
INSERT INTO OOO_groups_actions (group_id, action_id) VALUES (2, 288);#CAN_CHANGE_WIKI_VERSION


#$Id$

# Change your prefix!!!

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 372);#MD_TESTS_RESULTS_CAN_SEE_CORR_FOR_MY_USR
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 374);#MD_TESTS_RESULTS_CAN_SEE_CORR_FOR_USR_AND_TEST
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 376);#MD_TESTS_RESULTS_CAN_SEE_CORR_FOR_MY_TEST

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 380);#MD_SESS_CAN_SEE_GRAPH_FOR_MY_USER

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 383);#MD_SWF_MARKS_CAN_SEE_CORR_FOR_USR_AND_SWF
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 385);#MD_SWF_MARKS_CAN_SEE_CORR_FOR_MY_SWF
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 387);#MD_SWF_MARKS_CAN_SEE_CORR_FOR_MY_USR

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 388);#MD_TESTS_RESULTS_CAN_SEE_HIST_FOR_MY_USR
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 390);#MD_TESTS_RESULTS_CAN_SEE_HIST_FOR_USR_AND_TEST
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 392);#MD_TESTS_RESULTS_CAN_SEE_HIST_FOR_MY_TEST

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 394);#MD_MARKS_CAN_SEE_HIST_FOR_MY_USR
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 396);#MD_MARKS_CAN_SEE_HIST_FOR_USR_AND_SWF
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 398);#MD_MARKS_CAN_SEE_HIST_FOR_MY_SWF


INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 402);#MD_SESS_CAN_SEE_NORM_GRAPH_FOR_MY_USER

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 403);#MD_TESTS_RESULTS_CAN_SEE_TIME_HIST_FOR_MY_USR

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 405);#MD_TESTS_RESULTS_CAN_SEE_TIME_HIST_FOR_USR_AND_TEST

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 407);#MD_TESTS_RESULTS_CAN_SEE_TIME_HIST_FOR_MY_TEST

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 409);#MD_MARKS_CAN_SEE_TIME_HIST_FOR_MY_USR
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 411);#MD_MARKS_CAN_SEE_TIME_HIST_FOR_USR_AND_SWF
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 413);#MD_MARKS_CAN_SEE_TIME_HIST_FOR_MY_SWF

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 416);#CAN_EDIT_DIR_AS_COURSE_ADMIN

ALTER TABLE `ooo_questions` ADD `question_CODE` VARCHAR( 64 ) NOT NULL ;

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 418);#MD_COURSES_UP_INODE_AS_COURSE_ADMIN
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 420);#MD_COURSES_DOWN_INODE_AS_COURSE_ADMIN


ALTER TABLE `ooo_inode_elements` ADD `order_id` BIGINT UNSIGNED NOT NULL ;

UPDATE ooo_inode_elements SET order_id=inode_id;

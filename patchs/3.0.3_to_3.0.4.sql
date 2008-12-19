CREATE TABLE ooo_multiple_short_answers (

#les tests disponibles...
short_answer_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (short_answer_id),

#
short_answer_name TEXT,

#liaison avec les questions
question_id BIGINT UNSIGNED ,
KEY question_id (question_id),


usr_id BIGINT UNSIGNED,
KEY usr_id (usr_id),

pts_amount_for_good_answer TINYINT DEFAULT 1,

pts_amount_for_bad_answer TINYINT DEFAULT 0

)TYPE=MyISAM;

#-----------------------------------

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 343);#MOD_ABOUT_CAN_SEE_ABOUT_BLOCK
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 343);#MOD_ABOUT_CAN_SEE_ABOUT_BLOCK
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 341);#MOD_USR_CAN_VIEW_MOD_BLOCK
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (1, 342);#MOD_USR_CAN_USR_BLOCK
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 341);#MOD_USR_CAN_VIEW_MOD_BLOCK
INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 342);#MOD_USR_CAN_USR_BLOCK

ALTER TABLE `ooo_sebhtml_options` ADD `redirect_url` VARCHAR( 255 ) DEFAULT 'modules/mod_forum/news.php' NOT NULL ;

CREATE TABLE ooo_sebhtml_blocks  (
block_alias VARCHAR (32),


#1 : left
#2 : center left
#3 : center right
#4 : right
x_position TINYINT UNSIGNED,

#this field is used to order by entries
y_position TINYINT UNSIGNED

);

INSERT INTO ooo_sebhtml_blocks (block_alias, x_position, y_position) VALUES ('about', 4, 4);
INSERT INTO ooo_sebhtml_blocks (block_alias, x_position, y_position) VALUES ('admin', 4, 9);
INSERT INTO ooo_sebhtml_blocks (block_alias, x_position, y_position) VALUES ('online_people', 4, 5);
INSERT INTO ooo_sebhtml_blocks (block_alias, x_position, y_position) VALUES ('languages', 4, 2);
INSERT INTO ooo_sebhtml_blocks (block_alias, x_position, y_position) VALUES ('my_user', 1, 1);
INSERT INTO ooo_sebhtml_blocks (block_alias, x_position, y_position) VALUES ('modules', 1, 2);

ALTER TABLE `ooo_questions` DROP `points` ;

ALTER TABLE `ooo_questions` ADD `good_points` INT UNSIGNED DEFAULT '1' NOT NULL ,
ADD `bad_points` INT DEFAULT '0' NOT NULL ;

ALTER TABLE `ooo_tests` ADD `do_you_show_good_answers` TINYINT UNSIGNED DEFAULT '0' NOT NULL ;

INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 348);#MOD_TESTS-RESULTS_CAN_SEE_GOOD_ANSWERS_IN_CORRECTED_COPY_WITH_PERM.<



INSERT INTO ooo_groups_actions (group_id, action_id) VALUES (2, 349);#MOD_TESTS_RESULTS_CAN_SEE_GOOD_ANSWERS_IN_CORRECTED_COPY_FOR_MY_TEST


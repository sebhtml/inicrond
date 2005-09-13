DROP TABLE IF EXISTS inicrond_sebhtml_forum_messages
#
# Table structure for table inicrond_sebhtml_forum_messages
#

CREATE TABLE  inicrond_sebhtml_forum_messages    (
forum_message_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY(forum_message_id),

forum_sujet_id BIGINT UNSIGNED NOT NULL,
KEY forum_sujet_id (forum_sujet_id),

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

forum_message_titre VARCHAR(255) NOT NULL,
forum_message_contenu TEXT NOT NULL,



forum_message_add_gmt_timestamp BIGINT UNSIGNED NOT NULL,
forum_message_edit_gmt_timestamp BIGINT UNSIGNED NOT NULL

)TYPE=MyISAM;
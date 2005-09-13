# $Id$

#
# Table structure for table 'wiki '
#

CREATE TABLE wiki  (
wiki_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (wiki_id),

usr_id INT UNSIGNED,
KEY usr_id (usr_id),

wiki_title VARCHAR(255),

wiki_content TEXT,
#pour la version
last_ts BIGINT UNSIGNED,

wiki_ts BIGINT UNSIGNED
)TYPE=MyISAM;


#--------------------------------------------------------------------------------------------------------------
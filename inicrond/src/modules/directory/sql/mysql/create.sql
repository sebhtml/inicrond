# $Id$


#
# Table structure for table 'links'
#

CREATE TABLE links (
link_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (link_id),

link_title VARCHAR(255) NOT NULL,
link_description TEXT NOT NULL,

link_url VARCHAR(255) NOT NULL,

add_gmt_timestamp BIGINT UNSIGNED  NOT NULL,
edit_gmt_timestamp BIGINT UNSIGNED  NOT NULL,

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

directory_section_id BIGINT UNSIGNED NOT NULL,
KEY directory_section_id (directory_section_id)
#nb_views BIGINT UNSIGNED  DEFAULT 0,
#nb_hits BIGINT UNSIGNED  DEFAULT 0

)TYPE=MyISAM;

#--------------------------------------------------------------------------------------------------------------




#
# Table structure for table 'directory_sections'
#

CREATE TABLE directory_sections (
directory_section_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (directory_section_id),

directory_section_name VARCHAR(255) NOT NULL,

right_add_an_url  SMALLINT DEFAULT 0

)TYPE=MyISAM;
#--------------------------------------------------------------------------------------------------------------




#
# Table structure for table 
#

CREATE TABLE clicks_for_links  (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

link_id BIGINT UNSIGNED,
KEY link_id (link_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;


#
# Table structure for table 
#

CREATE TABLE views_of_links  (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

link_id BIGINT UNSIGNED,
KEY link_id (link_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;

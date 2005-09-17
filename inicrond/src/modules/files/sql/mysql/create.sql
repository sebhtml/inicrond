# $Id$

CREATE TABLE sebhtml_uploaded_files_sections (
uploaded_files_section_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (uploaded_files_section_id),
uploaded_files_section_name VARCHAR(255) NOT NULL,
#a-t-il le droit décrire...
right_add_a_file  SMALLINT DEFAULT 0
)TYPE=MyISAM ;


#
# Table structure for table 'sebhtml_uploaded_files'
#

CREATE TABLE sebhtml_uploaded_files (
uploaded_file_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (uploaded_file_id),

uploaded_file_title VARCHAR(255) NOT NULL,
uploaded_file_description TEXT NOT NULL,


uploaded_file_name VARCHAR(255) NOT NULL,

uploaded_file_add_gmt_timestamp BIGINT UNSIGNED  NOT NULL,
uploaded_file_edit_gmt_timestamp BIGINT UNSIGNED  NOT NULL,

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

uploaded_files_section_id BIGINT UNSIGNED NOT NULL,
KEY uploaded_files_section_id (uploaded_files_section_id)

#nb_views BIGINT UNSIGNED DEFAULT 0,
#nb_downloads BIGINT UNSIGNED DEFAULT 0

)TYPE=MyISAM;

#
# Table structure for table 'sebhtml_uploaded_files_sections'
#


#
# Table structure for table 
#

CREATE TABLE views_of_files (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

uploaded_file_id BIGINT UNSIGNED,
KEY uploaded_file_id (uploaded_file_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;



#
# Table structure for table 
#

CREATE TABLE downloads_of_files (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

uploaded_file_id BIGINT UNSIGNED,
KEY uploaded_file_id (uploaded_file_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;

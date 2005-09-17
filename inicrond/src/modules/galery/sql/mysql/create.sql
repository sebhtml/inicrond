# $Id$

#
# Table structure for table 'sebhtml_images'
#

CREATE TABLE sebhtml_images (
image_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (image_id),

image_title VARCHAR(255) NOT NULL,
image_description TEXT NOT NULL,

file_name VARCHAR(255) NOT NULL,

add_gmt_timestamp BIGINT UNSIGNED  NOT NULL,
edit_gmt_timestamp BIGINT UNSIGNED  NOT NULL,

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

galerie_id BIGINT UNSIGNED NOT NULL,
KEY galerie_id (galerie_id)

#nb_views BIGINT UNSIGNED  DEFAULT 0

)TYPE=MyISAM;

#--------------------------------------------------------------------------------------------------------------

#
# Table structure for table 'sebhtml_galeries'
#

CREATE TABLE sebhtml_galeries (
galerie_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (galerie_id),

galerie_name VARCHAR(255) NOT NULL,

right_add_an_img  TINYINT UNSIGNED DEFAULT 0

)TYPE=MyISAM;
#--------------------------------------------------------------------------------------------------------------


#
# Table structure for table 
#

CREATE TABLE views_of_images (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

image_id BIGINT UNSIGNED,
KEY image_id (image_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;

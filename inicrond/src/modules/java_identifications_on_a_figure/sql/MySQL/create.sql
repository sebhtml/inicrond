
create table java_identifications_on_a_figure
(
    inode_id int unsigned not null,
    title varchar(30) not null,
    at_random char(1) not null,
    available_sheet char(1) not null,
    available_result char(1) not null,
    image_file_name varchar(255) not null,
    file_name_in_uploads char(32) not null,
    add_time_t int unsigned not null,
    edit_time_t int unsigned not null,
    primary key (inode_id)
) CHARSET=utf8 type=myisam ;

create table java_identifications_on_a_figure_label
(
    java_identifications_on_a_figure_label_id int unsigned NOT NULL auto_increment,
    inode_id int unsigned not null,
    label_name varchar(30) not null,
    x_position smallint unsigned not null,
    y_position smallint unsigned not null,
    order_id int unsigned not null,
    primary key (java_identifications_on_a_figure_label_id),
    key inode_id (inode_id)
) CHARSET=utf8 type=myisam ;

create table java_identifications_on_a_figure_result_association
(
    java_identifications_on_a_figure_result_id int unsigned not null,
    java_identifications_on_a_figure_label_id_source int unsigned not null,
    java_identifications_on_a_figure_label_id_destination int unsigned not null,
    order_id int unsigned not null,
    key java_identifications_on_a_figure_result_id (java_identifications_on_a_figure_result_id),
    key java_identifications_on_a_figure_label_id_source (java_identifications_on_a_figure_label_id_source),
    key java_identifications_on_a_figure_label_id_destination (java_identifications_on_a_figure_label_id_destination)
) CHARSET=utf8 type=myisam ;

create table java_identifications_on_a_figure_result
(
    inode_id int unsigned not null,
    java_identifications_on_a_figure_result_id int unsigned not null auto_increment,
    usr_id int unsigned not null,
    time_t int unsigned not null,
    key inode_id (inode_id),
    key java_identifications_on_a_figure_result_id (java_identifications_on_a_figure_result_id),
    key usr_id (usr_id)
) CHARSET=utf8 type=myisam ;














-- /*
--     $Id$
--
--     Inicrond : Network of Interactive Courses Registred On a Net Domain
--     Copyright (C) 2004, 2005, 2006  Sébastien Boisvert
--
--     This program is free software; you can redistribute it and/or modify
--     it under the terms of the GNU General Public License as published by
--     the Free Software Foundation; either version 2 of the License, or
--     (at your option) any later version.
--
--     This program is distributed in the hope that it will be useful,
--     but WITHOUT ANY WARRANTY; without even the implied warranty of
--     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
--     GNU General Public License for more details.
--
--     You should have received a copy of the GNU General Public License
--     along with this program; if not, write to the Free Software
--     Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
-- */


create table java_identifications_on_a_figure
(
    inode_id int unsigned not null,
    title varchar(30) not null,
    at_random char(1) not null,
    available_sheet char(1) not null,
    available_result char(1) not null,
    image_file_name char(32) not null,
    add_time_t int unsigned not null,
    edit_time_t int unsigned not null,
    primary key (inode_id)
) ;

create table java_identification_on_a_figure_label
(
    java_identification_on_a_figure_label_id int unsigned NOT NULL auto_increment,
    inode_id int unsigned not null,
    label_name varchar(30) not null,
    x_position smallint unsigned not null,
    y_position smallint unsigned not null,
    order_id int unsigned not null,
    primary key (java_identification_on_a_figure_label_id),
    key inode_id (inode_id)
) ;

create table java_identifications_on_a_figure_result_association
(
    java_identifications_on_a_figure_result_id int unsigned not null,
    java_identification_on_a_figure_label_id_source int unsigned not null,
    java_identification_on_a_figure_label_id_destination int unsigned not null,
    order_id int unsigned not null,
    key java_identifications_on_a_figure_result_id (java_identifications_on_a_figure_result_id),
    key java_identification_on_a_figure_label_id_source (java_identification_on_a_figure_label_id_source),
    key java_identification_on_a_figure_label_id_destination (java_identification_on_a_figure_label_id_destination)
) ;

create table java_identifications_on_a_figure_result
(
    inode_id int unsigned not null,
    java_identifications_on_a_figure_result_id int unsigned not null auto_increment,
    usr_id int unsigned not null,
    time_t int unsigned not null,
    key inode_id (inode_id),
    key java_identifications_on_a_figure_result_id (java_identifications_on_a_figure_result_id),
    key usr_id (usr_id)
) ;














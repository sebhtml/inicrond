{*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005, 2006  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*}
<?xml version="1.0" encoding="UTF-8"?>

<java_identifications_on_a_figure>

    <image_file_name>
        {$java_identifications_on_a_figure.image_file_name}
    </image_file_name>

    <image_file_url>
        {$java_identifications_on_a_figure.image_file_url}
    </image_file_url>

    <available_sheet>
        {$java_identifications_on_a_figure.available_sheet}
    </available_sheet>

    <available_result>
        {$java_identifications_on_a_figure.available_result}
    </available_result>

    <at_random>
        {$java_identifications_on_a_figure.at_random}
    </at_random>

    <title>
        {$java_identifications_on_a_figure.title}
    </title>

    <inode_id>
        {$java_identifications_on_a_figure.inode_id}
    </inode_id>

    <add_time_t_human_readable>
        {$java_identifications_on_a_figure.add_time_t_human_readable}
    </add_time_t_human_readable>

    <edit_time_t>
        {$java_identifications_on_a_figure.edit_time_t}
    </edit_time_t>

    <add_time_t>
        {$java_identifications_on_a_figure.add_time_t}
    </add_time_t>

    <edit_time_t_human_readable>
        {$java_identifications_on_a_figure.edit_time_t_human_readable}
    </edit_time_t_human_readable>

    <image_width>
        {$java_identifications_on_a_figure.image_width}
    </image_width>

    <image_height>
        {$java_identifications_on_a_figure.image_height}
    </image_height>

    {section name=one loop=$java_identifications_on_a_figure_label}

    <java_identifications_on_a_figure_label>

        <java_identifications_on_a_figure_label_id>
            {$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}
        </java_identifications_on_a_figure_label_id>

        <label_name>
            {$java_identifications_on_a_figure_label[one].label_name}
        </label_name>

        <x_position>
            {$java_identifications_on_a_figure_label[one].x_position}
        </x_position>

        <y_position>
            {$java_identifications_on_a_figure_label[one].y_position}
        </y_position>

        <order_id>
            {$java_identifications_on_a_figure_label[one].order_id}
        </order_id>

    </java_identifications_on_a_figure_label>

    {/section}

</java_identifications_on_a_figure>

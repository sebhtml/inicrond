<form method="post" enctype="multipart/form-data">

<table>
    <tr>
        <td>
            {$_LANG.title}
        </td>
        <td>
            <input type="text" name="title" value="{$title}" />
        </td>
    </tr>
    <tr>
        <td>
            {$_LANG.image_file_name}
        </td>
        <td>
            <input type="file" name="image_file_name" />
        </td>
    </tr>
    <tr>
        <td>
            {$_LANG.at_random}
        </td>
        <td>
            {html_options name=at_random options=$at_random selected=$at_random_value}
        </td>
    </tr>
    <tr>
        <td>
            {$_LANG.available_result}
        </td>
        <td>
            {html_options name=available_result options=$available_result selected=$available_result_value}
        </td>
    </tr>
    <tr>
        <td>

            {$_LANG.available_sheet}
        </td>
        <td>
            {html_options name=available_sheet options=$available_sheet selected=$available_sheet_value}
        </td>
    </tr>
</table>

{$image_file_name}<br />
{$image_width} x {$image_height} <br />
<img src="get_java_identifications_on_a_figure_image.php?inode_id={$inode_id}" /><br />
{$_LANG.informations_on_origin}<br  />

<h2>{$_LANG.java_identifications_on_a_figure_label}</h2>

    <a href="add_a_java_identifications_on_a_figure_label.php?inode_id={$inode_id}">
        {$_LANG.add_a_java_identifications_on_a_figure_label}
    </a> <br />

<table border="0">

    <tr>
        <td>
            {$_LANG.label_name}
        </td>
        <td>
            {$_LANG.x_position}
        </td>
        <td>
            {$_LANG.y_position}
        </td>
        <td>
            {$_LANG.move_down_a_java_identifications_on_a_figure_label}
        </td>
        <td>
            {$_LANG.move_up_a_java_identifications_on_a_figure_label}
        </td>
        <td>
            {$_LANG.drop_a_java_identifications_on_a_figure_label}
        </td>
    </tr>

    {section name=one loop=$java_identifications_on_a_figure_label}
        <tr>
            <td>
                <input type="text" name="java_identifications_on_a_figure_label_id={$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}&label_name" value="{$java_identifications_on_a_figure_label[one].label_name}" />
            </td>
            <td>
                <input type="text" name="java_identifications_on_a_figure_label_id={$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}&x_position" value="{$java_identifications_on_a_figure_label[one].x_position}" />
            </td>
            <td>
                <input type="text" name="java_identifications_on_a_figure_label_id={$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}&y_position" value="{$java_identifications_on_a_figure_label[one].y_position}" />
            </td>
            <td>
                <a href="move_down_a_java_identifications_on_a_figure_label.php?java_identifications_on_a_figure_label_id={$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}">{$_LANG.move_down_a_java_identifications_on_a_figure_label}</a>
            </td>
            <td>
                <a href="move_up_a_java_identifications_on_a_figure_label.php?java_identifications_on_a_figure_label_id={$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}">{$_LANG.move_up_a_java_identifications_on_a_figure_label}</a>
            </td>
            <td>
                <a href="drop_a_java_identifications_on_a_figure_label.php?java_identifications_on_a_figure_label_id={$java_identifications_on_a_figure_label[one].java_identifications_on_a_figure_label_id}">{$_LANG.drop_a_java_identifications_on_a_figure_label}</a>
            </td>
        </tr>
    {/section}

</table>

<input type="submit" />

</form>
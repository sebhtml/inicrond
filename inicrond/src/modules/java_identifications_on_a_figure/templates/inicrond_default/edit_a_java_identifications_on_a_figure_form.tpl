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




<input type="submit" />

</form>
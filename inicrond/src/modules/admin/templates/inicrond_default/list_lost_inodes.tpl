



<h2>{$_LANG.list_lost_inodes}</h2>

    {section name=one loop=$course}

        <pre>

            {$course[one].cours_id} {$course[one].cours_code} {$course[one].cours_name}

        </pre>

        {section name=lost_one loop=$course.lost_inode}

            inode_id = {$course.lost_inode[lost_one]} <br />

        {/section}


        <br /><br />
    {/section}



<h2>{$_LANG.list_lost_inodes_lost_chapitre_media}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_chapitre_media}

        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_chapitre_media[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_chapitre_media[one].title}
        <br />

    {/section}

    <br /><br />
<h2>{$_LANG.list_lost_inodes_lost_courses_files}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_courses_files}


        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_courses_files[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_courses_files[one].title}
        <br />
    {/section}
    <br /><br />
<h2>{$_LANG.list_lost_inodes_lost_inicrond_images}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_inicrond_images}

        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_inicrond_images[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_inicrond_images[one].title}
        <br />

    {/section}
    <br /><br />
<h2>{$_LANG.list_lost_inodes_lost_inicrond_texts}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_inicrond_texts}


        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_inicrond_texts[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_inicrond_texts[one].title}
        <br />
    {/section}
    <br /><br />
<h2>{$_LANG.list_lost_inodes_lost_java_identifications_on_a_figure}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_java_identifications_on_a_figure}

        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_java_identifications_on_a_figure[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_java_identifications_on_a_figure[one].title}
        <br />

    {/section}
    <br /><br />
<h2>{$_LANG.list_lost_inodes_lost_tests}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_tests}


        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_tests[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_tests[one].title}
        <br />

    {/section}
    <br /><br />
<h2>{$_LANG.list_lost_inodes_lost_virtual_directories}</h2>

    {section name=one loop=$lost_with_no_cours_id.list_lost_inodes_lost_virtual_directories}


        {$_LANG.id} : {$lost_with_no_cours_id.list_lost_inodes_lost_virtual_directories[one].id}
        {$_LANG.title} : {$lost_with_no_cours_id.list_lost_inodes_lost_virtual_directories[one].title}
        <br />
    {/section}
    <br /><br />
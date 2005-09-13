<?php
//$Id$


$modules= array(

//others
"2" =>  "modules/others/articles_inc.php",//articles.
"32" =>  "modules/others/news_inc.php",//news
"36" =>  "modules/others/stats_inc.php",//stats
//members
"8" =>  "modules/members/list_inc.php",//voir liste
"4" => "modules/members/usr_inc.php",//voir membre
//admin
"19" => "modules/admin/set/db_inc.php",//db restore
"9" =>  "modules/admin/set/allow_inc.php",//droits
"34" =>  "modules/admin/set/etc_inc.php",//options
"29" =>  "modules/admin/set/visits_inc.php",//visits
//usr
"14" =>  "modules/usr/forgot_pwd_inc.php",//password oublier
"11" => "modules/usr/usr_stat_inc.php",//modifier profil
"7" => "modules/usr/signin_inc.php",//inscription
"3" => "modules/usr/logout_inc.php",//déconnexion
//galery
"12" => "modules/galery/get/galery_inc.php",//voir une galerie
"13" => "modules/galery/get/img_inc.php",//voir image
"10" => "modules/galery/get/galeries_inc.php",//galeries
"16" =>  "modules/galery/set/add_edit_galery_inc.php",//add/dit galerie
"18" =>  "modules/galery/set/add_edit_remove_img_inc.php",//add/edit/rm img
"31" =>  "modules/galery/set/move_img_inc.php",//changer une image de place
//files
"1" => "modules/files/get/files_inc.php",//fichiers
"15" =>  "modules/files/set/add_edit_remove_file_inc.php",//add/edit/rm file
"17" => "modules/files/set/add_edit_section_inc.php",//add/edit section
"5" => "modules/files/get/section_inc.php",//voir section
"6" => "modules/files/get/file_inc.php",//view file
"30" => "modules/files/set/move_file_inc.php",//bouger un download.
//groups
"20" => "modules/groups/set/add_edit_grp_inc.php",//add/edit groupe.
"21" => "modules/groups/get/grps_inc.php",//groupes
"22" => "modules/groups/get/grp_inc.php",//afficher groupe
//forum
"23" => "modules/forum/main_inc.php",//forum main
"24" => "modules/forum/forum_inc.php",//view forum
"25" => "modules/forum/thread_inc.php",//view thread
"26" => "modules/forum/start_edit_reply_inc.php",//start/edit/reply
"27" => "modules/forum/add_edit_section_inc.php",//add/edit section
"28" => "modules/forum/add_edit_forum_inc.php",//add/edit forum
"33" => "modules/forum/mods_inc.php",//modérateurs
//search
"35" => "modules/search/searchit_inc.php",//chercher
//".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
"37" => "modules/".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."/".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."i_inc.php",//".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
//directory:
"38" => "modules/directory/get/dirs_inc.php",//directirory main
"39" => "modules/directory/set/add_edit_section_inc.php",//add/edit section
"40" => "modules/directory/set/add_edit_rm_url_inc.php",//add/edit/rm url
"41" => "modules/directory/get/section_inc.php",//view section
"42" => "modules/directory/get/url_inc.php",//view url
//source
"43" => "modules/source/php_inc.php",//code source
//calendrier
44 => "modules/calendar/get/main_inc.php",//le main du calendar.
//repository
45 => "modules/repository/get/the_repository_inc.php"
//max = 45

);
	
krsort($modules)	; 

print_r($modules);
?>
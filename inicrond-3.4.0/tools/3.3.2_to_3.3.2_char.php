<?php

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";

// questions

$query = "
update `ooo_questions`
set
question_name = replace (question_name, ' l?', ' l\'')
" ;

$inicrond_db->Execute ($query) ;

$query = "
update `ooo_questions`
set
question_name = replace (question_name, ' s?', ' s\'')
" ;

$inicrond_db->Execute ($query) ;

$query = "
update `ooo_questions`
set
question_name = replace (question_name, ' d?', ' d\'')
" ;

$inicrond_db->Execute ($query) ;

$query = "
update `ooo_questions`
set
question_name = replace (question_name, ' qu?', ' qu\'')
" ;

$inicrond_db->Execute ($query) ;

// choix multiples

$query = "
update `ooo_answers`
set
answer_name = replace (answer_name, ' l?', ' l\'')
" ;

$inicrond_db->Execute ($query) ;

$query = "
update `ooo_answers`
set
answer_name = replace (answer_name, ' s?', ' s\'')
" ;

$inicrond_db->Execute ($query) ;

$query = "
update `ooo_answers`
set
answer_name = replace (answer_name, ' d?', ' d\'')
" ;

$inicrond_db->Execute ($query) ;

$query = "
update `ooo_answers`
set
answer_name = replace (answer_name, ' qu?', ' qu\'')
" ;

$inicrond_db->Execute ($query) ;


?>
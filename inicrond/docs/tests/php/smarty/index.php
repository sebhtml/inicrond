<?php     
    // charge la bibliothèque Smarty
include "src/includes/class/Smarty-2.6.6/libs/Smarty.class.php";
     
     $smarty = new Smarty;
     
     $smarty->template_dir = 'templates/';
     $smarty->compile_dir = 'templates_c/';
     $smarty->config_dir = 'configs/';
     $smarty->cache_dir = 'cache/';
     
     $smarty->assign('name','Ned');
     
    $smarty->display('index.tpl');
?>


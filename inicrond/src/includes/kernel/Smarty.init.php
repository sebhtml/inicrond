<?php
//$Id$

/*---------------------------------------------------------------------
sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-----------------------------------------------------------------------*/

if(!__INICROND_INCLUDED__)
{
 exit();
}

define('SMARTY_DIR', __INICROND_INCLUDE_PATH__."libs/Smarty-2.6.9/libs/");

define('SMARTY_CORE_DIR', SMARTY_DIR.'internals/');

  // charge la bibliothèque Smarty
include SMARTY_DIR.'Smarty.class.php';


$smarty = new Smarty;
$smarty->compile_check = $_OPTIONS['smarty_compile_check'];
$smarty->force_compile = $_OPTIONS['smarty_force_compile'];
  $smarty->use_sub_dirs = $_OPTIONS['smarty_use_sub_dirs'];
  $smarty->compile_dir = __INICROND_INCLUDE_PATH__.'templates_c/';
  $smarty->config_dir = __INICROND_INCLUDE_PATH__.'configs/';
  $smarty->cache_dir = __INICROND_INCLUDE_PATH__.'cache/';
$smarty->php_handling = SMARTY_PHP_PASSTHRU ;
  
  //$smarty->clear_all_cache();
 // $smarty->clear_compiled_tpl();
  /*
$smarty->plugins_dir = SMARTY_DIR."plugins/";
 $smarty->debugging = 0;
  
 */
  /*
function smarty_pre_compiler($tpl_source, &$smarty)
{
return 
"
<!-- START OF {\$smarty.template} -->
".
$tpl_source.
"
<!-- END OF {\$smarty.template} -->
";
}
*/

// enregistrer le filtre de pré-compilation
//$smarty->register_prefilter("smarty_pre_compiler");
//$smarty->load_filter('pre', 'smarty_pre_compiler'); // charge le filtre 'trim' de type 'pre'

include __INICROND_INCLUDE_PATH__.'includes/functions/smarty_reduce_html_size.php';
//$smarty->register_prefilter('smarty_reduce_html_size');
$smarty->register_function('smarty_array_to_html_function', 'smarty_array_to_html_function');

?>
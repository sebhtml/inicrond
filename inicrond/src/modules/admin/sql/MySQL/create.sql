#$Id$





-- 
-- Table structure for table `ooo_sebhtml_options`
-- 

CREATE TABLE sebhtml_options (
  opt_name varchar(64) default NULL,
  opt_value varchar(255) default NULL
) TYPE=MyISAM;

-- --------------------------------------------------------


-- 
-- Table structure for table `ooo_smarty_cache_config`
-- 

CREATE TABLE smarty_cache_config (
  mod_dir varchar(32) default NULL,
  tpl_file varchar(32) default NULL,
  cache_lifetime int(10) unsigned default '0'
) TYPE=MyISAM;

-- --------------------------------------------------------



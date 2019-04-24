<?php
 

// 应用行为扩展定义文件
return array (
  'app_init' => 
  array (
  ),
  'app_begin' => 
  array (
  ),
  'module_init' => 
  array (
  ),
  'action_begin' => 
  array (
  ),
  'view_filter' => 
  array (
  ),
  'app_end' => 
  array (
  ),
  'log_write' => 
  array (
  ),
  'plugins_view_common_top' => 
  array (
    0 => 'app\\plugins\\commontopmaxpicture\\Hook',
    1 => 'app\\plugins\\commontopnotice\\Hook',
  ),
  'plugins_view_user_center_top' => 
  array (
    0 => 'app\\plugins\\usercentertopnotice\\Hook',
  ),
  'plugins_control_user_login_end' => 
  array (
    0 => 'app\\plugins\\userloginrewardintegral\\Hook',
  ),
  'plugins_view_common_bottom' => 
  array (
    0 => 'app\\plugins\\commongobacktop\\Hook',
    1 => 'app\\plugins\\commonrightnavigation\\Hook',
    2 => 'app\\plugins\\commononlineservice\\Hook',
  ),
  'plugins_common_page_bottom' => 
  array (
    0 => 'app\\plugins\\commongobacktop\\Hook',
  ),
  'plugins_common_header' => 
  array (
    0 => 'app\\plugins\\commongobacktop\\Hook',
  ),
  'plugins_css' => 
  array (
    0 => 'app\\plugins\\commonrightnavigation\\Hook',
    1 => 'app\\plugins\\commononlineservice\\Hook',
  ),
  'plugins_js' => 
  array (
    0 => 'app\\plugins\\commonrightnavigation\\Hook',
    1 => 'app\\plugins\\commononlineservice\\Hook',
  ),
);
?>
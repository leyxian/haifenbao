<?php
defined('ZQ-SHOP') or exit('Access Invalid!');
$config = array();
$config['shop_site_url'] 		= '===url===/shop';
$config['cms_site_url'] 		= '===url===/cms';
$config['microshop_site_url'] 	= '===url===/microshop';
$config['circle_site_url'] 		= '===url===/circle';
$config['admin_site_url'] 		= '===url===/admin';
$config['mobile_site_url'] 		= '===url===/mobile';
$config['wap_site_url'] 		= '===url===/wap';
$config['upload_site_url']		= '===url===/data/upload';
$config['resource_site_url']	= '===url===/data/resource';
$config['version'] 		= '201401162490';
$config['setup_date'] 	= '===setup_date===';
$config['gip'] 			= 0;
$config['dbdriver'] 	= '===db_driver===';
$config['tablepre']		= '===db_prefix===';
$config['db'][1]['dbhost']  	= '===db_host===';
$config['db'][1]['dbport']		= '===db_port===';
$config['db'][1]['dbuser']  	= '===db_user===';
$config['db'][1]['dbpwd'] 	 	= '===db_pwd===';
$config['db'][1]['dbname']  	= '===db_name===';
$config['db'][1]['dbcharset']   = '===db_charset===';
$config['db']['slave'] 		= array();
$config['session_expire'] 	= 3600;
$config['lang_type'] 		= 'zh_cn';
$config['cookie_pre'] 		= '===cookie_pre===';
$config['tpl_name'] 		= 'default';
$config['thumb']['cut_type'] = 'gd';
$config['thumb']['impath'] = '';
$config['cache']['type'] 			= 'file';

$config['debug'] 			= false;
$config['default_store_id'] = '===default_store_id==='; 
// 是否开启伪静态
$config['url_model'] = false;
// 二级域名后缀
$config['subdomain_suffix'] = '';

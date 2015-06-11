<?php
defined('ZQ-SHOP') or exit('Access Invalid!');
$config = array();
$config['shop_site_url'] 		= 'http://www.shop.dev/shop';
$config['cms_site_url'] 		= 'http://www.shop.dev/cms';
$config['microshop_site_url'] 	= 'http://www.shop.dev/microshop';
$config['circle_site_url'] 		= 'http://www.shop.dev/circle';
$config['admin_site_url'] 		= 'http://www.shop.dev/admin';
$config['mobile_site_url'] 		= 'http://www.shop.dev/mobile';
$config['wap_site_url'] 		= 'http://www.shop.dev/wap';
$config['upload_site_url']		= 'http://www.shop.dev/data/upload';
$config['resource_site_url']	= 'http://www.shop.dev/data/resource';
$config['version'] 		= '201505201149';
$config['setup_date'] 	= '2015-05-20 11:49:54';
$config['gip'] 			= 0;
$config['dbdriver'] 	= 'mysqli';
$config['tablepre']		= 'zqshop_';
$config['db'][1]['dbhost']  	= 'localhost';
$config['db'][1]['dbport']		= '3306';
$config['db'][1]['dbuser']  	= 'homestead';
$config['db'][1]['dbpwd'] 	 	= 'secret';
$config['db'][1]['dbname']  	= 'shopnc';
$config['db'][1]['dbcharset']   = 'UTF-8';
$config['db']['slave'] 		= array();
$config['session_expire'] 	= 3600;
$config['lang_type'] 		= 'zh_cn';
$config['cookie_pre'] 		= 'ZQ8E_';
$config['tpl_name'] 		= 'default';
$config['thumb']['cut_type'] = 'gd';
$config['thumb']['impath'] = '';
$config['cache']['type'] 	= 'file';

$config['debug'] 			= true;
$config['default_store_id'] = '0'; 
// 是否开启伪静态
$config['url_model'] = false;
// 二级域名后缀
$config['subdomain_suffix'] = '';
$config['sys_log'] = false;


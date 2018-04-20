<?php
// HTTP
define('HTTP_SERVER', 'http://'.$_SERVER['HTTP_HOST'].'/mabhmad/');
define('HTTP_CATALOG', 'http://'.$_SERVER['HTTP_HOST'].'/');

// HTTPS
define('HTTPS_SERVER', 'http://'.$_SERVER['HTTP_HOST'].'/mabhmad/');
define('HTTPS_CATALOG', 'http://'.$_SERVER['HTTP_HOST'].'/');

// DIR
define('DIR_ROOT', str_replace('\\', '/', dirname(__DIR__)).'/');
define('DIR_APPLICATION', DIR_ROOT.'mabhmad/');
define('DIR_LANGUAGE', DIR_APPLICATION.'language/');
define('DIR_TEMPLATE', DIR_APPLICATION.'view/template/');
define('DIR_IMAGE', DIR_ROOT.'image/');
define('DIR_SYSTEM', DIR_ROOT.'system/');
define('DIR_CONFIG', DIR_SYSTEM.'config/');
define('DIR_CACHE', DIR_SYSTEM.'storage/cache/');
define('DIR_DOWNLOAD', DIR_SYSTEM.'storage/download/');
define('DIR_LOGS', DIR_SYSTEM.'storage/logs/');
define('DIR_MODIFICATION', DIR_SYSTEM.'storage/modification/');
define('DIR_UPLOAD', DIR_SYSTEM.'storage/upload/');
define('DIR_CATALOG', DIR_ROOT.'catalog/');

// DB
define('DB_DRIVER', 'mpdo');
define('DB_HOSTNAME', 'localhost');
 $base_data=array(
 		0=>array('username'=>'root','password'=>'root','database'=>'w'),
// 		1=>array('username'=>'root','password'=>'root','database'=>'o'),
 	
 );
 define('DB_DATABASE_DATA', serialize($base_data));
// DB
define('DB_PORT', '3306');
define('DB_PREFIX', 'th_');

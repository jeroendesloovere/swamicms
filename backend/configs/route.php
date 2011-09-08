<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// Backend
// ----------------------------------------------------------
route::set('admin',array(
	'controller'=>'pages',
	'function'=>'index',
	'arguments'=>array()
));
route::set('admin/([^/]+)',array(
	'controller'=>'$1',
	'function'=>'index',
	'arguments'=>array()
));
route::set('admin/([^/]+)/([^/]+)',array(
	'controller'=>'$1',
	'function'=>'$2',
	'arguments'=>array()
));
route::set('admin/([^/]+)/([^/]+)/([^/]+)',array(
	'controller'=>'$1',
	'function'=>'$2',
	'arguments'=>array('$3')
));

// Login
route::set('admin/login',array('controller'=>'users','function'=>'login'));
route::set('admin/logout',array('controller'=>'users','function'=>'logout'));
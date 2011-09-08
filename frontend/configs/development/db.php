<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Dingo Framework DB Configuration File
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */

config::set('db',array(
	
	// Default Connection
	'default'=>array(
	
		'driver'=>'mysql',       // Driver
		'host'=>'localhost',     // Host
		'username'=>'root',      // Username
		'password'=>'root',      // Password
		'database'=>'swami_cms'  // Database
	
	)
	
));
config::set('prefix_table','');
config::set('current_page_id',4); // TODO: remove after site is ready
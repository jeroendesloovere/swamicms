<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Dingo Framework Basic Configuration File
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */

// Application's Base URL
define('BASE_URL','http://localhost:8888/01 PRESENT/SWAMI/04 Swami CMS/02 SITE/');

// Backend
// ------------------------------------------------------------------
define('DEFAULT_LANGUAGE','nl');
define('BACKEND_LANGUAGE','nl');

// Auto Load Libraries
// ------------------------------------------------------------------
config::set('autoload_library',array());

// Auto Load Helpers
// ------------------------------------------------------------------
config::set('autoload_helper',array());

// Sessions
// ------------------------------------------------------------------
config::set('session',array(
	'connection'=>'default',
	'table'=>'sessions',
	'cookie'=>array('path'=>'/','expire'=>'+1 months')
));

// Notes
// ------------------------------------------------------------------
config::set('notes',array('path'=>'/','expire'=>'+5 minutes'));

// Application Folder Locations
// ------------------------------------------------------------------
config::set('folder_views','views');				// Views
config::set('folder_controllers','controllers');	// Controllers
config::set('folder_models','models');				// Models
config::set('folder_helpers','helpers');			// Helpers
config::set('folder_languages','language');			// Languages
config::set('folder_errors','errors');				// Errors
config::set('folder_orm','orm');					// ORM
config::set('folder_modules','modules');			// Modules
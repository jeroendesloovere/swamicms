<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// User Database Connection
config::set('user_connection','default');

// User Database Table
config::set('user_table','users');

// User Types
config::set('user_types',array(

	'banned'=>0,
	'guest'=>1,
	'user'=>2,
	'mod'=>3,
	'admin'=>4,
	'owner'=>5

));

// Allow access
// ------------------------------------------------------------------
load::library('acl');

// Pages
acl::create('pages')
  	
	// Resources
	->resource('index')
	->resource('add')
	->resource('edit')
	->resource('delete')
	->resource('reorder')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','index')
	->allow('user','add')
	->allow('user','edit')
	->allow('user','delete')
	->allow('user','reorder');
	
// Modules
acl::create('modules')
  	
	// Resources
	->resource('index')
	->resource('add')
	->resource('edit')
	->resource('delete')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','index')
	->allow('user','add')
	->allow('user','edit')
	->allow('user','delete');
	
// Media
acl::create('media')
  	
	// Resources
	->resource('index')
	->resource('add')
	->resource('edit')
	->resource('delete')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','index')
	->allow('user','add')
	->allow('user','edit')
	->allow('user','delete');

// Stats
acl::create('stats')
  	
	// Resources
	->resource('index')
	->resource('add')
	->resource('edit')
	->resource('delete')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','index')
	->allow('user','add')
	->allow('user','edit')
	->allow('user','delete');

// Users
acl::create('users')
  	
	// Resources
	->resource('login')
	->resource('index')
	->resource('add')
	->resource('add_any_type') 		// Add any type - if not - only lower types	
	->resource('edit')
	->resource('delete')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','login')
	->allow('user','index')
	->allow('user','add')
	->allow('user','edit')
	->allow('user','delete')
	->allow('admin','add_any_type');
	
// Settings
acl::create('settings')
  	
	// Resources
	->resource('index')
	->resource('edit')
	->resource('profile')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','index')
	->allow('user','edit')
	->allow('user','profile');

// Newsletters
acl::create('newsletters')
  	
	// Resources
	->resource('index')
	->resource('add')
	->resource('edit')
	->resource('delete')
	
	// Roles
	->role('user',array('guest')) 	// The user role is inside the guest role
	->role('admin',array('user'))	// The admin role is inside the user role
	
	// Allowed
	->allow('user','index')
	->allow('user','add')
	->allow('user','edit')
	->allow('user','delete');
<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// Swami CMS Tables
config::set('self_cleaning',true); // TODO: auto_maintenance

config::set('swami_nav', array(
			'pages'=>array(
				'index'=>'admin/pages',
				'contact'=>'admin/contact',
				'blog'=>'admin/blog',
				'links'=>'admin/links',
				'tags'=>'admin/tags',
				'templates'=>'admin/templates'
			),
			'modules'=>array('index'=>'admin/modules'),
			'media'=>array('index'=>'admin/media'),
			'stats'=>array(
				'index'=>'admin/stats',
				'shortUrls'=>'admin/short_urls',
				'visitors'=>'admin/visitors',
				'downloaders'=>'admin/downloaders'
			),
			'users'=>array('index'=>'admin/users'),
			'settings'=>array('index'=>'admin/settings'),
			'newsletters'=>array(
				'index'=>'admin/newsletters',
				'subscribers'=>'admin/newsletters/subscribers',
				'campaigns'=>'admin/newsletters/campaigns',
				'reports'=>'admin/newsletters/reports',
			),
		));

// Modules
config::set('modules',array('page','gallery','tag'));
/*
config::set('modules_table',config::get('prefix_table').'modules');
config::set('modules_connection','default');
*/

// Pages
config::set('pages_table',config::get('prefix_table').'pages');
config::set('pages_connection','default');

	// SEO
	config::set('seo_table',config::get('prefix_table').'seo');
	config::set('seo_connection','default');
		// SEO keywords
		config::set('seo_keywords_table',config::get('prefix_table').'seo_keywords');
		config::set('seo_keywords_connection','default');
	
	// Galleries
	// TODO

// Media
config::set('media_table',config::get('prefix_table').'media');
config::set('media_connection','default');
	// Media folders
	config::set('media_folders_table',config::get('prefix_table').'media_folders');
	config::set('media_folders_connection','default');
config::set('galleries_table',config::get('prefix_table').'galleries');
config::set('galleries_connection','default');
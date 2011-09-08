<?php if(!defined('SWAMI')){die('External Access to File Denied');}
/*
 * controller:	Settings
 * @author:			Jeroen Desloovere <info@jeroendesloovere.com>
 * @year:				2011
 * @project:		Swami CMS
 */

class settings_controller extends backend_controller
{
	// Index
	// ---------------------------------------
	public function index()
	{
		// Get all settings
		set('settings', array());
		set('permissions',acl::get('settings'));
			
		// View
		view('settings/index');
	}
	
	// Settings
	// ---------------------------------------
	public function save()
	{
		// Permission to "edit"
		if(acl::get('settings')->isAllowed(user::type(),'edit'))
		{
			// Save all settings
			$settings = input::post('settings');
			
			// TODO: save settings
			
			// View
			url::redirect('admin/settings');
		}
		// No permission to "view"
		else url::redirect('admin');
	}
}
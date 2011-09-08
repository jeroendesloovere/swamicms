<?php if(!defined('SWAMI')){die('External Access to File Denied');}

class stats_controller extends backend_controller
{
	// All
	public function index()
	{
		view('settings/index');
	}
}
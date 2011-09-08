<?php if(!defined('SWAMI')){die('External Access to File Denied');}

class modules_controller extends backend_controller
{
	// Index
	// ------------------------------------------------
	public function index()
	{
		$all = load::model('modules')->all();
		
		view('modules/index');
	}
}
<?php if(!defined('SWAMI')){die('External Access to File Denied');}


class search_controller extends backend_controller
{
	// All
	public function index()
	{
		echo "search";
		$this->view();
	}
}
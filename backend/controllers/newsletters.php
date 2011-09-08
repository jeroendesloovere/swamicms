<?php if(!defined('SWAMI')){die('External Access to File Denied');}
/*
 * controller:			Newsletters
 * parent controller:	Backend controller
 * author:				Jeroen Desloovere <info@jeroendesloovere.com>
 * date:				2011
 * project:				Swami CMS
 */
class newsletters_controller extends backend_controller
{
	// TODO
	// Index
	// ---------------------------------------
	public function index()
	{
		view('newsletters/index');
	}
	
	// TODO
	// Subscribers
	// ---------------------------------------
	public function subscribers()
	{
		view('newsletters/index');
	}
	
	// TODO
	// Campaigns
	// ---------------------------------------
	public function campaigns()
	{
		view('newsletters/index');
	}
	
	// TODO
	// Reports
	// ---------------------------------------
	public function reports()
	{
		view('newsletters/index');
	}
}
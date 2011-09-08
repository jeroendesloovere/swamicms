<?php if(!defined('SWAMI')){die('External Access to File Denied');}
/*
 * controller:			Tags
 * parent controller:	Backend controller
 * author:				Jeroen Desloovere <info@jeroendesloovere.com>
 * date:				2011
 * project:				Swami CMS
 */

class tags_controller extends backend_controller
{	
	// Index
	// ---------------------------------------
	public function index()
	{		
		if(!user::valid()) url::redirect('admin/login');
		
		// Get pages
		$pages = load::model('page')->getAll();
		
		// View pages
		$this->view('pages/index', array('pages'=>$pages));
	}
	/*
	// Add tag
	// ---------------------------------------
	public function add( $parent_id=false )
	{
		if(!user::valid()) url::redirect('admin/login');
		
		// Get page
		$tag = load::model('Tag')->get($id);
		
		// View
		$this->view('tags/tag', array('tag'=>$tag));
	}
	
	// Edit tag
	// ---------------------------------------
	public function edit( $id )
	{
		if(!user::valid()) url::redirect('admin/login');
		
		// Get
		$tag = load::model('Tag')->get($id); // Page
		
		// View
		$this->view('tags/tag', array('tag'=>$tag));
	}
	
	// Save tag
	// ---------------------------------------
	public function _save()
	{
		if(!user::valid()) url::redirect('admin/login');
	}
	
	// Delete tag
	// ---------------------------------------
	public function delete()
	{
		if(!user::valid()) url::redirect('admin/login');
		
	}
	*/
}
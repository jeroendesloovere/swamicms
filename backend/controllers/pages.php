<?php if(!defined('SWAMI')){die('External Access to File Denied');}
/*
 * controller:			Pages
 * author:				Jeroen Desloovere <info@jeroendesloovere.com>
 * date:				2011
 * project:				Swami CMS
 */
 
class pages_controller extends backend_controller
{
	// Index
	// ---------------------------------------
	public function index()
	{
		//dump($_POST);
		//dump(load::model('gallery')->from('page',1),'gallerijen');
		/*// Set variables
		set('pages', load::model('page')->getAll());
		set('permissions', acl::get('pages'));
*/
		// View pages
		view('pages/index');
	}
	
	// Add page
	// ---------------------------------------
	public function add( $parent_id = false )
	{
		// Get page
		$page = load::model('page')->get($id);
		if($parent_id!==false) $page->parent_id = $parent_id;
		set('page', $page);
		
		// Get pages
		set('pages', load::model('page')->all());
		
		// View
		view('pages/edit');
	}
	
	// Edit page
	// ---------------------------------------
	public function edit( $id )
	{
		// Set
		set('page', load::model('page')->get($id));
		set('modules', load::model('modules')->get('page',$id));
		set('pages', load::model('page')->getAll());
		
		// View
		breadcrumb($page->name);
		view('pages/edit');
	}
	
	// Save page
	// ---------------------------------------
	public function save()
	{
		
	}
	
	// Delete page
	// ---------------------------------------
	public function delete()
	{
		
	}
	
	// TODO
	// Reorder pages
	// ---------------------------------------
	public function reorder()
	{
		if(isAllowed('reorder')&&input::ajax())
		{
			// Get pages
			$pages = input::post('items');
			
			// TODO
			// Save pages
			
			// Return
			echo json_encode(array('success'=>true,'msg'=>__('saved')));
		}
		else echo json_encode(array('error'=>true,'msg'=>__('no_permission_for_action')));
	}
}
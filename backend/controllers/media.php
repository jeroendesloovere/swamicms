<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Media controller
 *
 * @author          Jeroen Desloovere <info@jeroendesloovere.com>
 * @date			03-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */
 
class media_controller extends backend_controller
{
	// All
	// ------------------------------------------------
	public function index()
	{
		// TODO: Get folders
		// set('folders', '');
		
		// TODO: Get media in folder
		// set('folders', '');
		
		// View
		view('media/index');
	}
	
	// Delete
	// ------------------------------------------------
	public function delete( $file_id = false )
	{
		$file = load::model('File');
		//$file->delete();
	}
	
	// Delete (Ajax)
	// ------------------------------------------------
	public function delete_ajax($file = null)
	{
		// get file - Ajax
		if(empty($file)) $file = input::post('file');
		
		// delete file
		if(!empty($file)){
			/*
			load::model('file');
			$file = new File($file_id);
			$file->delete();
			*/
		}else die('error: file not found');
	} 	
}
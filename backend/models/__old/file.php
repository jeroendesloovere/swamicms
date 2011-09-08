<?php if(!defined('SWAMI')){die('External Access to File Denied');}

class File_model
{
	public static $table;
	
	private static $files;
	
	public $id = false;
	public $folder_id = false;
	public $name = false;
	public $path = false;
	
	public $title = false;
	public $type = false; // image or file
	public $user_id = false;
	
	public $filepath = false;
	public $url = false;
	public $thumb_url = false;
	
	// get all files
	// ------------------------------------------------
  	public function getAll()
  	{
  		if(!isset(self::$files)){
  			// query
  			$files = self::$table->all();
  			
  			// handle files
  			self::$files = $this->handleFiles($files);
  		}
		return self::$files;
	}
	
	// get all from folder
	// ------------------------------------------------
  	public function getAllFromFolder( $folder = false, $subfolder = false )
  	{
  		if(!isset(self::$files)){
  			if($folder===false) $folder = 0;
  			echo "folder_id =".$folder_id = load::model('Folder')->get($folder);
  			
  			// query: get files from subfolder as well?
			echo "todo: getAllFromFolder : file from subfolders ";
			$files = self::$table->select('folder_id','=',$folder_id);
			
			// handle files
			return $this->handleFiles($files);
  		}
  		else{
  			// todo: haal files van die bepaalde folder
  			// todo: haal files van subfolders	
			return $files;
  		}
	}
		
	// handle files
	// ------------------------------------------------	
	private function handleFiles( $files )
	{
		$arr = array();
		foreach($files as $file){
			$file->path = load::model('Folder')->get($file->folder_id);
			$file->filepath = $file->path.'/'.$file->name;
			$file->url = BASE_URL.$file->path.'/'.$file->name;
			$file->thumb_url = BASE_URL.$file->path.'/_thumbs/_'.$file->name;
			$arr[] = $file;
		}
		return $arr;
	}
	
	// get file by id or name
	// ------------------------------------------------
  	public function get($file = false)
  	{
		if($file){
			echo "todo: get file from database, set $this->file_id and $this->filename";
			echo "todo: check permissions if person has right to delete this file","<br/>";
			// $this->file_id = ;
			// $this->filename = ;
			$this->filepath = $this->path.'/'.$this->name;
			$this->url = BASE_URL.$this->path.'/'.$this->name;
			return $this->file_id;
		}else{
			return false;
			die('error: file or file id required');	
		}
	}
	
	// delete from id
	// ------------------------------------------------
  	public function delete($id = false){
  		// get id if not in params
  		if(!$id) $this->get($id);
  		
  		// delete file if found
		if($this->id){
			// Delete the file from database
			echo "delete file with id = ".$file_id." from database";
			$table = self::$table->delete('id','=',$this->id);
			
			// Delete the file on server
			echo "todo: delete file with filename = ".$this->id."";
			
			return true;
		}else{
			return false;
			die('error: file id required');
		}
  	}
}

// Load config file
load::config('file');

// Set database table
File_model::$table = db(config::get('file_table'),NULL,config::get('file_connection'));
?>
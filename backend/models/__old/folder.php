<?php if(!defined('SWAMI')){die('External Access to File Denied');}

class Folder_model
{
	public static $table;
	
	private static $folders;
	
	public $id = false;
	public $path = false;
	
	
	// get all folders
	// ------------------------------------------------
  	public function getAll()
  	{
  		if(!isset(self::$folders)){
  			// query
  			$folders = self::$table->all();
  			
  			// handle folders
  			self::$folders = $this->handleFolders($folders);
  		}
		return self::$folders;
	}
	
	// get folder by id or name
	// ------------------------------------------------
  	public function getAllFromFolder( $folder = false, $subfolder = false)
  	{
		if($folder!==false){
			echo "todo: subfolders","<br/>";
			echo "todo: check permissions if person has right to delete this folder","<br/>";
			if($folder===0){ // find in root
				$folders = self::$table->select('parent','=','');
			}
			elseif((int)$folder){ // find by id
				$folders = self::$table->select('id','=',$folder);
			}
			else{ // find by path
				$paths = explode('/',$folder);
				
				if(count($paths)>1){
					$folders = self::$table->select('path','=',$paths[count($paths)-1]);
					foreach($folders as $row){
						$check = implode('/',self::getParentPath($row->parent_id)).'/'.$row->path;
						if($check==$folder){
							$this->id = $row->id;
							break;	
						}
					}
				}else{
					$folders = self::$table->select('path','=',$paths['0']);
					if($folders) $this->id = $folders['0']->id; 
				}	
			}
			if(count($folders)>0){
				$folders = self::handleFolders($folders['0']);
			}
			return $this->id;	
			
		}else{
			return false;
			die('error: file or file id required');	
		}
	}
	// get folder by id
	// ------------------------------------------------
  	public function get( $folder = false )
  	{
		if($folder!==false){
			if((int)$folder)
			{ // find by int
				if($folder===0){ // find in root
					$folders = self::$table->select('parent','=','');
					$this->id = 0;
					$this->path = '';
				}
				elseif((int)$folder){ // find by id
					$folders = self::$table->select('id','=',$folder);
					$this->path = $folders['0']->path;
					$this->id = $folders['0']->id;
				}
				// return path
				return $this->path;
			}
			else{ // find by path
				$paths = explode('/',$folder);
				
				if(count($paths)>1){
					$folders = self::$table->select('path','=',$paths[count($paths)-1]);
					foreach($folders as $row){
						$check = implode('/',self::getParentPath($row->parent_id)).'/'.$row->path;
						if($check==$folder){
							$this->id = $row->id;
							break;	
						}
					}
				}else{
					$folders = self::$table->select('path','=',$paths['0']);
					if($folders) {$this->id = $folders['0']->id; }
				}		
				// return id
				return $this->id;
			}
		}else{
			return false;
			die('error: file or file id required');	
		}
	}
	
	// get parent path of folder
	// ---------------------------------------------------------------------------
	public function getParentPath( $parent_id, $parents = array() ){
		// search query
		$folder = self::$table->select('id','parent_id','path')->where('id','=',$parent_id)->execute();
		
		if($folder){		
			// return loop?
			$parents[] = $folder['0']->path;
			if($folder['0']->parent_id!=0) return self::getParentPath( $folder['0']->parent_id, $parents );
		}
		return $parents;
	}	
	
	// Privates
	// ------------------------------------------------  	
	// handle folders
	// ------------------------------------------------
  	private function handleFolders( $folders )
	{
		$arr = array();
		$paths = array();
		foreach($folders as $folder){
			if(!in_array($folder->path, $paths)){
				echo "todo: get parent_folder","<br/>";
				$parent = implode('/',self::getParentPath($folder->parent_id));
				if($parent) $folder->path = $parent.'/'.$folder->path;
				$arr[] = $folder;
				$paths[] = $folder->path;	
			}
		}
		array_multisort($paths, SORT_ASC, $arr);
		return $arr;
	}
}
// Load config file
load::config('folder');

// Set database table
Folder_model::$table = db(config::get('folder_table'),NULL,config::get('folder_connection'));
?>
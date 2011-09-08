<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Media model
 *
 * @author          Jeroen Desloovere <info@jeroendesloovere.com>
 * @date			04-06-2011
 * @copyright		2011
 * @project			Swami
 * @project page    http://www.swami.be
 */
 
class Media extends AppModel
{
	public static $table;
	
	// Get
	// ------------------------------------------------------------
	public static function get($i)
	{
		// Get by id
		if(is_array($i))
		{
			$get = self::$table->select('*');
			
			$get->where('id','=',$i);
			for($j=1; $j<count($i); $j+=1)
			{
				$get->clause('OR');
				$get->where('id','=',$i[$j]);
			}
			$all = $get->execute();
			return $all;
		}
		elseif((int)$id)
		{
			$media = self::$table->select('*')
								->where('id','=',$id)
								->limit(1)
								->execute();
		}
		
		// If media are found
		if(!empty($media[0]))
		{
			return $media[0];
		}
		// Otherwise return false
		return false;
	}
	
	// Get all
	// ------------------------------------------------------------
	public static function getAll()
	{
		// Limit number of results
		$limit = 10;
		
		// Current page
		$current_page = 2;
		
		// Returns 10 rows starting at row 10
		$data = $table->select('*')
					  ->paginate($current_page,$limit,$page)
					  ->execute();
		
		// If media are found
		if(!empty($data)) return $data;
		
		// Otherwise return false
		return false;
	}
	
}

// Set database table
Media::$table = db(config::get('media_table'),NULL,config::get('media_connection'));
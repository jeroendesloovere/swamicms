<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Gallery model
 *
 * @author: 	Jeroen Desloovere
 * @date: 		08-01-2011 
 */
 
class Gallery extends AppModel
{
	public static $table;
		
	// Get - by id -> returns 1 gallery 
	// ---------------------------------------------------------------------------
	public static function get($i)
	{
		if((int)$i)
		{
			$item = self::$table->select('*')
					->where('id','=',$i)
					->limit(1)
					->execute();
			if(!empty($item[0]))
			{
				// Get media
				$item[0]->media = load::model('Media')->get(json_decode($item[0]->media,true));
				return $item[0];
			}
		}
		return false;
	}
	
	// From - module and module_id -> returns multiple galleries
	// ---------------------------------------------------------------------------
	public static function from($module, $module_id)
	{
		if(in_array($module, config::get('modules'))&&(int)$module_id)
		{
			$all = self::$table->select('*')
								->where('module','=',$module)
								->clause('AND')
								->where('module_id','=',$module_id)
								->execute();
		
			if(!empty($all))
			{
				$count = count($all);
				for($i=0; $i<$count; $i+=1)
				{
					//$media = load::model('Media')->get(json_decode($all[$i]->media,true));
					$all[$i]->media = load::model('Media')->get(json_decode($all[$i]->media,true));
				}
				return $all;
			}
		}
		return false;
	}
	
}

// Set database table
Gallery::$table = db(config::get('galleries_table'),NULL,config::get('galleries_connection'));
<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * seo keywords model
 *
 * @author: 	Jeroen Desloovere
 * @date: 		08-01-2011 
 */
 
/**
 * todo
 *
 */
 
class SeoKeyword extends AppModel
{
	public static $table;
	
	// Get
	// ---------------------------------------------------------------------------
	public static function get( $id )
	{
		// Find by id
		if($id)
		{
			$keyword = self::$table->select('*')
								->where('id','=',$id)
								->limit(1)
								->execute();
		
			// If seo are found
			if(!empty($keyword[0])) return $keyword[0];
		}
		// Otherwise return FALSE
		return FALSE;
	}
}

// Set database table
SeoKeyword::$table = db(config::get('seo_keywords_table'),NULL,config::get('seo_keywords_connection'));
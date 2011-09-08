<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * seo model
 *
 * @author: 	Jeroen Desloovere
 * @date: 		08-01-2011 
 */
 
/**
 * todo
 *
 * @onderaan: 	// Get current SEO, id staat voorlopig op 1, dat moet dan aangepast worden naar de juiste pagina
 * @get: 		@return => keywords moet array zijn via SeoKeywords_model
 * @keywords: 	indien er een keywoord gekoppeld is dat niet meer bestaat, 
 				dan moet dat automatisch ook verwijderd worden uit die array en opgeslagen worden
				onder if(is_object($item)) moet een else komen die alle items bijhoud die niet bestaan, dan uit de foreach moeten die verwijderd worden
 */
 
class Seo
{
	public static $table;
	
	public static $_id;
	public static $_title;
	public static $_keywords;
	public static $_description;
	public static $_slug;
	
	public static $_added_keywords = array();
	public static $_added_keywords_position = 'after';
	
	// Get
	// ---------------------------------------------------------------------------
	public static function get($i)
	{
		// Find by id
		if((int)$i)
		{
			$seo = self::$table->select('*')
								->where('id','=',$i)
								->limit(1)
								->execute();
		
			// If seo are found
			if(!empty($seo[0]))
			{
				// Get Keywords
				$keywords = json_decode($seo[0]->keywords);
				$allKeywords = array();
				$size = count($keywords);
				for($i=0; $i<$size; $i+=1)
				{
					$item = load::model('seoKeyword')->get($keywords[$i]);
					if(is_object($item)) $allKeywords[] = $item;
					else $remove[] = $keywords[$i];	
				}
				
				// Self cleaning: Update keywords when a keyword couldn't be found on the page
				if(config::get('self_cleaning')&&isset($remove)) self::selfCleaningKeywords($remove, $keywords, $seo[0]->id);
				
				// Set Keywords
				$seo[0]->keywords = $allKeywords;
				
				return $seo[0];
			}
		}
		// Find by slug
		elseif((string)$i)
		{
			$arr = explode((string)$i);
			$seo = self::$table->select('*')
								->where('slug','=',$arr[count($arr)-1])
								->limit(1)
								->execute();
		}
		
		// Otherwise return FALSE
		return FALSE;
	}
	
	// ID
	// ---------------------------------------------------------------------------
	public static function id()
	{
		return self::$_id;
	}
	
	// Title
	// ---------------------------------------------------------------------------
	public static function title()
	{
		return self::$_title;
	}
	
	// Keywords
	// ---------------------------------------------------------------------------
	public static function keywords( $sep=', ' )
	{
		$keywords = array();
		
		// Get all keywords
		$size = count(self::$_keywords);
		for($i=0; $i<$size; $i+=1)
		{
			$item = load::model('seoKeyword')->get(self::$_keywords[$i]);
			if(is_object($item)) $keywords[] = $item->name; 
			else $remove[] = self::$_keywords[$i];
		}
		
		// Self cleaning: Update keywords when a keyword couldn't be found on the page
		if(config::get('self_cleaning')&&isset($remove)) self::selfCleaningKeywords($remove, self::$_keywords, self::id());
		
		// Add extra keywords on the fly
		switch(self::$_added_keywords_position)
		{
			case 'before': $keywords = array_merge(self::$_added_keywords, $keywords); break;
			case 'after': $keywords = array_merge($keywords, self::$_added_keywords); break;
		}		
		
		return implode($sep, $keywords);
	}
	
	// Add keywords
	// ---------------------------------------------------------------------------
	public static function addKeywords()
	{
		$args = func_get_args();
		
		// Check if first input is an array
		if(isset($args[0])&&is_array($args[0])) { 
			if(isset($args[1])&&$args[1]=='before') self::$_added_keywords_position = 'before';
			$args = $args[0]; 
		}
		// Check if it is not an array
		if(!is_array($args)) { $args = array($args); }
		
		// Add keywords
		self::$_added_keywords = array_merge(self::$_added_keywords, $args);
	}
	
	// Self Clean keywords when not existing anymore on the page
	// ---------------------------------------------------------------------------
	private static function selfCleaningKeywords( $remove_arr, $from_arr, $from_id )
	{
		foreach($remove_arr as $id)
		{
			unset($from_arr[array_search($id, $from_arr)]);
		}
		self::$table->update(array('keywords'=>json_encode($from_arr)))
					  ->where('id','=',$from_id)
					  ->execute();
	}
	
	// Description
	// ---------------------------------------------------------------------------
	public static function description()
	{
		return self::$_description;
	}
	
	// Slug
	// ---------------------------------------------------------------------------
	public static function slug()
	{
		return self::$_slug;
	}
}

// Set database table
Seo::$table = db(config::get('seo_table'),NULL,config::get('seo_connection'));

// Get current page
if(config::get('current_page_id'))
{
	// current page id
	$id = config::get('current_page_id');
	
	// Get current SEO
	$seo = Seo::$table->select('*')
						->where('id','=',$id)
						->limit(1)
						->execute();
	
	// If exists
	if(!empty($seo[0]))
	{
		$seo = $seo[0];
		Seo::$_id = $seo->id;
		Seo::$_title = $seo->title;
		Seo::$_keywords = json_decode($seo->keywords,true);
		Seo::$_description = $seo->description;
		Seo::$_slug = $seo->slug;
	}
}
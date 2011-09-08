<?php if(!defined('SWAMI')){die('External Access to File Denied');}
/*
 * model:				Media
 * author:				Jeroen Desloovere <info@jeroendesloovere.com>
 * date:				08-01-2011 
 * project:				Swami CMS
 */

/**
 * todo
 *
 * function unique($parent_id) aanmaken => checks if a unique url exists on a certain parent...
 */ 
 
class Page extends AppModel
{
	public static $table;
	
	public static $id;
	public static $parent_ids;
	public static $lang;
	public static $name;
	public static $nav_name;
	public static $in_navigation;
	public static $_layout_id;
	public static $created_on;
	public static $changed_on;
	public static $published_on;
	public static $vis;
	public static $pos;
	
	public static $url;
	public static $parents;
	
	// Get
	// ------------------------------------------------------------
	public static function get($i)
	{
		// Find by id
		if((int)$i)
		{
			$page = self::$table->select('*')
								->where('id','=',$i)
								->limit(1)
								->execute();
		}
		// Find by slug
		elseif((string)$i)
		{
			$seo = SEO::get($i);
		}
		
		// Result
		// If pages are found
		if(!empty($page[0])){
			$page[0]->parent_ids = json_decode($page[0]->parent_ids);
			return $page[0];
		}
		// Otherwise return FALSE
		return FALSE;
	}
	
	// Get all
	// ------------------------------------------------------------
	public static function getAll()
	{
		// Get
		$pages = self::$table->select('*')->execute();
	
		// If pages are found
		if(!empty($pages)){
			foreach($pages as $page)
			{
				$page->parent_ids = json_decode($page->parent_ids);
				
				// Get url
				$size = count($page->parent_ids);
				$items = $slugs = array();
				for($i=0; $i<$size; $i+=1)
				{
					if(!empty($page->parent_ids[$i]))
					{
						$items = load::model('modules')->get('page',$page->parent_ids[$i],'seo');
						if(is_object($items[0])) $slugs[] = $items[0]->slug;
					}	
				}
				
				// Get own url
				$items = load::model('modules')->get('page',$page->id,'seo');
				if(is_object($items[0])) $slugs[] = $items[0]->slug;
				
				// Set url
				$page->url = implode('/',$slugs);
			}
			return $pages;
		}
		
		// Otherwise return FALSE
		else return FALSE;
	}
	
	// ID
	// ------------------------------------------------------------
	public static function id()
	{
		return self::$id;
	}
	
	// Parents
	// ------------------------------------------------------------
	public static function parents()
	{
		// If first time, get parents
		if(empty(self::$parents))
		{
			foreach(self::$parent_ids as $id)
			{
				self::$parents[] = self::get($id);
			}
		}
		return self::$parents;
	}
	
	// Url
	// ------------------------------------------------------------
	public static function url()
	{
		// If first time making the url
		if(empty(self::$url))
		{
			// Make url
			$parents = self::parents();
			$size = count($parents);
			for($i=0; $i<$size; $i+=1)
			{
				if(!empty($parents[$i]->id))
				{
					$items = load::model('modules')->get('page',$parents[$i]->id,'seo');
					if(is_object($items[0])) $slugs[] = $items[0]->slug;
				}	
			}
			
			// Get own url
			$items = load::model('modules')->get('page',self::$id,'seo');
			if(is_object($items[0])) $slugs[] = $items[0]->slug;
			
			// Set url
			self::$url = implode('/',$slugs);
		}
		
		// Return url
		return url::base().self::$url;
	}
	
	// Name
	// ------------------------------------------------------------
	public static function name()
	{
		return self::$name;
	}
	
	// Nav_name
	// ------------------------------------------------------------
	public static function nav_name()
	{
		return self::$nav_name;
	}
	
	// In_navigation
	// ------------------------------------------------------------
	public static function in_navigation()
	{
		return self::$in_navigation;
	}
	
	// Layout_id
	// ------------------------------------------------------------
	public static function layout_id()
	{
		return self::$_layout_id;
	}
	
	// Created_on
	// ------------------------------------------------------------
	public static function created_on()
	{
		return self::$created_on;
	}
	
	// Changed_on
	// ------------------------------------------------------------
	public static function changed_on()
	{
		return self::$changed_on;
	}
	
	// Published_on
	// ------------------------------------------------------------
	public static function published_on()
	{
		return self::$published_on;
	}
	
	// Visible
	// ------------------------------------------------------------
	public static function visible()
	{
		return self::$vis;
	}
	
	// Position
	// ------------------------------------------------------------
	public static function position()
	{
		return self::$pos;
	}
}

// Set database table
Page::$table = db(config::get('pages_table'),NULL,config::get('pages_connection'));

if(config::get('current_page_id'))
{
	// current page id
	$id = config::get('current_page_id');
	
	// Get current page
	$page = Page::$table->select('*')
						->where('id','=',$id)
						->limit(1)
						->execute();
	
	// If exists
	if(!empty($page[0]))
	{
		$page = $page[0];
		Page::$id = $page->id;
		Page::$parent_ids = json_decode($page->parent_ids, true);
		Page::$lang = $page->lang;
		Page::$name = $page->name;
		Page::$nav_name = $page->nav_name;
		Page::$in_navigation = $page->in_navigation;
		Page::$_layout_id = $page->_layout_id;
		Page::$created_on = $page->created_on;
		Page::$changed_on = $page->changed_on;
		Page::$published_on = $page->published_on;
		Page::$vis = $page->vis;
		Page::$pos = $page->pos;
	}
}
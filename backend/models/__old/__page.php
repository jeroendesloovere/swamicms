<?php

/**
 * page
 *
 * @author: Jeroen Desloovere
 * @date: 	9/11/2010 
 */
 
class __page_model
{
	public static $_id;
	public static $_parent_id;
	public static $_slug;
	public static $_full_slug;
	
	public static $_title;
	public static $_keywords;
	public static $_description;
	
	public static $_body = array();
	
	public static $_parent = false;
	public static $_parent_url;
	public static $_children;
	public static $_all_children;
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($page = null){
		if(!empty($page)) self::set($page);	
	}
	
	// GET
	// ---------------------------------------------------------------------------
	public function get($url)
	{
		// search query
		$page = db('pages')->select('*')
						   ->where('full_slug','=',$url)
						   ->clause('AND')
						   ->where('vis','=','1')
						   ->execute();
						   
		// return page, or return false
		if(!empty($page[0]))
		{
			self::set($page[0]);
			return $this;
		}
		else return false;
	}	
	
	// SET
	// ---------------------------------------------------------------------------
	private static function set($page){
		self::$_id = $page->id;
		self::$_parent_id = $page->parent_id;
		self::$_slug = $page->slug;
		self::$_full_slug = $page->full_slug;
		
		self::$_title = $page->title;
		self::$_keywords = $page->keywords;
		self::$_description = $page->description;
		
		self::$_body = array($page->body);	
	}
	
	// GET parent
	// ---------------------------------------------------------------------------
	public static function getParent($parent_id){
		// search query
		$parent = db('pages')->select('id','=',$parent_id);
		
		// set & return parent
		if($parent){
			self::$_parent = $parent['0'];
			self::$_parent_url = BASE_URL.$parent['0']->full_slug;
		}
		return self::$_parent;		
	}
	
	// GET children
	// ---------------------------------------------------------------------------
	public static function getChildren($id){
		// search query
		$arr = db('pages')->select('*')
						  ->where('parent_id','=',$id)
						  ->clause('AND')
						  ->where('VIS','=',1)
						  ->order_by('pos','ASC')
						  ->execute();
		
		// set & return children
		if(!empty($arr)&&count($arr)>0){
			$children = array();
			$countChildren = count($arr);
			for($i=0; $i<$countChildren; $i+=1){
				$arr[$i]->url = BASE_URL.$arr[$i]->full_slug;
				$arr[$i]->link = '<a href="'.$arr[$i]->url.'" title="'.$arr[$i]->title.'">'.$arr[$i]->title.'</a>';
				$children[] = $arr[$i];	
			}	
			return $children;
		}
		else return false;
	}
	// GET all children
	// ---------------------------------------------------------------------------
	public static function getAllChildren($id, $children = false){
		// search query
		$arr = db('pages')->select('*')
						  ->where('parent_id','=',$id)
						  ->clause('AND')
						  ->where('VIS','=',1)
						  ->order_by('pos','ASC')
						  ->execute();
		
		// set & return children
		if(!empty($arr)&&count($arr)>0){
			$countChildren = count($arr);
			for($i=0; $i<$countChildren; $i+=1){
				$arr[$i]->url = BASE_URL.$arr[$i]->full_slug;
				$arr[$i]->link = '<a href="'.$arr[$i]->url.'" title="'.$arr[$i]->title.'">'.$arr[$i]->title.'</a>';
				$children[] = $arr[$i];	
				$children['children'] = self::getAllChildren($arr[$i]->id, $children);
			}	
		}
		return $children;
	}
		
	// GET siblings - same level
	// ---------------------------------------------------------------------------
	public static function getSiblings($parent_id){
		// search query
		$arr = db('pages')->select('*')
						  ->where('parent_id','=',$parent_id)
						  ->clause('AND')
						  ->where('VIS','=',1)
						  ->order_by('pos','ASC')->execute();
		
		// set & return children
		if(!empty($arr)&&count($arr)>0){
			$siblings = array();
			$countChildren = count($arr);
			for($i=0; $i<$countChildren; $i+=1){
				$arr[$i]->url = BASE_URL.$arr[$i]->full_slug;
				$arr[$i]->link = '<a href="'.$arr[$i]->url.'" title="'.$arr[$i]->title.'">'.$arr[$i]->title.'</a>';
				$siblings[] = $arr[$i];	
			}	
			return $siblings;
		}
		else return false;
	}
		
	// ID
	// ---------------------------------------------------------------------------
	public static function id(){
		return self::$_id;	
	}
	// Parent ID
	// ---------------------------------------------------------------------------
	public static function parent_id(){
		return self::$_parent_id;	
	}
	// Slug
	// ---------------------------------------------------------------------------
	public static function slug(){
		return self::$_slug;	
	}
	// Full slug
	// ---------------------------------------------------------------------------
	public static function full_slug(){
		return self::$_full_slug;	
	}
	
	// Url
	// ---------------------------------------------------------------------------
	public static function url($showBaseUrl = true){
		$url = '';
		if($showBaseUrl) $url .= BASE_URL;
		if(self::$_full_slug) $url .= self::$_full_slug;
		return $url;	
	}
	
	// Link
	// ---------------------------------------------------------------------------
	public static function link($label = null, $title = null){
		if($label == null) $label = self::title();
		if($title == null) $title = self::title();
		return '<a href="'.self::url(true).'" title="'.$title.'">'.$label.'</a>';	
	}
	
	// Title
	// ---------------------------------------------------------------------------
	public static function title(){
		return self::$_title;	
	}
	
	// Keywords
	// ---------------------------------------------------------------------------
	public static function keywords(){
		return self::$_keywords;	
	}
	
	// Description
	// ---------------------------------------------------------------------------
	public static function description(){
		return self::$_description;	
	}
	
	// Body
	// ---------------------------------------------------------------------------
	public static function body($name = ''){
		if(empty($name)) return self::$_body['0'];	
		else return self::$_body[$name];	
	}
	
	// Parent
	// ---------------------------------------------------------------------------
	public static function parent(){
		if(empty(self::$_parent)) self::getParent(self::parent_id());
		return self::$_parent;	
	}
	
	// Parent Url
	// ---------------------------------------------------------------------------
	public static function parent_url(){
		if(empty(self::$_parent)) self::getParent(self::parent_id());
		return self::$_parent_url;	
	}
	
	// Parent link
	// ---------------------------------------------------------------------------
	public static function parent_link($label = null, $title = null){
		if(empty(self::$_parent)) self::getParent(self::parent_id());
		if(!empty(self::$_parent)){
			if($label == null) $label = self::$_parent->title;
			if($title == null) $title = self::$_parent->title;
			return '<a href="'.self::$_parent_url.'" title="'.$title.'">'.$label.'</a>';
		}else return self::link();
	}
	
	// Children
	// ---------------------------------------------------------------------------
	public static function children(){
		if(!isset(self::$_children)) self::$_children = self::getChildren(self::id());
		return self::$_children;	
	}
	
	// All children
	// ---------------------------------------------------------------------------
	public static function all_children(){
		if(!isset(self::$_all_children)) self::$_all_children = self::getAllChildren(self::$_id);
		return self::$_all_children;	
	}
	
	// Navigatie
	// ---------------------------------------------------------------------------
	public static function nav($parent_id = '0'){
		$pages = self::getSiblings($parent_id);
		if($pages){
		$list = array();
			$countPages = count($pages);
			for($i=0; $i<$countPages; $i+=1){
				$pages[$i]->current  = $pages[$i]->id==self::$_id ? true : false; 
				$list[] = $pages[$i];
			}	
		}
		return $list;
	}
	
	// Navigatie lijst
	// @todo: ervoor zorgen dat children onderdeel worden van parents
	// @todo: current item aanduiden
	// @todo: verdere children zoeken
	// @todo: meer parents zoeken?
	// ---------------------------------------------------------------------------	
	public function nav_list($idName = 'main_nav', $separator='', $showAllChildren = false){
		$pages = self::nav();
		$list = '<ul';
		$list .= $idName!='' ? ' id="'.$idName.'">' : '>';
		foreach($pages as $page){
			$list .= '<li';
			$list .= $page->current ? ' class="current">' : '>';
			if($showAllChildren){
				$children = self::getChildren($page->id);
				if($children){
					foreach($children as $child){
					}
				}
			}
			$list .= $page->link.'</li>';
			$list .= '<li class="sep">'.$separator.'</li>';
		}
		return $list.'</ul>';
	}
	
}
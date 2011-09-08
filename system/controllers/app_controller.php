<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * App controller
 *
 * @author          Jeroen Desloovere
 * @date			04-05-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */
 
class app_controller
{
	protected static $layout = false;
	
	protected static $nav = array();
	protected static $subnav = array();
	protected static $content_parent;
	protected static $breadcrumb = false;
	
	public static $adds = array('css'=>array(),'js'=>array(),'dump'=>array());
	private static $vars = array();
	
	// Set layout
	// ------------------------------------------------------------
	public function init()
	{
		// load messages
		msg::load();
	}
		
	// Set layout
	// ------------------------------------------------------------
	public function setLayout($layout)
	{
		self::$layout = $layout;
	}
	
	// Add
	// ------------------------------------------------------------
	public static function addToLayout($type, $value, $attr = array())
	{
		if(!in_array($type, array('css','js','script'))) return false;
	
		// Set variables
		$place = ((isset($attr['place'])&&$attr['place']=='bottom')||$attr=='bottom') ? 'bottom':'top';
		if(isset($attr['place'])) unset($attr['place']);
		
		if(strpos($value, 'http')===false)
		{
			$base = WEBROOT;
			switch($type)
			{
				case 'css': $base .= 'css/'; break;
				case 'js': $base .= 'js/'; break;
			}
		}
		
		// Add variable
		self::$adds[$type][$place][] = array('url'=>((in_array($type,array('css','js'))&&isset($base))?$base:'').$value, 'attr'=>$attr);
	}
	
	// Add dump
	// ------------------------------------------------------------
	public static function addDump($trace, $name='')
	{
		self::$adds['dump'][] = array('name'=>$name, 'args'=>$trace['args'], 'file'=>$trace['file'], 'class'=>$trace['class'], 'method'=>$trace['method'], 'line'=>$trace['line']);
	}
	
	// Set
	// ------------------------------------------------------------
	public static function assignToLayout($key, $value)
	{
		self::$vars[$key] = $value;
	}
	
	// Get
	// ------------------------------------------------------------
	public static function getFromLayout($key)
	{
		return (isset(self::$vars[$key])) ? self::$vars[$key] : false;
	}
	
	// Nav
	// ------------------------------------------------------------
	public static function addNavToLayout($config_key)
	{
		self::$nav = $config_key;
	}
	
	// Breadcrumb
	// ------------------------------------------------------------
	public static function addBreadcrumbToLayout($breadcrumb)
	{
		self::$breadcrumb = $breadcrumb;
	}
	
	// TODO
	// Is allowed
	// ------------------------------------------------------------
	public static function isAllowed($resource = false, $type = false, $user_type = false)
	{
		// Library check
		load::library('acl');
		load::library('user');
		
		// Set
		if($resource===false)	$resource = route::method();
		if($type===false) 		$type = route::controller();
		if($user_type===false) 	$user_type = user::type();
		
		// Return permission access
		if(acl::get($type)->isAllowed($user_type,$resource)) return true;
		else return false;
	}
	
	// View
	// ------------------------------------------------------------
	public static function renderLayout($view, $vars = false)
	{
		// Set
		if($vars) foreach($vars as $key => $value) self::assignToLayout($key, $value);
		self::$nav = config::get(self::$nav);

		// Set the parent + subnav
		if(isset(self::$nav[route::controller()])){ self::$content_parent = route::controller(); self::$subnav = self::$nav[route::controller()]; }
		else{ foreach(self::$nav as $key => $values){ if(isset($values[route::controller()])){ self::$content_parent = $key; self::$subnav = self::$nav[$key]; break;}} }

		// View
		if(!self::$layout) self::$layout = $view;
		return load::view(self::$layout, array('content_vars'=>self::$vars,'content_view'=>$view,'content_nav'=>self::$nav,'content_subnav'=>self::$subnav,'content_parent'=>self::$content_parent,'content_breadcrumb'=>self::$breadcrumb,'content_css'=>self::$adds['css'],'content_js'=>self::$adds['js'],'content_dump'=>self::$adds['dump']));

		/*
		if($vars) foreach($vars as $key => $value) self::set($key, $value);
		load::view($view, array_merge(self::$vars, self::$adds));
		*/
	}
	
} // END app controller

if(!function_exists('add'))
{
	function add($type, $value, $place = false)
	{
		app_controller::addToLayout($type, $value, $place);
	}
}
if(!function_exists('set'))
{
	function set($key, $value)
	{
		app_controller::assignToLayout($key, $value);
	}
}
if(!function_exists('get'))
{
	function get($key)
	{
		return app_controller::getFromLayout($key);
	}
}
if(!function_exists('view'))
{
	function view($view, $vars = false)
	{
		app_controller::renderLayout($view, $vars);
	}
}
if(!function_exists('breadcrumb'))
{
	function breadcrumb($breadcrumb)
	{
		app_controller::addBreadcrumbToLayout($breadcrumb);
	}
}
if(!function_exists('isAllowed'))
{
	function isAllowed($resource = false, $type = false, $user_type = false)
	{
		return app_controller::isAllowed($resource, $type, $user_type);
	}
}
// TODO: make a layout for this dump (backend and frontend)
if(!function_exists('dump'))
{
	function dump($data, $name = '')
	{
		$trace = debug_backtrace();
		$trace['file'] = $trace[0]['file'];
		$trace['line'] = $trace[0]['line'];
		$trace['class'] = (isset($trace[1]['class'])) ? $trace[1]['class'] : '';
		$trace['method'] = $trace[1]['function'];
		$trace['args'] = $trace[0]['args'];
		if(APPLICATION == BACKEND) app_controller::addDump($trace, $name);
		else{ echo '<br/><br/>'; print_r($trace); echo '<br/><br/>';}
	}
}
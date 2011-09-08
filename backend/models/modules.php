<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * modules model
 *
 * @author: 	Jeroen Desloovere
 * @date: 		08-01-2011 
 */
 
class Modules
{	
	public static $modules;
	
	// Add
	// ------------------------------------------------------------
	public static function add($type, $module)
	{
		self::$modules[$type][] = $module;
	}
	
	// All
	// ------------------------------------------------------------
	public static function all($type=false)
	{
		if((string)$type) return self::$modules[$type];
		else return self::$modules;
	}
}

// Add default modules
foreach(config::get('modules') as $m)
{
	Modules::add('modules',$m);
}
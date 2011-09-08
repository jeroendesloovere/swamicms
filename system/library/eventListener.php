<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * EventListener
 *
 * @Author          Jeroen Desloovere
 * @Copyright       2011
 * @Project Page    http://www.swami.be
 */

class EventListener
{
	private static $_listeners = array();

	// All
	// ------------------------------------------------------
	public static function all($listener = false)
	{
		return ($listener===false) ? self::$_listeners : ((isset(self::$_listeners[$listener])) ? self::$_listeners[$listener] : false);
	}
	
	// Add
	// ------------------------------------------------------
	public static function add($listener, $action)
	{
		$action = str_replace('()', '', $action);
		self::$_listeners[$listener][] = $action;
	}
	
	// Rename
	// ------------------------------------------------------
	public static function rename($listener, $new_listener)
	{
		if(isset(self::$_listeners[$listener]))
		{
			$arr = self::$_listeners[$listener];
			unset(self::$_listeners[$listener]);
			self::$_listeners[$new_listener] = $arr;
		}
		else echo "listener doesn't exists"; 
	}

	// Dispatch
	// ------------------------------------------------------
	public static function dispatch($listener, $variables = false)
	{
		if(isset(self::$_listeners[$listener]))
		{
			$count = count(self::$_listeners[$listener]);
			for($i=0; $i<$count; $i+=1)
			{
				call_user_func(self::$_listeners[$listener][$i], $variables);
			}
		}
		else echo "listener doesn't exists";
	}

	// Delete
	// ------------------------------------------------------
	public static function delete($listener, $action = false)
	{
		if($action!==false&&isset(self::$_listeners[$listener]))
		{
			$count = count(self::$_listeners[$listener]);
			for($i=0; $i<$count; $i+=1)
			{
				if(self::$_listeners[$listener][$i]==$action) unset(self::$_listeners[$listener][$i]);
			}
		}
		elseif(isset(self::$_listeners[$listener])) unset(self::$_listeners[$listener]);
	}	
}
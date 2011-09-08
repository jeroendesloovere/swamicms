<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Message Library For Dingo Framework
 *
 * @author          Jeroen Desloovere
 * @copyright       25-04-2011
 */

if(!function_exists('__'))
{
	function __($name, $replacements=array())
	{
		return ucfirst(msg::get($name, $replacements));
	}
}
if(!function_exists('e__'))
{
	function e__($name, $replacements=array())
	{
		echo ucfirst(msg::get($name, $replacements));
	}
}
if(!function_exists('___'))
{
	function ___($name, $replacements=array())
	{
		return msg::get($name, $replacements);
	}
}
if(!function_exists('e___'))
{
	function e___($name, $replacements=array())
	{
		echo msg::get($name, $replacements);
	}
}

// msg
// ===========================================================================
class msg
{
	private static $msgs;
	
	// Get message
	// ---------------------------------------------------------------------------
	public static function get($name, $replacements=array())
	{
		// Get message
		if(isset(self::$msgs[$name])) $msg = self::$msgs[$name];
		else $msg = $name;
		
		// Find and replace replacements
		if(count($replacements)>0)
		{
			foreach($replacements as $key => $value)
			{
				$msg = str_replace($key, $value, $msg);
			}
		}
		return $msg;
	}
	
	// Set message
	// ---------------------------------------------------------------------------
	public static function set($name, $msg = false)
	{
		if(is_array($name))
		{
			foreach($name as $key => $value)
			{
				self::set($key, $value);
			}
		}
		else self::$msgs[$name] = $msg;
	}
	
	// Load messages
	// ---------------------------------------------------------------------------
	public static function load($language = DEFAULT_LANGUAGE)
	{
		load::language($language);
	}
}
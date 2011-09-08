<?php if(!defined('SWAMI')){die('External Access to File Denied');}
// client
// @author:				Jeroen Desloovere <info@jeroendesloovere.be>
// @date:					23-04-2011
// ===========================================================================
class client
{
	// Set by config
	public static $platforms;
	public static $browsers;
	public static $mobiles;
	public static $robots;
	
	// If run is ran
	private static $active = false;
	
	// Set by this class
	private static $agent;
	private static $platform;
	private static $browser;
	private static $mobile;
	private static $robot;
	private static $version;
	private static $languages;
	private static $charsets;
	private static $ip = false;

	// Run automatically when using a function that needs it
	// ---------------------------------------------------------------------------
	private static function run()
	{
		// Get + set agent
		self::agent();
		
		// Get + set platform
		self::setPlatform();

		// Get + set browser && mobile && robot
		foreach(array('setBrowser', 'setRobot', 'setMobile') as $function)
		{
			if(self::$function() === true)
			{
				break;
			}
		}
		
		// Set active
		self::$active = true;
	}

	// IP
	// ---------------------------------------------------------------------------
	public static function ip()
	{
		// Get previous IP?
		if(self::$ip !== false) return self::$ip;
		
		// Get IP
		self::$ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		
		// No IP found - try client IP
		if(isset($_SERVER['REMOTE_ADDR'])&&isset($_SERVER['HTTP_CLIENT_IP']))
		{
			self::$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		
		// Check IP
		if(!empty(self::$ip)&&strstr(self::$ip, ','))
		{
			$x = explode(',', self::$ip);
			$ip = trim(end($x));
		}
		
		// Not valid => returns a default IP
		load::library('validate');
		if(!valid::ip(self::$ip)) self::$ip = '0.0.0.0';
		
		// Return correct IP
		return self::$ip;
	}
	
	// Agent
	// ---------------------------------------------------------------------------
	public static function agent()
	{
		if(!isset(self::$agent)) self::$agent =  strtolower($_SERVER['HTTP_USER_AGENT']);
		return self::$agent;
	}
	
	// Platform
	// ---------------------------------------------------------------------------
	public static function platform()
	{
		// Run
		if(!self::$active) self::run();
		
		return self::$platform;
	}
	
	// Browser
	// ---------------------------------------------------------------------------
	public static function browser($versionNr = true)
	{
		// Run
		if(!self::$active) self::run();
		
		// Return browser with versionnr - ex: Firefox 0.9
		if($versionNr&&self::version()) return self::$browser.' '.self::version();
		
		// Return browser - ex: Firefox
		elseif(self::$browser) return self::$browser;
		
		// Is no browser
		else return false;
	}
	
	// Mobile
	// ---------------------------------------------------------------------------
	public static function mobile()
	{
		// Run
		if(!self::$active) self::run();
		
		if(isset(self::$mobile)) return self::$mobile;
		else return false;
	}
	
	// Robot
	// ---------------------------------------------------------------------------
	public static function robot()
	{
		// Run
		if(!self::$active) self::run();
		
		if(isset(self::$robot)) return self::$robot;
		else return false;
	}
	
	// Version number
	// ---------------------------------------------------------------------------
	public static function version()
	{
		// Run
		if(!self::$active) self::run();
		
		// Return version nr
		if(isset(self::$version)) return self::$version;
		
		// Return false
		else return false;
	}
	
	// Language - first
	// ---------------------------------------------------------------------------
	public static function language()
	{
		if(!isset(self::$languages)) self::setLanguages();
		return self::$languages[0];
	}
	
	// Languages - all
	// ---------------------------------------------------------------------------
	public static function languages()
	{
		if(!isset(self::$languages)) self::setLanguages();
		return self::$languages;
	}
	
	// Accept language?
	// ---------------------------------------------------------------------------
	public static function acceptLanguage($lang = 'en')
	{
		return (in_array(strtolower($lang), self::$languages(), true));
	}
	
	// Charset - first
	// ---------------------------------------------------------------------------
	public static function charset()
	{
		if(!isset(self::$charsets)) self::setCharsets();
		return self::$charsets[0];
	}
	
	// Charsets - all
	// ---------------------------------------------------------------------------
	public static function charsets()
	{
		if(!isset(self::$charsets)) self::setCharsets();
		return self::$charsets;
	}
	
	// Accept charset?
	// ---------------------------------------------------------------------------
	public static function acceptCharset($charset = 'utf-8')
	{
		return (in_array(strtolower($charset), self::$charsets(), true));
	}	
	
	// Set platform
	// ---------------------------------------------------------------------------
	private static function setPlatform()
	{
		if(is_array(self::$platforms) && count(self::$platforms) > 0)
		{
			foreach(self::$platforms as $key => $val)
			{
				if(preg_match("|".preg_quote($key)."|i", self::agent()))
				{
					self::$platform = $val;
					return true;
				}
			}
		}
		self::$platform = "Unknown platform";
	}
	
	// Set browser
	// ---------------------------------------------------------------------------
	private static function setBrowser()
	{
		if(is_array(self::$browsers) && count(self::$browsers) > 0)
		{
			foreach(self::$browsers as $key => $val)
			{
				if(preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", self::agent(), $match))
				{
					if(isset($match[1])) self::$version = $match[1];
					self::$browser = $val;
					self::setMobile();
					return true;
				}
			}
		}
		return false;
	}
	
	// Set robot
	// ---------------------------------------------------------------------------
	private static function setRobot()
	{
		if(is_array(self::$robots) && count(self::$robots) > 0)
		{
			foreach(self::$robots as $key => $val)
			{
				if(preg_match("|".preg_quote($key)."|i", self::agent()))
				{
					self::$robot = $val;
					return true;
				}
			}
		}
		return false;
	}
	
	// Set mobile
	// ---------------------------------------------------------------------------
	private static function setMobile()
	{
		if(is_array(self::$mobiles) && count(self::$mobiles) > 0)
		{
			foreach(self::$mobiles as $key => $val)
			{
				if(false !== (strpos(strtolower(self::agent()), $key)))
				{
					self::$mobile = $val;
					return true;
				}
			}
		}
		return false;
	}
	
	// Set languages
	// ---------------------------------------------------------------------------
	private static function setLanguages()
	{
		if((count(self::$languages) == 0) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '')
		{
			$languages = preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

			self::$languages = explode(',', $languages);
		}

		if(count(self::$languages) == 0)
		{
			self::$languages = array('Undefined');
		}
	}	
	
	// Set charsets
	// ---------------------------------------------------------------------------
	private static function setCharsets()
	{
		if ((count(self::$charsets) == 0) && isset($_SERVER['HTTP_ACCEPT_CHARSET']) && $_SERVER['HTTP_ACCEPT_CHARSET'] != '')
		{
			$charsets = preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));

			self::$charsets = explode(',', $charsets);
		}

		if (count(self::$charsets) == 0)
		{
			self::$charsets = array('Undefined');
		}
	}
}

load::config('user_agents',SYSTEM);
client::$platforms = config::get('platforms');
client::$browsers = config::get('browsers');
client::$mobiles = config::get('mobiles');
client::$robots = config::get('robots');
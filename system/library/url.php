<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Dingo Framework URL Library
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/url-helper
 */

class url
{
	// Base URL
	// ---------------------------------------------------------------------------
	public static function base($showIndex = false, $overwrite_mod_rewrite = false)
	{
		// Include "index.php"
		if($showIndex && (!MOD_REWRITE || $overwrite_mod_rewrite))
		{
			if(!empty($_SERVER['HTTPS'])){
				return(BASE_URL_SECURE.'index.php/'); 
			}
			else{
				return(BASE_URL.'index.php/');
			}
		}
		// Don't include "index.php"
		else
		{
			if(!empty($_SERVER['HTTPS'])){
				return(BASE_URL_SECURE); 
			}
			else{
				return(BASE_URL);
			}
		}
	}

	// Get URL
	// ---------------------------------------------------------------------------
	public static function get($path = false)
	{
		if($path){ $values = func_get_args(); $path = implode('/', $values); }
		return ((MOD_REWRITE) ? self::base() : self::base(true)).trim($path,'/');
	}

	// Redirect - Automatically checks for intern/extern page
	// ---------------------------------------------------------------------------
	public static function redirect($path = false)
	{
		$path = urldecode($path);
		$base = urldecode(self::base(true));
		
		// Redirect to ? extern page : intern page
		header('Location: '.((strpos($path, '://')!==false&&strpos($path, $base)===false) ? $path : ($base.str_replace($base, '', $path))));
		exit;
	}	
	
	// Referrer
	// ---------------------------------------------------------------------------
	public static function referrer()
	{
		// Referrer found
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '')
		{
			return $_SERVER["HTTP_REFERER"];
		}
		
		// Referrer not found
		else return false;
	}
		
	// Add key-value pair
	// ---------------------------------------------------------------------------
	public static function addKey($key, $value, $url)
	{
		list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
		parse_str($qspart, $qsvars);
		
		// Check if key is already used
		if(isset($qsvars[$key]))
		{
			$qsvars[$key] = $value;
			$newqs = http_build_query($qsvars);
			return $urlpart.'?'.$newqs;
		}
		else
		{		
			if(empty($qspart)) return $url = $urlpart.'?'.$key.'='.$value;
			else return $url .= '&'.$key.'='.$value;
		}
	}
	
	// Delete key-value pair
	// ---------------------------------------------------------------------------
	public static function deleteKey($key, $url)
	{
		list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
		parse_str($qspart, $qsvars);
		if(is_array($key))
		{
			foreach($key as $k)
			{
				unset($qsvars[$k]);
			}
		}
		else unset($qsvars[$key]);
		$newqs = http_build_query($qsvars);
		
		// Returns url without that key-value pair
		if(!empty($newqs)) return $urlpart.'?'.$newqs;
		else return $urlpart;
	}
	
	// Deletes key-value pairs from querystring
	// ---------------------------------------------------------------------------
	public static function deleteKeys($key_arr, $url)
	{
		return self::deleteKey($key_arr, $url);
	}
	
	// Deletes all key-value pairs and also ?
	// ---------------------------------------------------------------------------
	public static function deleteAllKeys($url)
	{
		list($urlpart) = array_pad(explode('?', $url), 2, '');
		return $urlpart;
	}
	
	// Allow only this key-value pair
	// ---------------------------------------------------------------------------
	public static function allowKey($key, $url)
	{
		list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
		parse_str($qspart, $qsvars);
		
		// Returns url with only that key-value pair
		if(isset($qsvars[$key])) return $urlpart.'?'.$key.'='.$qsvars[$key];
		else return $urlpart;
	}
	
	// Allow only this key-value pairs
	// ---------------------------------------------------------------------------
	public static function allowKeys($key_arr, $url)
	{
		list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
		parse_str($qspart, $qsvars);
		foreach($key_arr as $key) $newvars[$key] = $qsvars[$key];
		
		// Returns url with only that key-value pair
		$newqs = http_build_query($newvars);
		if(!empty($newqs)) return $urlpart.'?'.$newqs;
		else return $urlpart;
	}
}
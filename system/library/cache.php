<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Cache Library
 *
 * @author          Jeroen Desloovere
 * @date			2011
 */

class cache
{
	// Is cache enabled
	public static $enabled = true;
	
	// Compress: false or 0->9 value
	public static $compress = true;
	public static $compress_level = 9;
	
	// Location for cache storing
	public static $location;
	
	// File extension
	public static $file_extension = '.php';
	
    // Time to last of currently being recorded data
    public static $lifetime = 60;

	// Cache data
	private static $DATA = 'data';
	
	// Cache output
	private static $OUTPUT = 'view';
	private static $cache_output; // Boolean
    private static $group;
	private static $id;
    private static $lifetime_output;
	
	
	// Get data
	// ---------------------------------------------------------------------------
	public static function get($group, $id, $overwrite = false)
	{
		if(self::$enabled && !$overwrite && self::exists(self::$DATA, $group, $id))
		{
			return data::unserialize(self::read(self::$DATA, $group, $id));
        }
        
        return false;
	}
	
	// Set data
	// ---------------------------------------------------------------------------
	public static function set($group, $id, $data, $lifetime = false)
	{
		if(self::$enabled)
		{
			self::write(self::$DATA, $group, $id, data::serialize($data), $lifetime);
		}
	}
	
	
	// Start output caching
	// ---------------------------------------------------------------------------
	public static function start($group, $id, $lifetime = false, $overwrite = false)
	{
		self::$cache_output = false;
		if(self::$enabled)
		{
			if(!$overwrite && self::exists(self::$OUTPUT, $group, $id))
			{
				echo self::read(self::$OUTPUT, $group, $id);
				return false;
			}
			else
			{
				ob_start();					
				self::$group			= $group;
				self::$id 				= $id;
				self::$lifetime_output	= ($lifetime) ? $lifetime : self::$lifetime;
				self::$cache_output		= true;
			}
		}
		return true;
	}
	
	// Cancel output caching
	// ---------------------------------------------------------------------------
	public static function cancel()
	{
		self::$cache_output = false;
	}
	
	// End output caching
	// ---------------------------------------------------------------------------
	public static function end()
	{
		if(self::$enabled)
		{
			if(self::$cache_output)
			{
				$data = ob_get_contents();
				self::write(self::$OUTPUT, self::$group, self::$id, $data, self::$lifetime_output);
			}
			ob_end_flush();
			flush();
		}
	}
	
	// Exists
	// ---------------------------------------------------------------------------
	public static function exists($type, $group, $id)
	{
		if(self::$enabled)
		{
			$filepath = self::filepath($type, $group, $id);
			if(file_exists($filepath) && filemtime($filepath) > time()) return true;
		}
		return false;
	}
	
	// Read
	// ---------------------------------------------------------------------------
	private static function read($type, $group, $id)
	{
		$filepath = self::filepath($type, $group, $id);
		if(self::exists($type, $group, $id))
		{
			$data = file_get_contents($filepath);
			if(self::$compress&&function_exists('gzuncompress')) $data = gzuncompress($data);
			return $data;
		}
	
		self::delete($filepath);

        return false;
    }
	
	// Write
	// ---------------------------------------------------------------------------
	private static function write($type, $group, $id, $data, $lifetime = false)
	{
		// Make dir
		if(!is_dir(self::$location.$group.'/'))
		{
			mkdir(self::$location.$group.'/',0777,true);
		}
		
		// Get file
		$filepath = self::filepath($type, $group, $id);
		$fh = fopen($filepath,'w');
		
		// Set data to file
		if(self::$compress&&function_exists('gzcompress')) $data = gzcompress($data, self::$compress_level);
		fwrite($fh,$data);
		
		// Close file
		fclose($fh);
		
		// Set filemtime
		$lifetime = ($lifetime) ? $lifetime : self::$lifetime;
		touch($filepath, time() + $lifetime);
	}
	
	// Filepath
	// ---------------------------------------------------------------------------
	private static function filepath($type, $group, $id)
    {
		// Get encrypted filename
		$enc = (is_array($id)) ? implode('_',$id) : $id;	
		$enc = md5(SECURITY_KEY.$enc);
	
		// Return filepath
		return self::$location.$group.'/'."{$enc}_{$type}_{$id}".self::$file_extension;
    }
	
	// Delete
	// ---------------------------------------------------------------------------
	private static function delete($filepath)
	{
		if(file_exists($filepath)) @unlink($filepath);
	}
	
	// TODO
	// Clear all cache files in cache::$location
	// ---------------------------------------------------------------------------
	private static function clear()
	{
		// TODO
	}
}

cache::$enabled = CACHE;
cache::$lifetime = CACHE_LIFETIME;
cache::$location = APPLICATION.'/cache/'.CURRENT_PAGE;
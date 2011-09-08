<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Dingo Framework Validation Helper
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/validation-helper
 */

class valid
{
	// Username
	// ---------------------------------------------------------------------------
	public static function username($username)
	{
		return preg_match('/^([\-_ a-z0-9]+)$/is',$username);
	}
	
	
	// Name
	// ---------------------------------------------------------------------------
	public static function name($name)
	{
		return preg_match('/^([ a-z]+)$/is',$name);
	}
	
	
	// Number
	// ---------------------------------------------------------------------------
	public static function number($number)
	{
		return preg_match('/^([\.0-9]+)$/is',$number);
	}
	
	
	// Int
	// ---------------------------------------------------------------------------
	public static function int($int)
	{
		return preg_match('/^([0-9]+)$/is',$int);
	}
	
	
	// Range
	// ---------------------------------------------------------------------------
	public static function range($low,$high,$number)
	{
		return ($low <= $number AND $high >= $number);
	}
	
	
	// Length
	// ---------------------------------------------------------------------------
	public static function length($low,$high,$number)
	{
		return self::range($low,$high,strlen($number));
	}
	
	
	// Email Address
	// ---------------------------------------------------------------------------
	public static function email($email)
	{
		return preg_match('/^([_\.a-z0-9]{3,})@([\-_\.a-z0-9]{3,})\.([a-z]{2,})$/is',$email);
	}
	
	
	// Phone Number
	// ---------------------------------------------------------------------------
	public static function phone($phone,$strict=false)
	{
		if(!$strict)
		{
			$phone = preg_replace('/([ \(\)\-]+)/','',$phone);
		}
		
		return preg_match('/^([0-9]{10})$/',$phone);
	}
	
	// IP
	// ---------------------------------------------------------------------------
	public static function ip($ip)
	{
		$ip_segments = explode('.', $ip);

		// Always 4 segments needed
		if (count($ip_segments) != 4)
		{
			return false;
		}
		// IP can not start with 0
		if ($ip_segments[0][0] == '0')
		{
			return false;
		}
		// Check each segment
		foreach ($ip_segments as $segment)
		{
			// IP segments must be digits and can not be 
			// longer than 3 digits or greater then 255
			if ($segment == '' OR preg_match("/[^0-9]/", $segment) OR $segment > 255 OR strlen($segment) > 3)
			{
				return false;
			}
		}

		return true;
	}
}
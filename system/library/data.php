<?php if(!defined('SWAMI')){die('External Access to File Denied');}
// data
// @author:				Jeroen Desloovere <info@jeroendesloovere.be>
// @date:					23-04-2011
// ===========================================================================
class data
{
	// Sort variable
	private static $sortKey;
	
	// toPrice variables
	private static $priceValuesAfterComma = 2;
	private static $priceSeparator = ',';
	private static $priceThousandsSeparator = '';

	// To array
	// ---------------------------------------------------------------------------
	public static function toArray($data)
	{
		$arr = array();
		if(is_object($data))
		{
			foreach($data as $key => $value)
			{
				$arr[$key] = self::toArray($value);
			}
		}
		elseif(is_array($data))
		{
			$keys = array_keys($data);
			if(count($keys)>0)
			{
				foreach($keys as $key)
				{
					$arr[$key] = self::toArray($data[$key]);
				}
			}
		}
		else $arr = $data;
		return $arr;
	}
	
	// To object
	// ---------------------------------------------------------------------------
	public static function toObject($data)
	{
		$obj = new stdclass();
		
		if(is_object($data))
		{
			foreach($data as $key => $value)
			{
				$obj->$key = self::toObject($value);
			}
		}
		elseif(is_array($data))
		{
			$keys = array_keys($data);
			if(count($keys)>0)
			{
				foreach($keys as $key)
				{
					$obj->$key = self::toObject($data[$key]);
				}
			}
		}
		else $obj = $data;
		return $obj;
	}
	
	// TODO
	// Object/Array to xml
	// ---------------------------------------------------------------------------
	public static function toXml($data)
	{
		$arr = array();
		if(is_object($data))
		{
			foreach($data as $key => $value)
			{
				$str .= '<'.$key.'>'.self::toXml($value).'</'.$key.'>\n';
			}
		}
		elseif(is_array($data))
		{
			$keys = array_keys($data);
			if(count($keys)>0)
			{
				foreach($keys as $key)
				{
					$str .= '<'.$key.'>'.self::toString($data[$key]).'</'.$key.'>\n';
				}
			}
		}
		else $str .= $data;
		return $str;
	}
	
	// TODO: test
	// TODO: Does there has to happen something with the $key?
	// Object/Array to string
	// ---------------------------------------------------------------------------
	public static function toString($data, $separator=',')
	{
		$arr = array();
		$str = '';
		if(is_object($data))
		{
			foreach($data as $key => $value)
			{
				$str .= self::toString($value, $separator).$separator;
			}
		}
		elseif(is_array($data))
		{
			$keys = array_keys($data);
			if(count($keys)>0)
			{
				foreach($keys as $key)
				{
					$str .= self::toString($data[$key], $separator).$separator;
				}
			}
		}
		else $str .= $data;
		return trim($str, $separator);
	}
		
	// To price with X values after comma
	// ---------------------------------------------------------------------------
	public static function toPrice($number, $afterComma=false, $separator=false, $thousandsSeparator=false)
	{
		// Override variables
		if($afterComma===false)			$afterComma 		= self::$priceValuesAfterComma; 
		if($separator===false)			$separator 			= self::$priceSeparator;
		if($thousandsSeparator===false)	$thousandsSeparator	= self::$priceThousandsSeparator;
		
		// Return price
		return number_format((float) $number, $afterComma, $separator, $thousandsSeparator);
	}
	
	// To date
	// ---------------------------------------------------------------------------
	public static function toDate($date = false, $date_format = 'd/m/Y')
	{
		if($date===false) return date($date_format);
		else return date($date_format, strtotime($date));
	}	
	
	// Serialize
	// ---------------------------------------------------------
	public static function serialize($data)
	{
		if(is_object($data))
		{
			$data = self::toObject($data);
		}
		elseif(is_array($data))
		{
			$keys = array_keys($data);
			if(count($keys)>0)
			{
				foreach($keys as $key)
				{
					$data[$key] = self::serialize($data[$key]);
				}
			}
		}
		return serialize($data);
	}
	
	// Unserialize	
	// ---------------------------------------------------------
	public static function unserialize($data)
	{
		$data = unserialize($data);
		
		if(is_array($data))
		{
			$keys = array_keys($data);
			if(count($keys)>0)
			{
				foreach($keys as $key)
				{
					$data[$key] = self::unserialize($data[$key]);
				}
			}
		}
		return $data;
	}
	
	// Strip slashes	
	// ---------------------------------------------------------
	public static function stripSlashes($str)
	{
		if(is_array($str))
		{
			foreach($str as $key => $val)
			{
				$str[$key] = self::stripSlashes($val);
			}
		}
		elseif(is_object($str))
		{
			foreach($str as $key => $val)
			{
				$str->$key = self::stripSlashes($val);
			}
		}
		else $str = stripslashes($str);

		return $str;
	}
	
	// Sort descending (Z->A, 9->0)
	// ---------------------------------------------------------------------------
	public static function sortDesc(&$data, $key=false)
    {
        self::sortDescOrAsc($data, $key);
    }
	
	// Sort ascending (0->9, A->Z)
	// ---------------------------------------------------------------------------
	public static function sortAsc(&$data, $key=false)
	{
		self::sortDescOrAsc($data, $key, true);
	}
    
    // Sorting an array of objects on a key
    // ---------------------------------------------------------------------------
	public static function sortDescOrAsc(&$data, $key=false, $descending = false)
    {
		// Sort array of objects
		if(isset($data[0])&&is_array($data[0]))
		{
			// Save sort key
			if($key) self::$sortKey = $key;
			else throw new SwamiDataException('Key is missing!');		
		
			// Sort descending
			if($descending==true){ usort($data, 'data::sortValueDescending'); }
			
			// Sort ascending
			else{ usort($data, 'data::sortValueAscending'); } 
		}
		// Sort 1 array
		else
		{
			if($descending==true) sort($data);
			else rsort($data);
		}
    }
	
	// Sort value descending
    // ---------------------------------------------------------------------------
	private static function sortValueDescending($a, $b)
	{
		// Get sort key
		$key = self::$sortKey;
		
		// Make objects
		$a = self::toObject($a);
		$b = self::toObject($b);
		
		// Return equal, lower or higher value
		if($a == $b){ return 0; }
		return $a->$key > $b->$key ? 1 : -1;
	}
	
	// Sort value ascending
    // ---------------------------------------------------------------------------
	private static function sortValueAscending($a, $b)
	{
		// Get sort key
		$key = self::$sortKey;
		
		// Make objects
		$a = self::toObject($a);
		$b = self::toObject($b);
		
		// Return equal, lower or higher value
		if($a == $b){ return 0; }
		return $a->$key < $b->$key ? 1 : -1;
	}
		
	// Shorten
	// ---------------------------------------------------------------------------
	public static function shorten($data, $maxLength=160, $suffix='...', $cleanPunctuals=true)
	{
		// Get string
		$string = self::toString($data,', ');
		$maxLength = (int) $maxLength;
		
		// Shorten on words
		if(strlen($string) > $maxLength)
		{
			// Find whitespace as close as possible against desired maximum length
			$whitespaceposition = strpos($string," ",$maxLength)-1;
			$boundry = 3;
			
			// Whitespace not within acceptable boundries
			while($whitespaceposition>=0 && $whitespaceposition>=$maxLength+$boundry)
			{
				$boundry += 3;
				$whitespaceposition = strpos($string," ",$maxLength-$boundry)-1;
			}
			
			$string = substr($string, 0, ($whitespaceposition+1));
		}
		// Clean punctuals add end of string
		if($cleanPunctuals) $string = trim($string, '?!,.-"\'');
		
		// Return
		return $string.($suffix ? $suffix : '');
	}
	
	// Checks if the given regex statement is valid.
	// ---------------------------------------------------------------------------
	public static function isValidRegexp($regexp)
	{
		// dummy string
		$dummy = 'swami is growing every day';

		// validate
		return (@preg_match((string) $regexp, $dummy) !== false);
	}
	
	// Create Urls (which are in string)
	// ---------------------------------------------------------------------------
	public static function createUrls($string)
	{
		return preg_replace("#http://([A-z0-9./-]+)#", '<a href="$1">$0</a>', $string);
	}
	
	// Delete Urls (which are in string)
	// ---------------------------------------------------------------------------
	public static function deleteUrls($string)
	{
		return preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);
	}
	
	// Return everything before last occurence
	// ---------------------------------------------------------------------------
	public static function getBeforeLast($find, $string)
	{
		$after = self::getAfterLast($find, $string);
		
		if($after) return substr($string, 0, -strlen($after));
		else return $string;
	}
	
	// Return everything after last occurence
	// ---------------------------------------------------------------------------
	public static function getAfterLast($find, $string)
	{
		return trim(strrchr($string, $find), $find);
	}
}
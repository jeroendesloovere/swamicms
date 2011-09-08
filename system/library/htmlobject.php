<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// htmlobject
// @author:				Jeroen Desloovere <info@jeroendesloovere.be>
// @date:				23-04-2011
// ===========================================================================
class htmlobject
{
	// Size
	// ---------------------------------------------------------------------------
	public static function size(&$str, $pref_w = 600, $pref_h = 400)
	{
		$str = self::width($str, $pref_w);
		$str = self::height($str, $pref_h);
		
		return $str;
	}
	
	// Width
	// ---------------------------------------------------------------------------
	public static function width(&$str, $pref_w = 600)
	{
		return preg_replace('/width=\"[0-9]*\"/', 'width="'.$pref_w.'"', $str);
	}
	
	// Height
	// ---------------------------------------------------------------------------
	public static function height(&$str, $pref_h = 400)
	{
		return preg_replace('/height=\"[0-9]*\"/', 'height="'.$pref_h.'"', $str);
	}
	
	// Opaque - Adds (2x) wmode="opaque"=> Result: z-index problem solved
	// ---------------------------------------------------------------------------
	public static function opaque($str)
	{
		$p = '<param name="wmode" value="opaque" />';
		if(strpos($str, $p)===false){
			$str = str_replace('<embed',$p.'<embed wmode="opaque"', $str);
		}
		return $str;
	}
}
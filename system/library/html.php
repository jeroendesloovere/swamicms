<?php
class html
{
	// List: unordered
	// ---------------------------------------------------------------------------
	public static function ul($data, $attributes=array())
	{
		$ul = '<ul'.(isset($attributes['id'])) ? ' id="'.$attributes['id'].'"' : ''.''.(isset($attributes['class'])) ? ' class="'.$attributes['class'].'"' : ''.'>';
		foreach($data as $key => $value)
		{
			$ul .= self::li($value);
		}
		$ul .= '</ul>';
		return $ul;
	}
	
	// List: ordered
	// ---------------------------------------------------------------------------
	public static function ol($data, $attributes=array())
	{
		$ul = '<ul'.(isset($attributes['id'])) ? ' id="'.$attributes['id'].'"' : ''.''.(isset($attributes['class'])) ? ' class="'.$attributes['class'].'"' : ''.'>';
		foreach($data as $key => $value)
		{
			$ul .= self::li($value);
		}
		$ul .= '</ol>';
		return $ul;
	}
	
	// List: item
	// ---------------------------------------------------------------------------
	public static function li($data, $label)
	{
		return '<li>'.$data.'</li>';
	}
	
	// Get data
	// ---------------------------------------------------------------------------
	public static function img($url, $label='')
	{
		return '<img src="'.$url.'" alt="'.$label.'" />';
	}
}
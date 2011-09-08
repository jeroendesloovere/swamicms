<?php

/*

echo date::now(); // dd/mm/YYYY
echo date::from();
echo date::between($from, $to);
echo date::daysInMonth();
echo date::timezone_menu();
echo date::timezones();
*/
class date
{

	// Now
	// ---------------------------------------------------------------------------
	public static function now($date_format = 'dd/mm/YYYY')
	{
		return date($date_format);
	}
	
	// From
	// ---------------------------------------------------------------------------
	public static function from($date_format = 'dd/mm/YYYY', $date = false )
	{
		if($date===false) return date($date_format);
		else return date($date_format, strtotime($date));
	}
	
	// TODO
	// Between
	// ---------------------------------------------------------------------------
	public static function between($from, $to = false)
	{
		// Get vars
		if($to===false) $to = self::now();
		
		// Calc between
		$between = strtotime($from) - strtotime($to);
		print_r($between);
		echo ' s ='.date('s',$between);
	
		// Return in seconds, minutes, hours, days, weeks, months or years
		switch($type)
		{
			case 's': break;
			case 'm': break;
			case 'u': break;
			case 'd': break;
			case 'w': break;
			case 'm': break;
			case 'y': break;
		}		
	}
	
	// Days in month from
	// ---------------------------------------------------------------------------
	public static function daysInMonthFrom($date = false, $add_to_months = 0, $add_to_years = 0)
	{
		// Get month + year
		$month 	= (int) self::from('m',$date) + $add_to_months;
		$year 	= (int) self::from('Y',$date) + $add_to_years;
		
		// Return days in month
		return self::daysInMonth($month, $year);
	}
	
	// Days in month
	// ---------------------------------------------------------------------------
	public static function daysInMonth($month = 0, $year = '')
	{
		// Check month
		if($month < 1 || $month > 12) return 0;

		// Get year
		if(!is_numeric($year) || strlen($year) != 4) $year = date('Y');

		// Calc days
		if($month == 2)
		{
			if ($year % 400 == 0 || ($year % 4 == 0 AND $year % 100 != 0))
			{
				return 29;
			}
		}

		$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		return $days_in_month[$month - 1];
	}
	
	// TODO
	// Months
	// ---------------------------------------------------------------------------
	public static function months($lang)
	{
		// 
		if($lang!==false)
		{
		
		}
	}
	
	// Years
	// ---------------------------------------------------------------------------
	public static function years($add_to_year = 0, $delete_from_year = 110)
	{
		// Get variables
		$now 		= self::now('Y');
		$begin_date = (int)($now - $delete_from_year);
		$end_date 	= (int)($now + $add_to_year);
		
		// Calc years
		$y = array();
		for($i=$begin_date; $i<=$end_date; $i+=1) $y[] = $i;
		
		// Return years-array
		return $y;
	}
	
	// Timezones
	// ---------------------------------------------------------------------------
	public static function timezones()
	{
		// Note: Don't change the order of these even though
		// some items appear to be in the wrong order
		$zones = array( 'UM12'		=> -12,
						'UM11'		=> -11,
						'UM10'		=> -10,
						'UM95'		=> -9.5,
						'UM9'		=> -9,
						'UM8'		=> -8,
						'UM7'		=> -7,
						'UM6'		=> -6,
						'UM5'		=> -5,
						'UM45'		=> -4.5,
						'UM4'		=> -4,
						'UM35'		=> -3.5,
						'UM3'		=> -3,
						'UM2'		=> -2,
						'UM1'		=> -1,
						'UTC'		=> 0,
						'UP1'		=> +1,
						'UP2'		=> +2,
						'UP3'		=> +3,
						'UP35'		=> +3.5,
						'UP4'		=> +4,
						'UP45'		=> +4.5,
						'UP5'		=> +5,
						'UP55'		=> +5.5,
						'UP575'		=> +5.75,
						'UP6'		=> +6,
						'UP65'		=> +6.5,
						'UP7'		=> +7,
						'UP8'		=> +8,
						'UP875'		=> +8.75,
						'UP9'		=> +9,
						'UP95'		=> +9.5,
						'UP10'		=> +10,
						'UP105'		=> +10.5,
						'UP11'		=> +11,
						'UP115'		=> +11.5,
						'UP12'		=> +12,
						'UP1275'	=> +12.75,
						'UP13'		=> +13,
						'UP14'		=> +14
					);

		if($tz == '') return $zones;
		if($tz == 'GMT') $tz = 'UTC';
		return (!isset($zones[$tz])) ? 0 : $zones[$tz];
	}
	
	// TODO use form -> dropdownlist
	// Timezone menu
	// ---------------------------------------------------------------------------
	/*
	public static function timezone_menu($default = 'UTC', $class = "", $name = 'timezones')
	{
		if($default == 'GMT') $default = 'UTC';

		$menu = '<select name="'.$name.'"';

		if($class != '') $menu .= ' class="'.$class.'"';

		$menu .= ">\n";

		$timezones = self::timezones();
		foreach($timezones as $key => $val)
		{
			$selected = ($default == $key) ? " selected='selected'" : '';
			$menu .= "<option value='{$key}'{$selected}>".$CI->lang->line($key)."</option>\n";
		}

		$menu .= "</select>";

		return $menu;
	}
	*/
	
}
<?php

/**
 * FormMultipleItemLayout
 *
 * This class helps building nice layouts
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class FormMultipleItemLayout extends FormItemLayout
{
	// Parse
	// ------------------------------------------------------------
	public function parse($parsed_objs, $obj)
	{
		$output = '<p>';
		
		$output .= '<ul>';
		
		// List item
		$count = count($parsed_objs);
		for($i=0; $i<$count; $i+=1)
		{
			$output .= '<li>';
			
			// Label
			$output .= '<label>'.$parsed_objs[$i].' '.$obj[$i]->label.'</label>';
			
			// Add help
			if(isset($obj[$i]->help)) $output .= '<span class="help">'.$obj[$i]->help.'</span>';
			
			// Add error
			if(isset($obj[$i]->error)) $output .= '<span class="error">'.$obj[$i]->error.'</span>';
			
			$output .= '</li>';
		}
		$output .= '</ul>';
		
		$output .= '</p>';
		
		return $output;
	}
} // End FormMultipleItemLayoutException
class FormMultipleItemLayoutException extends SwamiException{}
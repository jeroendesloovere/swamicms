<?php

/**
 * FormItemLayout
 *
 * This class helps building nice layouts
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class FormItemLayout
{
	private $_orientation  	= 'horizontal';  	// 'horizontal' || 'vertical'
	private $_align  		= 'left';  			// 'left' || 'right'
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($args = false)
	{
		if($args)
		{
			foreach($args as $key => $value)
			{
				switch($key)
				{
					case 'orientation':  	$this->setOrientation($value);  	break;
					case 'align':			$this->setAlign($value);			break;
				}
			}
		}
	}
	
	// Set orientation
	// ------------------------------------------------------------
	public function setOrientation($orientation)
	{
		if(in_array($orientation, array('horizontal', 'vertical'))) $this->_orientation = $name;
	}
	
	// Set align
	// ------------------------------------------------------------
	public function setAlign($align)
	{
		if(in_array($align, array('left', 'right'))) $this->_align = $align;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse($parsed_obj, $obj)
	{
		$output = '<p>';
		
		// Add object
		if($this->_orientation=='horizontal')
		{
			$output .= '<label>';
			if($this->_align=='left') $output .= $obj->label;
			$output .= $parsed_obj;
			if($this->_align=='right') $output .= $obj->label;
			$output .= '</label>';
		}
		else
		{
			$lbl = '<label>'.$obj->label.'</label>';
			if($this->_align=='left') $output .= $lbl;
			$output .= $parsed_obj;
			if($this->_align=='right') $output .= $lbl;
		}
		
		// Add help
		if(isset($obj->help)) $output .= '<span class="help">'.$obj->help.'</span>';
		
		// Add error
		if(isset($obj->error)) $output .= '<span class="error">'.$obj->error.'</span>';	
		
		$output .= '</p>';
		
		return $output;
	}
} // End FormItemLayout
class FormItemLayoutException extends SwamiException{}
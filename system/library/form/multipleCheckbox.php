<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * MultipleCheckbox
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class MultipleCheckbox extends FormItemObject
{
	private $_objects;
	private $_layout;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($name, $arr=array(), $checked_values = array())
	{
		$i = 1;
		foreach($arr as $value => $label)
		{
			// Is checked?
			$checked = (in_array($value, $checked_values)) ? true : false;
			
			// Set new checkbox
			$checkbox = new Checkbox($name, $label, $checked, $value);
			$this->_objects[] = $checkbox->setAttribute('id', $checkbox->attributes['id'].'_'.$i);
			
			$i+=1;
		}
		$this->_layout = new FormMultipleItemLayout(false);
		return $this;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		$count = count($this->_objects);
		for($i=0; $i<$count; $i+=1)
		{
			$output[]  		= $this->_objects[$i]->parse(false);
			$attributes[]  	= $this->_objects[$i];
		}
		return $this->_layout->parse($output, $attributes);
	}
} // End Checkbox
class MultipleCheckboxException extends SwamiException{}
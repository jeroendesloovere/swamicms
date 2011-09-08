<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * FormItemObject
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class FormItemObject
{
	public $attributes;
	public $label;
	public $help;
	public $error;
	private $_classes = array();
	
	// Set attribute
	// ------------------------------------------------------------
	public function setAttribute($key, $value)
	{
		switch($key)
		{
			case 'name':				$this->attributes['name'] = clean::underscore($value);		break;
			case 'id':					$this->attributes['id'] = clean::underscore($value);		break;
			case 'class':				$this->_addClass($value);									break;
			case 'class_on_error':  	$this->_addClass($value);									break;
			case 'field_size':			$this->_addFieldSize($value);								break;
			case 'value':				$this->attributes['value'] = $value;						break;
			case 'type':				$this->_addInputType($value);								break;
			
			case 'label':				$this->setLabel($value);  									break;
			case 'help':				$this->setHelp($value);										break;
			case 'error':				$this->setError($value);  									break;
			
			default:					$this->attributes[$key] = $value;							break;
		}
		return $this;
	}
	
	// Set label
	// ------------------------------------------------------------
	public function setLabel($value)
	{
		$this->label = $value;
		return $this;
	}
	
	// Set help
	// ------------------------------------------------------------
	public function setHelp($value)
	{
		$this->help = $value;
		return $this;
	}
	
	// Set error
	// ------------------------------------------------------------
	public function setError($value)
	{
		$this->error = $value;
		return $this;
	}
	
	// Add class
	// ------------------------------------------------------------
	private function _addClass($class)
	{
		$class = clean::underscore($class);
		if(!in_array($class, $this->_classes))
		{
			$this->_classes[] = $class;
			$this->attributes['class'] = implode(' ', $this->_classes);
		}
	}
	
	// Add field size
	// ------------------------------------------------------------
	private function _addFieldSize($field_size)
	{
		if(in_array($field_size, array('tiny','small','medium','big'))) $this->_addClass($field_size.'_input');
	}
	
	// Add type
	// ------------------------------------------------------------
	private function _addInputType($type)
	{
		$this->arguments['type'] = 'text';
		if(in_array($type, array('hidden','checkbox','password','email'))) $this->attributes['type'] = $type;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		$output = '';
		foreach($this->attributes as $key => $value)
		{
			$output .= ' '.$key.'="'.$value.'"';
		}
		return $output;
	}
} // End FormItemObject
class FormObjectException extends SwamiException{}
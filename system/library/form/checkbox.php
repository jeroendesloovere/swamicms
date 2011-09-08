<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Checkbox
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

if(!class_exists('formFields'))
{
	echo "GO";
	load::library('form/formItemObject');
	load::library('form/formItemLayout');
}
class Checkbox extends FormItemObject
{
	private $_layout;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($name, $label='', $checked = false, $value = 'Y')
	{
		$this->setAttribute('name', $name);
		$this->setAttribute('id', 'input_'.$this->attributes['name']);
		$this->setAttribute('class', 'input_checkbox');
		$this->setAttribute('type', 'checkbox');
		$this->setAttribute('value', $value);
		if($checked) $this->setAttribute('checked', 'checked');
		$this->setLabel($label);
		
		$this->_layout = new FormItemLayout();
		$this->_layout->setAlign('right');
		return $this;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse($single=true)
	{
		$output = '<input '.parent::parse().' />';
		return ($single) ? $this->_layout->parse($output, $this) : $output;
	}
} // End Checkbox
class CheckboxException extends SwamiException{}
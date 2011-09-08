<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Textinput
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class Textinput extends FormItemObject
{
	private $_required;
	private $_layout;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($name, $value=null, $label=null)
	{
		$this->setAttribute('name', $name);
		$this->setAttribute('id', 'input_'.$this->attributes['name']);
		$this->setAttribute('class', 'input_text');
		$this->setAttribute('value', $value);
		$this->setLabel($label);
		
		//$this->_required = $required;
		$this->_layout = new FormItemLayout();
		return $this;
	}
	
	// Validate
	// ------------------------------------------------------------
	public function validate()
	{
		// If not valid, add an error class
		$this->setAttribute('class_on_error', 'input_error');
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		return $this->_layout->parse('<input '.parent::parse().' />', $this);
	}
} // End Textinput
class TextinputException extends SwamiException{}
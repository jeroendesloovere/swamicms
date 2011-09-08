<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Button
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */
 
load::library('form/formItemObject');
class Button extends FormItemObject
{
	// Construct
	// ------------------------------------------------------------
	public function __construct($name, $label='send', $type = 'submit')
	{
		$this->setAttribute('name', $name);
		$this->setAttribute('id', 'btn_'.$this->attributes['name']);
		$this->setAttribute('type', $type);
		$this->setLabel($label);
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		return '<button '.parent::parse().'>'.$this->label.'</button>';
	}
} // End Button
class ButtonException extends SwamiException{}
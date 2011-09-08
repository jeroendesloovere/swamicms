<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Hidden
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class Hidden extends FormItemObject
{
	// Construct
	// ------------------------------------------------------------
	public function __construct($name, $value)
	{
		$this->setAttribute('name', $name);
		$this->setAttribute('id', 'hidden_'.$this->attributes['name']);
		$this->setAttribute('value', $value);
		$this->setAttribute('type', 'hidden');
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		return '<input '.parent::parse().' />';
	}
} // End Hidden
class HiddenException extends SwamiException{}
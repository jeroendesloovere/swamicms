<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * FormInput
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */
 
load::library('form/formFields');
class FormInput extends FormFields
{
	// Construct
	// ------------------------------------------------------------
	public function __construct()
	{
		parent::init();
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		foreach($this->_objects as $obj)
		{
			$output = $obj->parse();
		}
		return $output;
	}
} // End FormInput
class FormInputException extends SwamiException{}
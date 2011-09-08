<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Form
 *
 * Use this to add a form quickly
 *
 * @author          Jeroen Desloovere
 * @date			14-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

load::library('form/formFields');
class Form extends FormFields
{
	private $_name;
	private $_action;
	private $_method = 'post';
	private $_use_token = false;
	public $submitted = false;
	public $valid = false;
	
	private static $_form_names = array();
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($name = 'form', $action = '', $method = 'post', $use_token = true)
	{
		// Load library files
		parent::init();
		
		// Set
		$this->_addIfValidFormName(clean::underscore((string) $name));
		$this->_action = (string) $action;
		$this->_method = (string) $method;
		
		// Check if submitted
		$this->addHidden('form',$this->_name);
		if(input::post('form')===$this->_name) $this->submitted = true;
		
		// TODO: do something with $_use_token
		// Add form token
		if($use_token===true)
		{
			$this->_use_token = (bool)$use_token;
			
			// TODO
			// Get token
			$token = 'token';
			
			// Add hiden field with token
			$this->addHidden($this->_name.'_form_token',$token);
		}
		
		// TODO
		// Check if form is valid?
		// - Is token correct?
		// - Are required fields valid?
		// - 
		$this->valid = true;
	}
	
	// Is valid form name?
	// ------------------------------------------------------------
	private function _addIfValidFormName($name)
	{
		if(!in_array($name, self::$_form_names))
		{
			self::$_form_names[] = $name;
			$this->_name = $name;
		}
		else throw new FormException('Duplicate form_name: rename this form');
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		$output = '<form name="'.$this->_name.'" action="'.$this->_action.'" method="'.$this->_method.'">';
		
		foreach($this->_objects as $obj)
		{
			$output .= $obj->parse();
		}
		
		$output .= '</form>';
		return $output;
	}
} // End Form
class FormException extends SwamiException{}
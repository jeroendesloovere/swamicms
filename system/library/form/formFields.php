<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Checkbox
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class FormFields
{
	protected $_objects = array();
	
	private $_names = array();
	private $_errors = array();
	
	// Init
	// ------------------------------------------------------------
	public function init()
	{
		load::library('clean');
		
		// Single
		load::library('form/formItemObject');
		load::library('form/formItemLayout');
		load::library('form/hidden');
		load::library('form/button');
		load::library('form/textinput');
		load::library('form/checkbox');
		
		// Multiple
		load::library('form/formMultipleItemLayout');
		load::library('form/multipleCheckbox');
	}
	
	// Add
	// ------------------------------------------------------------
	public function add($obj)
	{
		$this->_addIfValidName($obj->attributes['name'], $obj);
	}
	
	// Add Hidden
	// ------------------------------------------------------------
	public function addHidden($name, $value)
	{
		$this->_addIfValidName($name, new Hidden($name, $value));
	}
	
	// Add Checkbox
	// ------------------------------------------------------------
	public function addCheckbox($name, $label, $checked = false)
	{
		$this->_addIfValidName($name, new Checkbox($name, $label, $checked));
	}
	
	// Add Multiple Checkbox
	// ------------------------------------------------------------
	public function addMultipleCheckbox($name, $arr = array(/*value=>label,*/), $checked_values = array())
	{
		$this->_addIfValidName($name, new MultipleCheckbox($name, $arr, $checked_values));
	}
	
	// Add Textinput
	// ------------------------------------------------------------
	public function addTextinput($name, $value, $label)
	{
		$this->_addIfValidName($name, new Textinput($name, $value, $label));
	}
	
	// Add Text (a paragraph)
	// Add Passwordinput
	// Add Textarea ($name, $value, $label, $required = false, $maxlength = false, $orientation = false, $align = false)
	/*
		$name = 'naam_van_het_veld';
		
		$value = 'waarde_in_het_veld';
		
		$label = 'Label:',
		
		$placeholder = 'waarde_als_value_leeg_is',
	
		$required = false;
		$required = true;
		$required = array(
			'minlength' => 5,
			'maxlength' => 50,
			'pattern' => '/[a-Z]/',
			'validate_as_type' => 'username' || 'name' || 'number' || 'int' || 'range' || 'email' || 'phone' || 'fax' || 'creditcard' || 'date'   => Use class valid (validate::)
		);
		
		$layout = array(
			'orientation' => 'horizontal' || 'vertical',
			'align' => 'left' || 'right',
			'class' => '',
			'id' => '',
			'size' => 'small' || 'medium' || 'big'
		);
	*/
	// Add AdvancedTextarea -> Uses 'tinymce', 'markup', 'textile' or another
	// Add Checkbox
	/*
		...
		$isCheckedValue = 'this_is_the_current_value' => there has to be checked if this matches the value of the checkbox.
	
	*/
	// Add MultipleCheckboxes (depends on eachother)
	// Add Radiobutton
	// Add Dropdownlist
	// Add Creditcardinput
	// ...
	
	// Extends Choise:
	// Add DayChoise
	// Add MonthChoise
	// Add YearChoise
	// Add DateChoise
	// Add LanguageChoise
	// Add AgeChoise
	
	// Get mailtemplate (this generates a mailtemplate, so it can be send)
	// ------------------------------------------------------------
	
	
	// Add Button
	// ------------------------------------------------------------
	public function addButton($name, $label = 'Send')
	{
		$this->_addIfValidName($name, new Button($name, $label));
	}
	
	// Add if valid name?
	// ------------------------------------------------------------
	private function _addIfValidName($name, $obj)
	{
		if(!in_array($name, $this->_names))
		{
			$this->_names[] = $name;
			$this->_objects[] = $obj;
			return true;
		}
		else
		{
			throw new FormFieldsException('error, name already exists');
		}
	}
} // End FormFields
class FormFieldsException extends SwamiException{}
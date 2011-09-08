<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Block model
 *
 * Lets you add blocks fast on your page, minimum on program skill required.
 *
 * @author          Jeroen Desloovere
 * @date			03-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */
 
 /*

// In controller
$data = array(
	array(
		'id'=>1,
		'naam'=>'Jeroen',
		'familienaam'=>'desloovere',
		'leeftijd'=>'23',
		'gsm'=>'iphone',
		'vis'=>0,	
	),
	array(
		'id'=>2,
		'naam'=>'Charlotte',
		'familienaam'=>'Goessaert',
		'leeftijd'=>'22',
		'gsm'=>'nokia',	
		'vis'=>1,	
	)
); 
 
// Block
// ------------------------------------------------------------
$block = new Block(__("Klanten"));
$block->addBtn("Adres toevoegen",'admin/users/add/');


// Table
// ------------------------------------------------------------
$table = new Table($data);
$table->keys = array('naam','familienaam','leeftijd','vis');

$table->addBtn('add',null,'admin/users/edit/:id'); // Adds new Row
$table->addBtn('edit','naam','admin/users/edit/:id');
$table->addBtn('delete','id','admin/users/delete/:id'); // Adds ajax delete code
$table->addBtn('visibility','vis','admin/users/visibility/:id'); // Adds ajax visibility code

$block->addContent($table);


// Form
// ------------------------------------------------------------
$form = new Form(false); // false = header already defined. Attention: form header is already on view (edit, add, cancel- buttons)

// Attention: form header is already on view (edit, add, cancel- buttons)
$form->addTextinput('name','value','label','size');
$form->addTextarea('name','value','label','advanced'); 

// Extra settings allowed, including Tinymce support
$textarea = new AdvancedTextarea('name','value','label','advanced');
$textarea->height = 50;
$textarea->width = '100%';
$textarea->buttons1 = "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect";
$textarea->buttons2 = "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor";
$textarea->buttons3 = "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen";
$textarea->buttons4 = "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage";
$textarea->toolbar_location = "top";
$textarea->toolbar_align = "left";
$textarea->statusbar_location = "bottom";

// Example content CSS (should be your site CSS)
$textarea->content_css = "css/example.css";

// Drop lists for link/image/media/template dialogs
$textarea->template_external_list_url = "js/template_list.js";
$textarea->external_link_list_url = "js/link_list.js";
$textarea->external_image_list_url = "js/image_list.js";
$textarea->media_external_list_url = "js/media_list.js";

$form->add($textarea);


$form->addTextarea('name','value','label','advanced');
$form->addCheckbox('name','value','label');

$block->addContent($form);


// Show Block
// ------------------------------------------------------------
$block->parse();
 
 */
 
class Block extends AppModel
{
	private $_title;
	private $_title_url;
	private $_btns = array();
	private $_contents = array();
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($title='', $url=false)
	{
		$this->_title = $title;
		$this->_title_url = (string) $url;
	}
	
	// Add button
	// ------------------------------------------------------------
	public function addBtn($type, $url, $label)
	{
		$this->_btns[] = new BlockLinkbutton($type, url::get($url), ucfirst( __($type.' {item}',array('{item}'=>___($label))) ) );
	}
	
	// Add custom button
	// ------------------------------------------------------------
	public function addCustomBtn($type, $url, $label)
	{
		$this->_btns[] = new BlockLinkbutton($type, $url, ucfirst($label));
	}
	
	// Add content
	// ------------------------------------------------------------
	public function addContent($object)
	{
		$this->_contents[] = $object;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		// Btns
		$btns = ''; foreach($this->_btns as $btn) $btns .= $btn->parse();
		
		// View
		load::view('blocks/block',array('title'=>$this->_title,'title_url'=>$this->_title_url,'btns'=>$btns,'contents'=>$this->_contents));
	}
}
class Table extends AppModel
{
	// Name
	private $_name;  // Used to save a session (sorting)
	private $_session_name;
	private static $_table_count = 0;
	
	// Data
	private $_data = array();
	private $_keys = array();
	private $_labels = array();
	private $_btns = array();
	private $_extra_columns = array('before'=>array(),'after'=>array());
	
	// Options
	private $_show_btns = false;
	private $_odd_even = true;
	
	private $_pagination_allowed = true;
	
	private $_sorting_start = '';
	private $_sorting_allowed = true;
	
	private $_checkboxes_url = '';
	private $_checkboxes_value = '{id}';
	private $_checkboxes_allowed = false;
	private $_checkbox_input;
	private $_checkbox_btns = array();
	
	private $_reordering_url = '';
	private $_reordering_allowed = false;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($data = array())
	{
		$this->_data = $data;
		
		// Unique name
		$this->_name = self::$_table_count; 
		self::$_table_count += 1;
		
		// Set urls
		$this->_checkbox_url = url::get( ((APPLICATION==BACKEND) ? 'admin/' : '').route::controller().'/');
		$this->_reordering_url = $this->_checkbox_url.'reorder/';
		
		// Set session name
		$this->_session_name = route::controller().'_'.route::method().'_'.$this->_name;
		
		// TODO
		// session::set($this->_session_name, 'sorting_value');
	}
	
	// Set odd-even
	// ------------------------------------------------------------
	public function setOddEven($bool = true)
	{
		$this->_odd_even = (bool) $bool;
	}
	
	// Set keys
	// ------------------------------------------------------------
	public function setKeys()
	{
		$keys = func_get_args();
		$this->_keys = $keys;
	}
	
	// Set sort
	// ------------------------------------------------------------
	public function setSort($sort_on)
	{
		$this->_sorting_start = $sort_on;
		$this->_sorting_allowed = true;
	}
	
	// Set label
	// ------------------------------------------------------------
	public function setLabel($key, $label)
	{
		$this->_labels[$key] = $label;
	}
	
	// Set sorting
	// ------------------------------------------------------------
	public function setSorting($bool)
	{
		$this->_sorting_allowed = (bool) $bool;
	}
	
	// Set checkboxes
	// ------------------------------------------------------------
	public function setCheckboxes($value = false, $url = false)
	{
		if($value===false||$value===true)
		{
			$this->_checkboxes_allowed = (bool) $value;
			$this->_checkbox_input = new BlockCheckbox($this->_checkboxes_value);
		}
		else
		{
			$this->_checkboxes_allowed = true;
			$this->_checkbox_input = new BlockCheckbox($value);
			if($url!==false) $this->_checkbox_url = $url;
		}
	}
	
	// Set reordering
	// ------------------------------------------------------------
	public function setReordering($url = false)
	{
		if($url===false||$url===true)
		{
			$this->_reordering_allowed = (bool) $url;
		}
		else
		{
			$this->_reordering_url = $url;
			$this->_reordering_allowed = true;
		}
	}
	
	// Add column
	// ------------------------------------------------------------
	public function addColumn($url, $type = '', $label = '', $position = 'after', $show = true)
	{
		$this->_extra_columns[$position][] = new BlockLinkbutton($type, url::get($url), ucfirst($label), (bool)$show );
	}
	
	// Add button
	// ------------------------------------------------------------
	public function addBtn($key, $url, $type = '', $label = false, $show = true)
	{
		if($label===false) $label = '{title}';
		$this->_btns[$key] = new BlockLinkbutton($type, url::get($url), ucfirst($label), (bool)$show);
	}
	
	// Add checkbox btn
	// ------------------------------------------------------------
	public function addCheckboxBtn($type, $name, $label)
	{
		$this->_checkboxes_allowed = true;
		$this->_checkbox_btns[] = new BlockInputbutton($type, $name, $label);
	}
	
	// Get labels
	// ------------------------------------------------------------
	private function _getLabels()
	{
		$labels = array();
		for($i=0; $i<count($this->_keys); $i+=1)
		{
			// Is label added ? Yes, use label : No, use key
			$labels[] = (isset($this->_labels[$this->_keys[$i]])) ? $this->_labels[$this->_keys[$i]] : __($this->_keys[$i]);
		}
		return $labels;
	}
	
	// Get reordering
	// ------------------------------------------------------------
	private function _getReordering()
	{
		if($this->_reordering_allowed) return $this->_reordering_url;
		else return false;
	}
	
	// Get checkbox btns
	// ------------------------------------------------------------
	private function _getCheckboxes()
	{
		if($this->_checkboxes_allowed)
		{
			return array(
				'url'=>$this->_checkboxes_url,
				'input'=>$this->_checkbox_input,
				'btns'=>$this->_checkbox_btns
			);
		}
		else return false;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse()
	{
		// Get
		$reordering = $this->_getReordering();
		$checkboxes = $this->_getCheckboxes();
		$extra_columns_count = count($this->_extra_columns['before']) + count($this->_extra_columns['after']);
		$col_count = (($reordering) ? 1 : 0) + (($checkboxes) ? 1 : 0) + count($this->_keys) + $extra_columns_count;
		
		// View
		load::view('blocks/table', array(
			'col_count'=>$col_count,
			'data'=>$this->_data,
			'keys'=>$this->_keys,
			'odd_even'=>$this->_odd_even,
			'show_btns'=>$this->_show_btns,
			'btns'=>$this->_btns,
			'labels'=>$this->_getLabels(),
			'extra_columns'=>$this->_extra_columns,
			'extra_columns_count'=>$extra_columns_count,
			'reordering'=>$reordering,
			'checkboxes'=>$checkboxes)
		);
	}
}
class BlockLinkbutton extends AppModel
{
	private $_type;
	private $_url;
	private $_label;
	
	private $_show;
	private $_coloring;
	private $_replacing_data = false;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($type, $url, $label, $show = true)
	{
		$this->_type = $type;
		$this->_url = $url;
		$this->_label = $label;
		$this->_show = (bool) $show;
		
		// Set coloring
		switch($this->_type)
		{
			case 'delete': $this->_coloring = 'negative'; break;
			case 'add': $this->_coloring = 'positive'; break;
			default: $this->_coloring = false; break;	
		}
		
		// Set replacing data, can speed up things
		if(strpos($this->_url,'{')!==false&&strpos($this->_url,'}')!==false) $this->_replacing_data = true;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse($data = false)
	{
		// If url has to change
		$url = $this->_url;
		$label = $this->_label;
		if(isset($data)&&$this->_replacing_data)
		{
			foreach($data as $key => $value)
			{
				$url = str_replace('{'.$key.'}', $value, $url);
				$label = str_replace('{'.$key.'}', $value, $label);
			}
		}
		
		// Generate output
		$coloring = ($this->_coloring) ? ' '.$this->_coloring : '';
		$show = ($this->_show) ? ' show-btn' : '';
		$output = '<a href="'.urldecode($url).'" class="btn'.$coloring.$show.'">';
		if(in_array($this->_type, array('edit','delete','add'))) 
			$output .= '<span class="icon '.$this->_type.'"></span>';
		$output .= $label;
		$output .= '</a>';
		return $output;
	}
}
class BlockInputbutton extends AppModel
{
	private $_type;
	private $_name;
	private $_label;
	
	private $_coloring;
	private $_replacing_data = false;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($type, $name, $label)
	{
		$this->_type = $type;
		$this->_name = $name;
		$this->_label = $label;
		
		// Set coloring
		switch($this->_type)
		{
			case 'delete': $this->_coloring = 'negative'; break;
			case 'add': $this->_coloring = 'positive'; break;
			default: $this->_coloring = false; break;	
		}
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse($data = false)
	{
		// Generate output
		$coloring = ($this->_coloring) ? ' '.$this->_coloring : '';
		$output = '<button name="'.$this->_name.'" class="btn'.$coloring.' show-btn">';
		if(in_array($this->_type, array('edit','delete','add'))) 
			$output .= '<span class="icon '.$this->_type.'"></span>';
		$output .= $this->_label;
		$output .= '</button>';
		return $output;
	}
}
class BlockCheckbox extends AppModel
{
	private $_value;
	
	// Construct
	// ------------------------------------------------------------
	public function __construct($value)
	{
		$this->_value = $value;
	}
	
	// Parse
	// ------------------------------------------------------------
	public function parse($data = false)
	{
		// If value has to change
		$val = $this->_value;
		if(isset($data))
		{
			foreach($data as $key => $value)
			{
				$val = str_replace('{'.$key.'}', $value, $val);
			}
		}
		return '<input name="checkbox[]" type="checkbox" value="'.$val.'" />';
	}
}
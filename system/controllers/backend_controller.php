<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Backend controller - Adds extra functionality to controller
 *
 * @author          Jeroen Desloovere
 * @date			14-05-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 */

class backend_controller extends app_controller
{
	public $autoload_library = array();
	
	// Construct
	// ------------------------------------------------------------
	public function __construct()
	{
		// Startup
		parent::init();
		
		// Check permissions here
		if(route::controller()!='users'&&!user::valid()) url::redirect('admin/login');
		elseif(in_array(route::method(), array('index','add','edit','delete','save','search'))&&!parent::isAllowed())
		{
			if(route::method()!='index')
			{
				note::error('permission',__('no_permission_for_page'));
				url::redirect('admin/'.route::controller());
			}
			else url::redirect('admin/modules');
		}
		
		// Go go go
		$this->setLayout("backend");
		$this->addNavToLayout('swami_nav');
	}
	
} // END backend controller
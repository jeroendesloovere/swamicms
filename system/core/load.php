<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Dingo Framework Load Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */

class load
{
	// File
	// ---------------------------------------------------------------------------
	public static function file($folder,$file,$name)
	{
		// If file does not exist display error
		if(!file_exists("$folder/$file.php"))
		{
			dingoError(E_USER_ERROR,"The requested $name ($folder/$file.php) could not be found.");
			return FALSE;
		}
		else
		{
			require_once("$folder/$file.php");
			return TRUE;
		}
	}
	
	
	// Controller
	// ---------------------------------------------------------------------------
	public static function controller($controller, $application = APPLICATION)
	{
		return self::file($application.'/'.config::get('folder_controllers'),$controller,'controller');
	}
	
	
	// Parent Controller
	// ---------------------------------------------------------------------------
	public static function parentController($controller, $application = APPLICATION)
	{
		return self::controller($controller, $application);
	}
	
	
	// Model
	// ---------------------------------------------------------------------------
	public static function model($model,$application = APPLICATION,$args=array())
	{
		// Model class
		$model_class = explode('/',$model);
		$model_class = ucfirst(end($model_class));		
		
		if(!class_exists($model_class))
		{
			$path = $application."/".config::get('folder_models')."/$model.php";
		
			// If model does not exist display error
			if(!file_exists($path))
			{
				dingoError(E_USER_ERROR,"The requested model ($path) could not be found.");
				return FALSE;
			}
			else
			{
				require_once($path);
			}
		}
		
		// Return model class
		return new $model_class();
	}
	
	
	// Parent Model
	// ---------------------------------------------------------------------------
	public static function parentModel($model, $application = APPLICATION)
	{
		// Model class
		$model_class = explode('/',$model);
		$model_class = ucfirst(end($model_class));		
		
		if(!class_exists($model_class))
		{
			$path = $application."/".config::get('folder_models')."/$model.php";
			
			// If model does not exist display error
			if(!file_exists($path))
			{
				dingoError(E_USER_ERROR,"The requested model ($path) could not be found.");
				return FALSE;
			}
			else
			{
				require_once($path);
				return TRUE;
			}
		}
	}
	
	
	// Error
	// ---------------------------------------------------------------------------
	public static function error($type = 'general',$title = NULL,$message = NULL)
	{
		ob_clean();
		require_once(SYSTEM.'/'.config::get('folder_errors')."/$type.php");
		ob_end_flush();
		exit;
	}
	
	
	// Config
	// ---------------------------------------------------------------------------
	public static function config($file, $application = APPLICATION)
	{
		$config = '/'.CONFIG;
		if($application=='frontend') $config .= '/'.CONFIGURATION;
		return self::file($application.$config,$file,'configuration');
	}
	
	
	// Language
	// ---------------------------------------------------------------------------
	public static function language($language, $application = APPLICATION)
	{
		return self::file($application.'/'.config::get('folder_languages'),$language,'language');
	}
	
	
	// View
	// ---------------------------------------------------------------------------
	public static function view($view,$data = NULL)
	{
		// If view does not exist display error
		if(!file_exists(APPLICATION.'/'.config::get('folder_views')."/$view.php"))
		{
			dingoError(E_USER_WARNING,'The requested view ('.APPLICATION.'/'.config::get('folder_views')."/$view.php) could not be found.");
			return FALSE;
		}
		else
		{
			// If data is array, convert keys to variables
			if(is_array($data))
			{
				extract($data, EXTR_OVERWRITE);
			}
			
			require(APPLICATION.'/'.config::get('folder_views')."/$view.php");
			return FALSE;
		}
	}
		
	
	// Library
	// ---------------------------------------------------------------------------
	public static function library($library)
	{
		return self::file(SYSTEM.'/library',$library,'library');
	}
	
	
	// Driver
	// ---------------------------------------------------------------------------
	public static function driver($library,$driver)
	{
		return self::file(SYSTEM."/driver/$library",$driver,'driver');
	}
	
	
	
	// Helper
	// ---------------------------------------------------------------------------
	public static function helper($helper, $application = APPLICATION)
	{
		return self::file($application.'/'.config::get('folder_helpers'),$helper,'helper');
	}
	
	
	// ORM Class
	// ---------------------------------------------------------------------------
	public static function ormClass($orm, $application = APPLICATION)
	{
		return self::file($application.'/'.config::get('folder_orm'),$orm,'ORM');
	}
	
	
	// ORM
	// ---------------------------------------------------------------------------
	public static function orm($orm, $application = APPLICATION)
	{
		self::ormClass($orm, $application);
		
		// ORM class
		$orm_class = explode('/',$orm);
		$orm_class = end($orm_class).'_orm';
		
		return new $ormClass();
	}
	
	
	// Parent ORM
	// ---------------------------------------------------------------------------
	public static function parentOrm($orm)
	{
		return self::orm($orm);
	}
}
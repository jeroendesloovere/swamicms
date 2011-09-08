<?php
/* system/library/cron.php */
// Jeroen Desloovere - 15-05-2011
class cron
{
	private static $tasks = array();
	private static $times = array('minutely','hourly','daily','weekly','monthly','yearly');
	
	// Add
	public static function add($time, $application, $controller, $method, $args = null)
	{
		if(in_array($time, self::$times)) self::$tasks[$time][] = array('application'=>$application, 'controller'=>$controller, 'method'=>$method, 'args'=>$args);
	}
	
	// Run
	public static function run($time)
	{
		if(isset(self::$tasks[$time]))
		{
			foreach(self::$tasks[$time] as $task)
			{
				// TODO
				// Execute route
				if($task['application']==BACKEND) $controller = ADMIN.'/'.$controller;
				route::get($controller.'/'.$method.'/'.implode('/', $args));
			}
		}
	}
}
<?php if(!defined('SWAMI')){die('External Access to File Denied');}
// Jeroen Desloovere - 15-05-2011

/* system/cron.php?time=daily */
/* system/cron.php?time=hourly */
/* system/cron.php?time=minutely */

// Did I forgot something else?
require_once('../index.php'); // Bootstrap runs here

// Library cron
load::library('cron');
	
// Backend cron
if(defined('BACKEND'))
{
	require_once(BACKEND.'/cron.php');
}

// Frontend cron
if(defined('FRONTEND'))
{
	require_once(FRONTEND.'/cron.php');
}

// Run
$time = (input::get('time')) ? input::get('time') : 'daily';
cron::run($time);
?>
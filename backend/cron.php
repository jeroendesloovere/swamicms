<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// Load backend cron functions
// Jeroen Desloovere - 15-05-2011

cron::add('daily',BACKEND,'stats','visitors');
cron::add('daily',BACKEND,'stats','keywords');
cron::add('daily',BACKEND,'stats','resources');
cron::add('hourly',BACKEND,'stats','resources');
cron::add('minutely',BACKEND,'stats','resources');


cron::add('weekly',BACKEND,'backup','index');
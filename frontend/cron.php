<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// Load frontend cron functions
// Jeroen Desloovere - 15-05-2011

cron::add('hourly',FRONTEND,'events','retrieveFromFacebook');
cron::add('hourly',FRONTEND,'events','retrieveFromGoogle');
cron::add('hourly',FRONTEND,'events','retrieveFromTwitter');
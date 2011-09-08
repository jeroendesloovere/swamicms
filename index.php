<?php

error_reporting(E_STRICT|E_ALL);

// Website configuration
//----------------------------------------------------------------------------------------------

// Configuration (deployment || development)
define('CONFIGURATION','development');

// Does Application Use Mod_Rewrite URLs?
define('MOD_REWRITE',TRUE);

// Allowed Characters in URL
define('ALLOWED_CHARS','/^[ \!\,\~\&\.\:\+\@\-_a-zA-Z0-9]+$/');
 
 
// Your Application's Default Timezone (local: http://www.php.net/timezones)
// ------------------------------------------------------------------
date_default_timezone_set('Europe/Brussels');


// Debug configuration
//----------------------------------------------------------------------------------------------

// Turn Debugging On?
define('DEBUG',TRUE);

// Turn Error Logging On?
define('ERROR_LOGGING',TRUE);

// Error Log File Location
define('ERROR_LOG_FILE','log.txt');


// Caching
// ------------------------------------------------------------------
define('CACHE', (DEBUG===true) ? !DEBUG : false);
define('CACHE_LIFETIME',60);


// Application configuration
//----------------------------------------------------------------------------------------------

// Swami Location
define('SYSTEM','system');

// Backend Location
define('BACKEND','backend');

// Frontend Location
define('FRONTEND','frontend');

// Config Directory Location (in relation to application location)
define('CONFIG','configs');


// End of configuration
//----------------------------------------------------------------------------------------------
define('SWAMI',1);
require_once(SYSTEM.'/core/bootstrap.php');
bootstrap::run();
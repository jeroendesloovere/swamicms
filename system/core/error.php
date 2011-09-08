<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Dingo Error Handling Functions
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 *
 * Many thanks to Kalle for providing code
 * http://www.talkphp.com/show-off/4070-dingo-framework-alpha-testing-open-3.html#post23025
 */

set_error_handler('swamiError');
set_exception_handler('swamiException');
		
// Errors
// ---------------------------------------------------------------------------
function swamiError($level,$message,$file='current file',$line='(unknown)')
{
	$fatal = false;
	$exception = false;
	
	switch($level)
	{
		case('exception'):
		{
			$prefix = 'Uncaught Exception';
			$exception = true;
		}
		break;
		case(E_RECOVERABLE_ERROR):
		{
			$prefix = 'Recoverable Error';
			$fatal	 = true;
		}
		break;
		case(E_USER_ERROR):
		{
			$prefix = 'Fatal Error';
			$fatal	 = true;
		}
		break;
		case(E_NOTICE):
		case(E_USER_NOTICE):
		{
			$prefix = 'Notice';
		}
		break;
		/* E_DEPRECATED & E_USER_DEPRECATED, available as of PHP 5.3 - Use their numbers here to prevent redefining them and two E_NOTICE's */
		case(8192):
		case(16384):
		{
			$prefix = 'Deprecated';
		}
		case(E_STRICT):
		{
			$prefix = 'Strict Standards';
		}
		break;
		default:
		{
			$prefix = 'Warning';
		}
	}
	
	$error = array(
		'level'=>$level,
		'prefix'=>$prefix,
		'message'=>$message,
		'file'=>$file,
		'line'=>$line
	);
	
	if($fatal)
	{
		ob_clean();
		
		if(file_exists(SYSTEM.'/'.config::get('folder_errors').'/fatal.php'))
		{
			require(SYSTEM.'/'.config::get('folder_errors').'/fatal.php');
		}
		else
		{
			echo 'Dingo could not locate error file at '.SYSTEM.'/'.config::get('folder_errors').'/fatal.php';
		}
		
		ob_end_flush();
		exit;
	}
	elseif($exception)
	{
		ob_clean();
		
		if(file_exists(SYSTEM.'/'.config::get('folder_errors').'/exception.php'))
		{
			require(SYSTEM.'/'.config::get('folder_errors').'/exception.php');
		}
		else
		{
			echo 'Dingo could not locate exception file at '.SYSTEM.'/'.config::get('folder_errors').'/exception.php';
		}
		
		ob_end_flush();
		exit;
	}
	elseif(DEBUG)
	{
		if(file_exists(SYSTEM.'/'.config::get('folder_errors').'/nonfatal.php'))
		{
			require(SYSTEM.'/'.config::get('folder_errors').'/nonfatal.php');
		}
		else
		{
			echo 'Dingo could not locate error file at '.SYSTEM.'/'.config::get('folder_errors').'/nonfatal.php';
		}
	}
	
	if(ERROR_LOGGING)
	{
		swamiErrorLog($error);
	}
}


// Exceptions
// ---------------------------------------------------------------------------
function swamiException($ex)
{
	swamiError('exception',$ex->getMessage(),$ex->getFile(),$ex->getLine());
	//echo "<p>Uncaught exception in {$exception->getFile()} on line {$exception->getLine()}: <strong>{$exception->getMessage()}</strong></p>";
}


// Error Logging
// ---------------------------------------------------------------------------
function swamiErrorLog($error)
{
	$date = date('g:i A M d Y');
	
	$fh = fopen(ERROR_LOG_FILE,'a');
	flock($fh,LOCK_EX);
	fwrite($fh,"[$date] {$error['prefix']}: {$error['message']} IN {$error['file']} ON LINE {$error['line']}\n");
	flock($fh,LOCK_UN);
	fclose($fh);
}

/**
 * SwamiException
 *
 * @author          Jeroen Desloovere
 * @date			09-06-2011
 * @copyright		2011
 * @project page    http://www.swami.be
 
class testException
{       
    public function __construct($x)
    {
    	$this->x=$x;
    }
   
    function see()
    {
    	if($this->x==9 )
        {
            throw new SwamiException("i didnt like it");
        }
    }
}

$obj = new testException(9);
try
{
    $obj->see();
}
catch(SwamiException $e)
{
    echo $e;
} 
*/
 
class SwamiException extends Exception
{
    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }
   
    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}
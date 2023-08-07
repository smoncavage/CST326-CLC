/*
Stephan Moncavage
CST323
9/10/2021
Logging Module
*/
/* 
https://www.loggly.com/ultimate-guide/php-logging-basics/

Directive 	Default 	Recommended 	Description
display_errors ** 	1 	0 	Defines whether errors are included in output.
display_startup_errors 	0 	0 	Whether to display PHP startup sequence errors.
error_log *** 	0 	path 	Path to the error log file. When running PHP in a Docker container, consider logging to stdout instead.
error_reporting 	null 	E_ALL 	The minimum error reporting level.
log_errors 	0 	1 	Toggles error logging.
log_errors_max_length 	1024 	1024 	Max length of logged errors. Set to zero for no maximum.
report_memleaks 	1 	0 	Reports memory leaks detected by Zend memory manager.
track_errors 	0 	1 	Stores the last error message in $php_errormsg. 
*/

<?php

use Monolog\Logger;
use Monolog\Handler\LogglyHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Processor\WebProcessor;

class MyLogger implements ILogger{
	
	$xmlin = simplexml_load_file("config.xml") or die("Error: Cannot create object");
	private static $logger = null;
		
	static function getLogger(){
		if(self::$logger == null){
			//Log to Standard 
			self::$logger = new Logger('phpLog');
			self::$logger->pushHandler(new LogglyHandler($xmlin->tokens[0]+'/tag/monolog', Logger::DEBUG));
			self::$logger->addWarning('test logs to loggly');
		}
		return self::$logger;
	}
	
	public static funtion debug($message, $data=array()){
		self::getLogger()->addDebug($message, $data);
	}
	
	public static funtion info($message, $data=array()){
		self::getLogger()->addInfo($message, $data);
	}
	
	public static funtion warning($message, $data=array()){
		self::getLogger()->addWarning($message, $data);
	}
	
	public static funtion error($message, $data=array()){
		self::getLogger()->addError($message, $data);
	}
}
>?
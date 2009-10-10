<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class PhpErrorHandler {
	// Public:
		
		static public function addError($errno, $errstr, $errfile, $errline) {
			if (error_reporting() & $errno) {
				self::$errors[] = array("number"    => $errno  ,
				                        "message"   => $errstr ,
				                        "file"      => $errfile,
				                        "line"      => $errline,
				                        "backtrace" => debug_backtrace());
			}
			
			if ($errno & (E_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR)) {
				self::printErrors();
				exit(1);
			}
			
			return true;
		}
		
		static public function printErrors() {
			$typeString = array(E_WARNING           => "warning",
			                    E_NOTICE            => "notice" ,
			                    E_USER_ERROR        => "error"  ,
			                    E_USER_WARNING      => "warning",
			                    E_USER_NOTICE       => "notice" ,
			                    E_RECOVERABLE_ERROR => "error");
			
			if (count(self::$errors) > 0)
				echo '<div class="errorblock"><h1 style="margin: 1px;">PHP Errors:</h1></div>';
			foreach (self::$errors as $error) {
				require 'templates/error.tpl.php';
			}
		}
	
	// Private static variables:
		
		static private $errors = array();
}

?>

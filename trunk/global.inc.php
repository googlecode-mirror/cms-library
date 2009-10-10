<?php if (!defined("ALLOW_INCLUDES")) exit(1);

$include_returns = array();

function include_file($file) {
	global $include_returns;
	// TODO: Don't use basename, but rather a full path (must be a normal form)
	if (!array_key_exists(basename($file), $include_returns))
		$include_returns[basename($file)] = require_once $file;
	
	return $include_returns[basename($file)];
}

function __autoload($className) {
	static $subdirs = array('.', 'filters', 'types', 'tree');
	
	$fileName = strtolower($className) . '.inc.php';
	
	foreach ($subdirs as $subdir) {
		$fileToTry = dirname(__FILE__) . "/$subdir/$fileName";
		if (file_exists($fileToTry)) {
			include_file($fileToTry);
			return;
		}
	}
	
	trigger_error("Autoloader: The class called '$className' was not found.", E_USER_ERROR);
}

error_reporting(E_ALL);

set_error_handler(array('PhpErrorHandler', 'addError'));

function lfile($filename) {
	return substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')) . '/' . $filename;
}

session_start();

Database::connect();

?>

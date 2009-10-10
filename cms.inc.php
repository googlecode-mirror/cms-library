<?php

define("ALLOW_INCLUDES", true);

require_once "global.inc.php";

class CMS {
	// Static public functions
		
		static public function mode() {
			return Request::get('mode');
		}
		
		static public function path() {
			return Request::get('path');
		}
		
		static public function output($function) {
			if (!self::$root)
				self::loadRoot();
			self::$root->output($function, Request::get('path'));
		}
	
	// Static private functions
		
		static private function loadRoot() {
			self::$root = Object::loadObject(0);
		}
	
	// Static private variables
		
		static private $root = NULL;
}

?>

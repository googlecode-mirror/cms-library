<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Options {
	// Public static functions
		
		static public function debugMode() {
			return true;
		}
		
		static public function tablePrefix() {
			return "ccms_";
		}
		
		static public function defaultRequestVars() {
			return array('mode' => 'view'
			            ,'path' => '/');
		}
		
		// Database connection options
		
		static public function dbServer() {
			return "localhost";
		}
		
		static public function dbUsername() {
			return "tester";
		}
		
		static public function dbPassword() {
			return "testpass";
		}
		
		static public function dbName() {
			return "cmstest";
		}
		
		static public function dbEngine() {
			return "InnoDB";
		}
}

?>

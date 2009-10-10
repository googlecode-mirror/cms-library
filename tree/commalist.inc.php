<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class CommaList extends Set {
	////////////////////////////////////////////////////////////////////////////////////////////////
	// STATIC                                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public static variables
		
		static public $columns = array();
	
	// Public static functions
		
		static public function buildDatabase() { }
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// NON-STATIC                                                                                 //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public functions
		
		public function __construct($id) {
			parent::__construct($id);
		}
		
		public function output($function, Path $relativePath) {
			Set::printList($function, $relativePath);
		}
		
		public function prefix($function, Path $relativePath) {
			echo "(";
		}
		
		public function infix($function, Path $relativePath) {
			echo ', ';
		}
		
		public function postfix($function, Path $relativePath) {
			echo ')';
		}
		
		public function placeholder($function, Path $relativePath) {
			echo htmlentities('<Empty List>');
		}
}

return "CommaList";

?>

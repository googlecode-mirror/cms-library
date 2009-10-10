<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class String extends Object {
	// Public static variables
		
		public static $columns = array('string' => 'text');
	
	// Public function
		
		public function output($function, Path $relativePath) {
			echo $this->data('string');
		}
}

return "String";

?>

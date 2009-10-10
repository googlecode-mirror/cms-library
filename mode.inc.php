<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Mode {
	// Public functions
		
		static public function valid($str) {
			return ($str == "view" || $str == "edit");
		}
		
		public function __construct($mode) {
			if (!self::valid($mode))
				trigger_error(__CLASS__ . ": The Mode constructor was called with an invalid string parameter.", E_USER_ERROR);
			$this->mode = $mode;
		}
		
		public function __toString() {
			return $this->mode;
		}
	
	// Private variables
		
		private $mode;
}

?>

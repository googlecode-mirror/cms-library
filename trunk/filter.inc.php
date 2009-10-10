<?php if (!defined("ALLOW_INCLUDES")) exit(1);

abstract class Filter {
	// Filter factory
		
		static private $factory = NULL;
		
		static public function get($name) {
			if (self::$factory == NULL)
				self::$factory = new Factory('filters');
			
			return self::$factory->get($name);
		}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// NON-STATIC                                                                                 //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public functions
		
		abstract public function name();
		
		/// Meant to be overloaded.
		/// Default: 'Does not transform the input.'
		///
		public function applyDescription() {
			return 'Does not transform the input.';
		}
		
		/// Meant to be overloaded.
		/// Default: Leaves $string unchanged.
		///
		public function apply(&$string) {
		} // intentionally empty
		
		/// Meant to be overloaded.
		/// Default: 'Every input is valid.'
		///
		public function validateDescription() {
			return 'Every input is valid.';
		}
		
		/// Meant to be overloaded.
		/// Default: Every input is valid.
		///
		public function validate($string) {
			return true;
		}
}

?>

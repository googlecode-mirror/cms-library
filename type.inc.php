<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Type {
	// Type factory
		
		static private $factory = NULL;
		
		static public function get($name) {
			if (self::$factory == NULL)
				self::$factory = new Factory('types');
			
			return self::$factory->get($name);
		}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// NON-STATIC                                                                                 //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public functions
		
		public function __construct($name, $mySqlName) {
			$this->name = $name;
			$this->mySqlName = $mySqlName;
		}
		
		public function name() {
			return $this->name;
		}
		
		public function mySqlName() {
			return $this->mySqlName;
		}
		
		public function inputFilters() {
			return $this->inputFilters;
		}
		
		public function outputFilters() {
			return $this->outputFilters;
		}
		
		public function addInputFilter($filter) {
			$this->inputFilters[] = $filter;
		}
		
		public function addOutputFilter($filter) {
			$this->ouputFilters[] = $filter;
		}
		
		public function applyInputFilters(&$text) {
			foreach($this->inputFilters as $filter) {
				$filter->apply($text);
			}
		}
		
		public function applyOutputFilters(&$text) {
			foreach($this->outputFilters as $filter) {
				$filter->apply($text);
			}
		}
	
	// Private variables
		
		private $name;
		private $mySqlName;
		private $inputFilters = array();
		private $outputFilters = array();
}

?>

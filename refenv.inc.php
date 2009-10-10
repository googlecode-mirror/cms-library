<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class RefEnv implements Iterator {
	// Public functions
		
		public function set($name, $value) {
			$this->vars[$name] = $value;
		}
		
		public function remove($name) {
			if (!$this->exists($name))
				trigger_error(__CLASS__ . ": The variable '$name' was not in the referencing environment.", E_USER_WARNING);
			
			unset($this->vars[$name]);
		}
		
		public function exists($name) {
			return isset($this->vars[$name]);
		}
		
		public function get($name) {
			if (!$this->exists($name))
				trigger_error(__CLASS__ . ": The variable '$name' was not in the referencing environment.", E_USER_ERROR);
			else
				return $this->vars[$name];
		}
		
		// Iterator interface
		
		public function rewind() {
			reset($this->vars);
		}
		
		public function current() {
			return current($this->vars);
		}
		
		public function key() {
			return key($this->vars);
		}
		
		public function next() {
			return next($this->vars);
		}
		
		public function valid() {
			return ($this->current() !== false);
		}
	
	// Private variables
		
		private $vars = array();
}

?>

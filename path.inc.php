<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Path {
	// Public functions
		
		static public function valid($path) {
			return preg_match('/^(?:\/\w+)*\/?$/', $path);
		}
		
		public function __construct($path) {
			if (is_array($path)) {
				$this->path = $path;
			} else if (is_string($path)) {
				if (!self::valid($path))
					trigger_error(__CLASS__ . ": The Path constructor was called with an invalid string parameter.", E_USER_ERROR);
				if (substr($path, -1) == '/')
					$this->path = explode('/', substr($path, 1, -1));
				else
					$this->path = explode('/', substr($path, 1));
			} else
				trigger_error(__CLASS__ . ": The Path constructor was called without a string or array parameter.", E_USER_ERROR);
		}
		
		public function __toString() {
			return '/' . implode('/', $this->path);
		}
		
		public function depth() {
			return count($this->path);
		}
		
		public function node($id) {
			return $this->path[$id];
		}
		
		public function head() {
			return $this->path[0];
		}
		
		public function tail() {
			return new Path(array_slice($this->path, 1));
		}
	
	// Private variables
		
		private $path;
}

?>

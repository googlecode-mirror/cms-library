<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Factory {
	// Public functions
		
		public function __construct($dir) {
			if (!is_dir($dir))
				trigger_error(__CLASS__ . ": The '$dir' directory does not exist.", E_USER_ERROR);
			
			$this->dir = $dir;
		}
		
		public function get($name) {
			if (!isset($this->items[$name]))
				$this->load($name);
			return $this->items[$name];
		}
		
		public function get_all() {
			$dir = new DirectoryIterator($this->dir);
			// TODO: Find a way to impose a loading order (so the foreign keys can come back)
			foreach ($dir as $fileinfo) {
				if (!$fileinfo->isDot()) {
					$this->load(basename($fileinfo, '.inc.php'));
				}
			}
			return $this->items;
		}
	
	// Private functions
		
		private function load($name) {
			$file = $this->dir . '/' . strtolower($name) . '.inc.php';
			
			if (!is_file($file))
				trigger_error(__CLASS__ . ": The file '$file' does not exist.", E_USER_ERROR);
			
			$this->items[$name] = include_file($file);
		}
	
	// Private variables
		
		private $dir;
		private $items = array();
}

?>

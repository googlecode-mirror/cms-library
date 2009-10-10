<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Set extends Object {
	////////////////////////////////////////////////////////////////////////////////////////////////
	// STATIC                                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public static variables
		
		static public $columns = array();
	
	// Public static functions
		
		static public function buildDatabase() {
			self::createElementsTable();
		}
	
	// Protected static functions
		
		static protected function elementsTableName() {
			return self::tableName(__CLASS__) . '_elements';
		}
	
	// Private static functions
		
		static private function createElementsTable() {
			$query = 'CREATE TABLE `' . self::elementsTableName() . '` (';
				$query .=    '`parent_id` BIGINT UNSIGNED NOT NULL, ';
				$query .=   '`element_id` BIGINT UNSIGNED NOT NULL, ';
				$query .= '`manual_order` BIGINT UNSIGNED NOT NULL, ';
				$query .= 'PRIMARY KEY (`parent_id`, `element_id`)';
				//// TODO: Put foreign key constraints back when creation of tables can have topological order imposed.
				//if ($type != __CLASS__)
				//	$query .= ', FOREIGN KEY (`parent_id`, `element_id`) REFERENCES `' . self::elementsTableName($class->getParentClass()->getName()) . '` (`parent_id`, `element_id`) ON DELETE CASCADE';
			$query .= ') engine=' . Options::dbEngine() . ';';
			
			Database::query($query, "Set elements table");
		}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// NON-STATIC                                                                                 //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public functions
		
		public function __construct($id) {
			parent::__construct($id);
		}
		
		// Meant to be overloaded
		// Default: Prints it like a list, using prefix, postfix, infix and placeholder
		public function output($function, Path $relativePath) {
			$this->printList($function, $relativePath);
		}
		
		final protected function printList($function, Path $relativePath) {
			if ($this->size() == 0) {
				$this->placeholder($function);
			} else {
				$this->prefix($function, $relativePath);
				for ($i = 0; $i < $this->size(); ++$i) {
					$this->element($i)->output($function, $relativePath->tail());
					if ($i < $this->size() - 1)
						$this->infix($function, $relativePath);
				}
				$this->postfix($function, $relativePath);
			}
		}
		
		final public function size() {
			$this->loadElementIdentities();
			return $this->size;
		}
		
		final public function element($index) {
			$this->loadElement($index);
			return $this->elements[$index];
		}
		
		// Meant to be overloaded
		// Default: No output
		public function prefix($function, Path $relativePath) { }
		
		// Meant to be overloaded
		// Default: No output
		public function infix($function, Path $relativePath) { }
		
		// Meant to be overloaded
		// Default: No output
		public function postfix($function, Path $relativePath) { }
		
		// Meant to be overloaded
		// Default: No output
		public function placeholder($function, Path $relativePath) { }
	
	// Private functions
		
		private function loadElement($index) {
			if (!array_key_exists($index, $this->elements)) {
				$this->loadElementIdentities();
				if ($index >= $this->size())
					trigger_error(__CLASS__ . ": Requested element does not exist.", E_USER_ERROR);
				$this->elements[$index] = Object::loadObject($this->elementIdentities[$index]);
			}
		}
		
		private function loadElementIdentities() {
			if ($this->elementIdentities == NULL) {
				$query = Database::query("SELECT `element_id` FROM `" . self::elementsTableName() . "` WHERE `parent_id` = {$this->data('id')} ORDER BY `manual_order`", "{$this->data('id')} element identities}");
				while ($element = mysql_fetch_assoc($query))
					$this->elementIdentities[] = $element['element_id'];
				
				$this->size = count($this->elementIdentities);
			}
		}
	
	// Private variables
		
		private $elements          = array();
		private $elementIdentities = NULL;
		private $size              = NULL;
}

return "Set";

?>

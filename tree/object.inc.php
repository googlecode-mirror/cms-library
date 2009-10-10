<?php if (!defined("ALLOW_INCLUDES")) exit(1);

abstract class Object {
	////////////////////////////////////////////////////////////////////////////////////////////////
	// STATIC                                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public static variables
		
		public static $columns = array('type' => 'name');
	
	// Public static functions
		
		public static function columns($type) {
			$columns = array();
			
			$class = new ReflectionClass($type);
			
			while (true) {
				$newColumns = $class->getStaticPropertyValue('columns', array());
				
				if (Options::debugMode()) {
					$intersection = array_intersect_key($columns, $newColumns);
					if (count($intersection)) {
						$intersection = implode(', ', array_keys($intersection));
						trigger_error(__CLASS__ . ": The following data-columns appear more than once in the class hierarchy of '$type': $intersection", E_USER_ERROR);
					}
				}
				
				$columns = array_merge($columns, $newColumns);
				
				if ($class->getName() == __CLASS__) {
					$columns['id'] = 'identifier';
					return $columns;
				}
				
				$class = $class->getParentClass();
			}
		}
		
		public static function dataExists($type, $column) {
			return array_key_exists($column, self::columns($type));
		}
		
		public static function loadObject($id) {
			$query = Database::query('SELECT `type` FROM ' . self::tableName('Object') . " WHERE `id` = $id", "Load $id type");
			$columns = mysql_fetch_row($query);
			$type = $columns[0];
			
			$reflectionClass = new ReflectionClass($type);
			return $reflectionClass->newInstance($id);
		}
		
		public static function prepareDatabase($type) {
			self::createTable($type);
			self::callBuildDatabase($type);
		}
	
	// Protected static functions
		
		protected static function tableName($type) {
			return Options::tablePrefix() . $type;
		}
	
	// Private static functions
		
		private static function createTable($type) {
			$class = new ReflectionClass($type);
			$columns = $class->getStaticPropertyValue('columns', array());
			$columns['id'] = 'identifier';
			$declarations = "";
			
			foreach ($columns as $name => $typeName)
				$declarations .= "`$name` " . Type::get($typeName)->mySqlName() . ", ";
			
			$query = "CREATE TABLE `" . self::tableName($type) . "` (";
				$query .= $declarations;
				$query .= "PRIMARY KEY (`id`)";
				//// TODO: Put foreign key constraints back when creation of tables can have topological order imposed.
				//if ($type != __CLASS__)
				//	$query .= ", FOREIGN KEY (`id`) REFERENCES `" . self::tableName($class->getParentClass()->getName()) . "` (`id`) ON DELETE CASCADE";
			$query .= ") engine=" . Options::dbEngine() . ";";
			
			Database::query($query, "$type table");
		}
		
		private static function callBuildDatabase($type) {
			$class = new ReflectionClass($type);
			if ($class->hasMethod('buildDatabase')) {
				$method = $class->getMethod('buildDatabase');
				if ( !self::hasBuildDatabaseSignature($method) )
					trigger_error(__CLASS__ . ": The class '$type' has a function named 'buildDatabase'. But its signature is not right.", E_USER_ERROR);
				$method->invoke(NULL);
			} else {
				trigger_error(__CLASS__ . ": The class '$type' has no 'buildDatabase' function. Only a standard table will be created.", E_USER_NOTICE);
			}
		}
		
		private static function hasBuildDatabaseSignature($method) {
			return ($method->isStatic() && $method->isPublic() && !$method->isAbstract() && $method->getNumberOfRequiredParameters() == 0);
		}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// NON-STATIC                                                                                 //
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Public functions
		
		public function __construct($id) {
			$this->data['id'] = $id;
		}
		
		// Meant to be overloaded
		// No default behavior
		abstract public function output($function, Path $relativePath);
		
		final public function type() {
			return get_class($this);
		}
		
		final public function data($column) {
			if (!$this->dataIsLoaded($column))
				$this->loadData();
			return $this->data[$column];
		}
	
	// Private functions
		
		final private function dataIsLoaded($column) {
			if (!self::dataExists($this->type(), $column))
				trigger_error(__CLASS__ . ": '" . $this->type() . "' doesn't have a data-column named '$column'.", E_USER_ERROR);
			
			return isset($this->data[$column]);
		}
		
		final private function loadData() {
			$queryTableList = array();
			$queryCondition = array();
			
			$class = new ReflectionClass($this->type());
			
			while (true) {
				$queryTableList[] = "`" . self::tableName($class->getName()) . "`";
				$queryCondition[] = "`" . self::tableName($class->getName()) . '`.`id` = ' . $this->data['id'];
				
				if ($class->getName() == __CLASS__) // If it's the root class
					break;
				
				$class = $class->getParentClass();
			}
			
			$queryTableList = implode(', ',    $queryTableList);
			$queryCondition = implode(' AND ', $queryCondition);
			
			$query = Database::query("SELECT * FROM $queryTableList WHERE $queryCondition", "Load {$this->data['id']}");
			
			$this->data = mysql_fetch_assoc($query);
		}
	
	// Private variables
		
		private $data = array();
}

return "Object";

?>

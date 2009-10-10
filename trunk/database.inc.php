<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Database {
	// Public static functions
		
		static public function connect() {
			mysql_connect(Options::dbServer(), Options::dbUsername(), Options::dbPassword());
			mysql_select_db(Options::dbName());
		}
		
		static public function query($query, $debugName = NULL) {
			if (Options::debugMode())
				self::$queries[] = array('name' => $debugName, 'query' => $query);
			
			$q = mysql_query($query);
			
			if ($q === false) {
				self::printQueries();
				trigger_error(__CLASS__ . ": " . mysql_error(), E_USER_ERROR);
			}
			
			return $q;
		}
		
		static public function printQueries() {
			echo '<div class="errorblock">';
			echo '<div class="errorheader">Database queries:</div>';
			
			foreach (self::$queries as $query)
				Debug::query($query['query'], $query['name']);
			
			echo '</div>';
		}
	
	// Private static variables
		
		static private $queries = array();
}

?>

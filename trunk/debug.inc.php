<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class Debug {
	static public function variable(&$var, $name = NULL) {
		echo '<div class="debug">';
		echo '<pre>';
		
		if (is_string($name))
			echo "<b>$name</b> = ";
		
		var_export($var);
		echo '</pre>';
		echo '</div>';
	}
	
	static public function string(&$str, $name = NULL) {
		echo '<div class="debug">';
		echo '<pre>';
		
		if (is_string($name))
			echo "<b>$name</b> = ";
		
		echo (string)$str;
		echo '</pre>';
		echo '</div>';
	}
	
	static public function query($query, $name = NULL) {
		self::processMysqlKeywords();
		
		echo '<div class="debug">';
		echo '<pre>';
		
		if (is_string($name))
			echo "<i>$name</i> = ";
		
		$query = preg_replace(self::$mysqlKeywords, '<b>$0</b>',                             $query);
		$query = preg_replace(self::$mysqlTypes,    '<span style="color: red;">$0</span>',   $query);
		$query = preg_replace('/`(\w*)`/',          '<span style="color: green;">$0</span>', $query);
		
		echo $query;
		echo '</pre>';
		echo '</div>';
	}
	
	// Static private functions
		
		static private function processMysqlKeywords() {
			if (self::$mysqlKeywords == NULL) {
				self::$mysqlKeywords = array('ACCESSIBLE', 'ADD', 'ALL',
				                             'ALTER', 'ANALYZE', 'AND',
				                             'AS', 'ASC', 'ASENSITIVE', 'AUTO_INCREMENT',
				                             'BEFORE', 'BETWEEN', 
				                             'BOTH',
				                             'BY', 'CALL', 'CASCADE',
				                             'CASE', 'CHANGE', 
				                             'CHECK', 'COLLATE',
				                             'COLUMN', 'CONDITION', 'CONSTRAINT',
				                             'CONTINUE', 'CONVERT', 'CREATE',
				                             'CROSS', 'CURRENT_DATE', 'CURRENT_TIME',
				                             'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR',
				                             'DATABASE', 'DATABASES', 'DAY_HOUR',
				                             'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND',
				                             'DECLARE',
				                             'DEFAULT', 'DELAYED', 'DELETE',
				                             'DESC', 'DESCRIBE', 'DETERMINISTIC',
				                             'DISTINCT', 'DISTINCTROW', 'DIV',
				                             'DROP', 'DUAL',
				                             'EACH', 'ELSE', 'ELSEIF',
				                             'ENCLOSED', 'ESCAPED', 'EXISTS',
				                             'EXIT', 'EXPLAIN', 'FALSE',
				                             'FETCH',
				                             'FOR', 'FORCE',
				                             'FOREIGN', 'FROM', 'FULLTEXT',
				                             'GRANT', 'GROUP', 'HAVING',
				                             'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE',
				                             'HOUR_SECOND', 'IF', 'IGNORE',
				                             'IN', 'INDEX', 'INFILE',
				                             'INNER', 'INOUT', 'INSENSITIVE',
				                             'INSERT',
				                             'INTERVAL',
				                             'INTO', 'IS', 'ITERATE',
				                             'JOIN', 'KEY', 'KEYS',
				                             'KILL', 'LEADING', 'LEAVE',
				                             'LEFT', 'LIKE', 'LIMIT',
				                             'LINEAR', 'LINES', 'LOAD',
				                             'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK',
				                             'LOOP', 'LOW_PRIORITY', 'MASTER_SSL_VERIFY_SERVER_CERT',
				                             'MATCH', 'MINUTE_MICROSECOND',
				                             'MINUTE_SECOND', 'MOD', 'MODIFIES',
				                             'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG',
				                             'NULL', 'ON',
				                             'OPTIMIZE', 'OPTION', 'OPTIONALLY',
				                             'OR', 'ORDER', 'OUT',
				                             'OUTER', 'OUTFILE', 'PRECISION',
				                             'PRIMARY', 'PROCEDURE', 'PURGE',
				                             'RANGE', 'READ', 'READS',
				                             'READ_ONLY', 'READ_WRITE',
				                             'REFERENCES', 'REGEXP', 'RELEASE',
				                             'RENAME', 'REPEAT', 'REPLACE',
				                             'REQUIRE', 'RESTRICT', 'RETURN',
				                             'REVOKE', 'RIGHT', 'RLIKE',
				                             'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND',
				                             'SELECT', 'SENSITIVE', 'SEPARATOR',
				                             'SET', 'SHOW', 
				                             'SPATIAL', 'SPECIFIC', 'SQL',
				                             'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING',
				                             'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT',
				                             'SSL', 'STARTING', 'STRAIGHT_JOIN',
				                             'TABLE', 'TERMINATED', 'THEN',
				                             'TO', 'TRAILING', 'TRIGGER',
				                             'TRUE', 'UNDO', 'UNION',
				                             'UNIQUE', 'UNLOCK', 'UNSIGNED',
				                             'UPDATE', 'USAGE', 'USE',
				                             'USING', 'VALUES', 'VARYING',
				                             'WHEN', 'WHERE', 'WHILE',
				                             'WITH', 'WRITE', 'X509',
				                             'XOR', 'YEAR_MONTH', 'ZEROFILL');
				self::$mysqlTypes = array('BIGINT','BINARY', 'BLOB','CHAR','CHARACTER', 
				                          'DEC', 'DECIMAL','DOUBLE', 'FLOAT', 'FLOAT4',
				                          'FLOAT8', 'INT', 'INT1','INT2', 'INT3', 'INT4',
				                          'INT8', 'INTEGER', 'LONG', 'LONGBLOB', 'LONGTEXT',
				                          'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT',
				                          'NUMERIC', 'REAL', 'SERIAL', 'SMALLINT', 'TEXT',
				                          'TINYBLOB', 'TINYINT', 'TINYTEXT',
				                          'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VARBINARY',
				                          'VARCHAR', 'VARCHARACTER');
				
				foreach (self::$mysqlKeywords as &$keyword)
					$keyword = '/\b' . $keyword . '\b/';
				
				foreach (self::$mysqlTypes as &$keyword)
					$keyword = '/\b' . $keyword . '\b/';
			}
		}
	
	// Static private variables
		
		static private $mysqlKeywords = NULL;
		static private $mysqlTypes = NULL;
}

?>

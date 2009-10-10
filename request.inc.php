<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class PostSource {
	public function has($name) { return array_key_exists($name, $_POST); }
	public function get($name) { return $_POST[$name]; }
}

class GetSource {
	public function has($name) { return array_key_exists($name, $_GET); }
	public function get($name) { return $_GET[$name]; }
}

class SessionSource {
	public function has($name) { return array_key_exists($name, $_SESSION); }
	public function get($name) { return $_SESSION[$name]; }
}

class UrlPathSource {
	public function has($name) { return array_key_exists('PATH_INFO', $_SERVER); }
	public function get($name) { return $_SERVER['PATH_INFO']; }
}

class DefaultSource {
	public function has($name) { return array_key_exists($name, Options::defaultRequestVars()); }
	public function get($name) { $vals = Options::defaultRequestVars(); return $vals[$name]; }
}

class Request {
	// Public static functions
		
		static public function get($name) {
			if (!self::has($name))
				trigger_error(__CLASS__ . ": The variable '$name' does not have a value.", E_USER_ERROR);
			
			return self::$values[$name];
		}
		
		static public function has($name) {
			if (!array_key_exists($name, self::$values))
				self::load($name);
			
			return !is_null(self::$values[$name]);
		}
	
	// Private static functions
		
		static private function load($name) {
			if (!self::$specs)
				self::loadSpecs();
			
			if (!self::$sources)
				self::loadSources();
			
			if (!isset(self::$specs[$name]))
				trigger_error(__CLASS__ . ": The '$name' property is not supported.", E_USER_ERROR);
			
			$result = NULL;
			
			foreach (self::$specs[$name]['sources'] as $source)
				if (self::trySource($name, $source, $result)) break;
			
			if ($result == NULL)
				trigger_error(__CLASS__ . ": The '$name' property has no value.", E_USER_ERROR);
			
			if (self::$specs[$name]['class']) {
				$class = new ReflectionClass(self::$specs[$name]['class']);
				self::$values[$name] = $class->newInstance($result);
			} else {
				self::$values[$name] = $result;
			}
		}
		
		static private function trySource($name, $source, &$result) {
			$source = self::$sources[$source];
			
			if (!$source->has($name))
				return false;
			
			$result = $source->get($name);
			
			if (!self::isValid($name, $result))
				return false;
			
			if (in_array('session', self::$specs[$name]['sources']))
				$_SESSION[$name] = $result;
			
			return true;
		}
		
		static private function isValid($name, $str) {
			if (self::$specs[$name]['class'] == NULL)
				return true;
			
			$class = new ReflectionClass(self::$specs[$name]['class']);
			return (!$class->hasMethod("valid")
			      || $class->getMethod("valid")->invoke(NULL, $str) );
		}
		
		static private function loadSpecs() {
			self::$specs = array('path'      => array('class'   => 'Path'
			                                         ,'sources' => array('urlpath', 'default')
			                                         ,'multi'   => false)
			                    ,'mode'      => array('class'   => 'Mode'
			                                         ,'sources' => array('get', 'post', 'session', 'default')
			                                         ,'multi'   => false)
			                    ,'operation' => array('class'   => 'Operation'
			                                         ,'sources' => array('post')
			                                         ,'multi'   => true)
			                    );
		}
		
		static private function loadSources() {
			self::$sources = array('post'    => new PostSource
			                      ,'get'     => new GetSource
			                      ,'session' => new SessionSource
			                      ,'urlpath' => new UrlPathSource
			                      ,'default' => new DefaultSource);
		}
	
	// Private static variables
		
		static private $specs   = NULL;
		static private $sources = NULL;
		static private $values  = array();
}

?>

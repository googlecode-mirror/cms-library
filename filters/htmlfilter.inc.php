<?php if (!defined("ALLOW_INCLUDES")) exit(1);

class HtmlFilter extends Filter {
	// Public functions
		
		public function name() {
			return "HTML Escape Filter";
		}
		
		public function applyDescription() {
			return 'Removes all HTML entities and tags from the string so it can be placed as plain text in a webpage.';
		}
		
		public function apply(&$string) {
			$string = htmlentities($string);
		}
}

?>

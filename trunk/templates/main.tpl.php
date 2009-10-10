<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
	<head>
		<title>CMS-library Test</title>
		<link type="text/css" rel="stylesheet" media="screen, projection" href="<?= lfile('phperrorhandler.css') ?>" title="Normal" />
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta name="title" content="CMS-library Test" />
		<meta name="creator" content="Michiel Helvensteijn" />
	</head>
	<body>
		<?php
			
			Debug::variable($_SERVER['PATH_INFO'], '$_SERVER[\'PATH_INFO\']');
			Debug::string(Request::get('mode'), 'mode');
			Debug::string(Request::get('path'), 'path');
			
			$factory = new Factory('tree');
			foreach ($factory->get_all() as $type) {
				Object::prepareDatabase($type);
			}
			if (Options::debugMode())
				Database::printQueries();
			
// 			CMS::output("whatever");
		?>
		
		<?php PhpErrorHandler::printErrors(); ?>
	</body>
</html>

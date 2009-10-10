<?php if (!defined("ALLOW_INCLUDES")) exit(1);

$type = new Type('name', 'VARCHAR(256)');

$type->addOutputFilter('htmlfilter');

return $type;

?>

<?php

return array(
'name' => "Video Chat",
	'install' => array(
		dirname(__FILE__) . '/data/install.sql'
	),
	'uninstall' => array(
		dirname(__FILE__) . '/data/uninstall.sql',
	),
	'editable' => true,
	'searchable' => true,
	'adminOnly' => false,
	'custom' => false,
	'toggleable' => false,
	'version' => '1.0'
);
?>

<?php

return array(
    'name' => "Newsletters",
    'install' => array(
        dirname(__FILE__) . '/data/install.sql',
        dirname(__FILE__) . '/data/sample_data.sql'
    ),
    'uninstall' => array(
        dirname(__FILE__) . '/data/uninstall.sql'
    ),
    'editable' => false,
    'searchable' => false,
    'adminOnly' => false,
    'custom' => false,
    'toggleable' => false,
    'version' => '1.0',
);
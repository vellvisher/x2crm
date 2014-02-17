<?php
/**
 * Modules to be listed in the installer as available.
 * 
 * Note that they must be listed in order such that any tables they depend on
 * are created first. For example, the charts module requires the users module
 * to be installed; part of its installation lies in creating a view that 
 * references tables including the users table.
 * 
 * @todo Create a system to specify module dependencies (e.g. charts depends on 
 * a bunch of others that need to be installed first) and resolve them / install
 * them in the proper order in the installation process. 
 */
$iniModules = array(
	'accounts',
	'actions',
	'calendar',
	'contacts',
	'users',
	'docs',
	'groups',
	'marketing',
	'media',
	'opportunities',
	'products',
	'quotes',
	'reports',
	'workflow',
	'charts',
	'services',
    'bugReports',
    'videoChat',
    'chat'
);

// Search for module availability; criteria = existence of register.php
$modules = array();
foreach($iniModules as $module) {
	if(file_exists(dirname(__FILE__)."/../modules/$module/register.php")) {
		$modules[] = $module;
	}
}

return $modules;
?>

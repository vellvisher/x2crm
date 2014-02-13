<?php
include "X2Config.php";
return array(
    'modules' => array(
		 'gii'=>array('class'=>'system.gii.GiiModule',
           'password'=>'admin',
           // If removed, Gii defaults to localhost only. Edit carefully to taste.
           'ipFilters'=>false,
       ),
    ),
    'components' => array(
        'db' => array(
            'connectionString' => "mysql:host=$host;dbname=$dbname",
            'emulatePrepare' => true,
            'username' => 'x2crm',
            'password' => $pass,
            'charset' => 'utf8',
            //'enableProfiling'=>true,
            //'enableParamLogging' => true,
            'schemaCachingDuration' => 84600
        ),
        'log' => array(
            'routes' => array(
                 array(
                     'class'=>'CFileLogRoute',
                     //'levels'=>'error, debug',
                     'filter'=>'CLogFilter',
                 ),
            )
        )
     )
);
?>

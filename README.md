x2crm
=====

X2CRM for CS5331

Installation
------------

After cloning, for a vanilla install you need to:

* Create folder `x2engine/assets`
* Create folder `x2engine/protected/runtime`
* Edit `x2engine/protected/config/X2Config.php` for the database settings
* Upload the sqldump from Google Drive
* Execute the following DB Change for Plugin Feature
ALTER TABLE  `x2_profile` ADD  `plugins` TEXT NULL AFTER  `widgetSettings` ;


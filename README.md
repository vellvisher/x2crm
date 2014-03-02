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
* Grant web server write permissions to `x2engine/js/plugin`

Module Installation
-------------------

For the different modules,

* Run modules/chat/data/install.sql
* Run modules/newsletters/data/install.sql
* Run modules/advertise/data/install.sql
* Run modules/docs/data/install_docs_revisions.sql

Chat Module PeerJS Server
-------------------------

Follow the instructions to setup PeerJS [here](https://github.com/peers/peerjs-server) and then run `peerjs --port 9001 --key peerjs`

Development Mode
----------------

DO NOT SET THIS IN PRODUCTION MODE!

Add the following line, to your virtual hosts in Apache:

`SetEnv APPLICATION_ENV development`

If there is a database error, change the database password in
`protected/config/debugConfig.php`.

You should now have better error messages and logging using `Yii::log` saved in
`protected/runtime/application.log`.

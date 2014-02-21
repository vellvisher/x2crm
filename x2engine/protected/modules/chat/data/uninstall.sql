DROP TABLE `chatroom_invite`;
DELETE FROM `x2_modules` WHERE `name`='chat';
DELETE FROM `x2engine`.`x2_auth_item` WHERE `x2_auth_item`.`name` = 'ChatIndex';
DELETE FROM `x2engine`.`x2_auth_item` WHERE `x2_auth_item`.`name` = 'ChatInvite';
DELETE FROM `x2engine`.`x2_auth_item` WHERE `x2_auth_item`.`name` = 'ChatJoin';
DELETE FROM `x2engine`.`x2_auth_item_child` WHERE `x2_auth_item_child`.`parent` = 'AuthenticatedSiteFunctionsTask' AND `x2_auth_item_child`.`child` = 'ChatIndex';
DELETE FROM `x2engine`.`x2_auth_item_child` WHERE `x2_auth_item_child`.`parent` = 'AuthenticatedSiteFunctionsTask' AND `x2_auth_item_child`.`child` = 'ChatInvite';
DELETE FROM `x2engine`.`x2_auth_item_child` WHERE `x2_auth_item_child`.`parent` = 'AuthenticatedSiteFunctionsTask' AND `x2_auth_item_child`.`child` = 'ChatJoin';

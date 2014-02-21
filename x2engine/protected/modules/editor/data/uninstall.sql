-- DROP TABLE `editor_files`;
DELETE FROM `x2_modules` WHERE `name`='editor';
DELETE FROM `x2engine`.`x2_auth_item` WHERE `x2_auth_item`.`name` = 'EditorIndex';
DELETE FROM `x2engine`.`x2_auth_item` WHERE `x2_auth_item`.`name` = 'EditorInvite';
DELETE FROM `x2engine`.`x2_auth_item` WHERE `x2_auth_item`.`name` = 'EditorJoin';
DELETE FROM `x2engine`.`x2_auth_item_child` WHERE `x2_auth_item_child`.`parent` = 'AuthenticatedSiteFunctionsTask' AND `x2_auth_item_child`.`child` = 'EditorIndex';
DELETE FROM `x2engine`.`x2_auth_item_child` WHERE `x2_auth_item_child`.`parent` = 'AuthenticatedSiteFunctionsTask' AND `x2_auth_item_child`.`child` = 'EditorInvite';
DELETE FROM `x2engine`.`x2_auth_item_child` WHERE `x2_auth_item_child`.`parent` = 'AuthenticatedSiteFunctionsTask' AND `x2_auth_item_child`.`child` = 'EditorJoin';

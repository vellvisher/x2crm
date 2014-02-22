DROP TABLE `x2_advertise`;
DELETE FROM `x2_modules` WHERE name='advertise';
DELETE FROM `x2_fields` WHERE modelName='Advertise';
DELETE FROM `x2_events` WHERE `associationType` = "Advertise";
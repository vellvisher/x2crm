DROP TABLE `x2_newsletters`;
DELETE FROM `x2_modules` WHERE name='newsletters';
DELETE FROM `x2_fields` WHERE modelName='Newsletters';
DELETE FROM `x2_events` WHERE `associationType` = "Newsletters";
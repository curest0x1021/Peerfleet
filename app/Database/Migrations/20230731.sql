ALTER TABLE `pf_to_do` CHANGE `client_id` `client_id` INT NULL;
UPDATE `pf_grommets_loadtest` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_grommets_loadtest` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';

UPDATE `pf_grommets_inspection` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_grommets_inspection` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';

UPDATE `pf_misc_loadtest` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_misc_loadtest` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';

UPDATE `pf_misc_inspection` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_misc_inspection` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';

UPDATE `pf_shackles_loadtest` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_shackles_loadtest` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';

UPDATE `pf_shackles_inspection` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_shackles_inspection` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';

UPDATE `pf_lashing_inspection` SET `passed`= 0 WHERE passed IS NULL;
ALTER TABLE `pf_lashing_inspection` CHANGE `passed` `passed` TINYINT(1) NOT NULL DEFAULT '0';


ALTER TABLE `pf_wires_loadtest` ADD `passed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `test_date`;
ALTER TABLE `pf_wires_inspection` ADD `passed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `inspection_date`;
ALTER TABLE `pf_notifications` CHANGE `crane_id` `wire_id` INT NOT NULL;
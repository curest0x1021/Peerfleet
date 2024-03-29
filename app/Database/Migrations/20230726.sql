ALTER TABLE `pf_grommets_loadtest` ADD `initial_test` TINYINT(1) NOT NULL DEFAULT '0' AFTER `grommet_id`;
ALTER TABLE `pf_misc_loadtest` ADD `initial_test` TINYINT(1) NOT NULL DEFAULT '0' AFTER `misc_id`;
ALTER TABLE `pf_shackles_loadtest` ADD `initial_test` TINYINT(1) NOT NULL DEFAULT '0' AFTER `shackle_id`;
ALTER TABLE `pf_lashing` ADD `icc_id` INT NULL AFTER `bl`, ADD `manufacturer_id` INT NULL AFTER `icc_id`;
ALTER TABLE `pf_services` ADD `description` TEXT NULL AFTER `country_id`;
ALTER TABLE `pf_wires_inspection` DROP `next_suggested_inspection`;
ALTER TABLE `pf_wires` ADD `deleted` TINYINT(1) NOT NULL DEFAULT '0' AFTER `wire`;
ALTER TABLE `pf_wires_info` CHANGE `diameter` `diameter` DECIMAL(10,1) NULL, CHANGE `length` `length` DECIMAL(10,1) NULL, CHANGE `swl` `swl` DECIMAL(10,1) NULL;
ALTER TABLE `pf_wires_info` ADD `deleted` TINYINT(1) NOT NULL DEFAULT '0' AFTER `swl`;
ALTER TABLE `pf_wires_history` ADD `is_initial` TINYINT(1) NOT NULL DEFAULT '0' AFTER `replacement`, ADD `deleted` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_initial`;
ALTER TABLE `pf_wires_loadtest` ADD `is_initial` TINYINT(1) NOT NULL DEFAULT '0' AFTER `files`;
ALTER TABLE `pf_to_do` ADD `client_id` INT NOT NULL AFTER `created_at`;
ALTER TABLE `pf_to_do` ADD `priority_id` INT NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `pf_to_do` ADD `deadline` DATE NULL AFTER `start_date`;
CREATE TABLE `pf_grommet_types` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `pf_grommets_main` ADD `type_id` INT NOT NULL AFTER `wl`;

ALTER TABLE `pf_grommets_loadtest` ADD `initial_test` TINYINT(1) NOT NULL DEFAULT '0' AFTER `grommet_id`;
ALTER TABLE `pf_misc_loadtest` ADD `initial_test` TINYINT(1) NOT NULL DEFAULT '0' AFTER `misc_id`;
ALTER TABLE `pf_shackles_loadtest` ADD `initial_test` TINYINT(1) NOT NULL DEFAULT '0' AFTER `shackle_id`;
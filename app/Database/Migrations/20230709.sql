CREATE TABLE `pf_grommets_main` (`id` INT NOT NULL AUTO_INCREMENT , `item_description` VARCHAR(50) NOT NULL , `wll` DOUBLE NOT NULL , `wl` DOUBLE NOT NULL , `dia` INT NOT NULL , `bl` DOUBLE NOT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`item_description`), UNIQUE (`wll`, `wl`)) ENGINE = InnoDB;
CREATE TABLE `pf_grommets` (`id` INT NOT NULL AUTO_INCREMENT , `client_id` INT NOT NULL , `main_id` INT NOT NULL, `internal_id` VARCHAR(20) NOT NULL , `qty` INT NOT NULL , `icc_id` INT NULL , `certificate_number` VARCHAR(100) NOT NULL , `certificate_type_id` INT NULL , `tag_marking` VARCHAR(100) NULL , `manufacturer_id` INT NULL , `supplied_date` DATE NOT NULL , `supplied_place` VARCHAR(100) NULL, `lifts` INT NOT NULL, `date_of_discharged` DATE NULL, `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`client_id`, `internal_id`)) ENGINE = InnoDB;
CREATE TABLE `pf_grommets_loadtest` (`id` INT NOT NULL AUTO_INCREMENT , `grommet_id` INT NOT NULL , `test_date` DATE NULL , `tested_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `pf_grommets_inspection` (`id` INT NOT NULL AUTO_INCREMENT , `grommet_id` INT NOT NULL , `inspection_date` DATE NULL , `inspected_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;



CREATE TABLE `pf_shackles_main` (`id` INT NOT NULL AUTO_INCREMENT , `item_description` VARCHAR(50) NOT NULL , `wll` DOUBLE NOT NULL , `type_id` INT NOT NULL , `bl` DOUBLE NULL , `iw` INT NULL , `pd` INT NULL , `il` INT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`item_description`), UNIQUE(`wll`, `type_id`)) ENGINE = InnoDB;

CREATE TABLE `pf_shackles` (`id` INT NOT NULL AUTO_INCREMENT , `client_id` INT NOT NULL , `main_id` INT NOT NULL, `internal_id` VARCHAR(20) NOT NULL , `qty` INT NOT NULL , `icc_id` INT NULL , `certificate_number` VARCHAR(100) NOT NULL , `certificate_type_id` INT NULL , `tag_marking` VARCHAR(100) NULL , `manufacturer_id` INT NULL , `supplied_date` DATE NOT NULL , `supplied_place` VARCHAR(100) NULL , `lifts` INT NOT NULL, `date_of_discharged` DATE NULL, `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`client_id`, `internal_id`)) ENGINE = InnoDB;

CREATE TABLE `pf_shackles_loadtest` (`id` INT NOT NULL AUTO_INCREMENT , `shackle_id` INT NOT NULL , `test_date` DATE NULL , `tested_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `pf_shackles_inspection` (`id` INT NOT NULL AUTO_INCREMENT , `shackle_id` INT NOT NULL , `inspection_date` DATE NULL , `inspected_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;



CREATE TABLE `pf_misc_main` (`id` INT NOT NULL AUTO_INCREMENT , `item_description` VARCHAR(50) NOT NULL , `wll` DOUBLE NOT NULL , `wl` DOUBLE NOT NULL , `type_id` INT NOT NULL , `bl` DOUBLE NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`item_description`), UNIQUE(`wll`, `wl`, `type_id`)) ENGINE = InnoDB;

CREATE TABLE `pf_misc` (`id` INT NOT NULL AUTO_INCREMENT , `client_id` INT NOT NULL , `main_id` INT NOT NULL, `internal_id` VARCHAR(20) NOT NULL , `qty` INT NOT NULL , `icc_id` INT NULL , `certificate_number` VARCHAR(100) NOT NULL , `certificate_type_id` INT NULL , `tag_marking` VARCHAR(100) NULL , `manufacturer_id` INT NULL , `supplied_date` DATE NOT NULL , `supplied_place` VARCHAR(100) NULL, `lifts` INT NOT NULL, `date_of_discharged` DATE NULL, `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`client_id`, `internal_id`)) ENGINE = InnoDB;

CREATE TABLE `pf_misc_loadtest` (`id` INT NOT NULL AUTO_INCREMENT , `misc_id` INT NOT NULL , `test_date` DATE NULL , `tested_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `pf_misc_inspection` (`id` INT NOT NULL AUTO_INCREMENT , `misc_id` INT NOT NULL , `inspection_date` DATE NULL , `inspected_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;




CREATE TABLE `pf_lashing` (`id` INT NOT NULL AUTO_INCREMENT, `client_id` INT NOT NULL, `no` INT NOT NULL , `category_id` INT NOT NULL , `name` VARCHAR(50) NOT NULL , `description` VARCHAR(250) NULL , `qty` INT NOT NULL , `length` INT NULL , `width` INT NULL , `height` INT NULL , `msl` INT NULL , `bl` INT NULL , `supplied_date` DATE NULL , `supplied_place` VARCHAR(50) NULL , `property` ENUM('SAL','Ship') NOT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `pf_lashing_inspection` (`id` INT NOT NULL AUTO_INCREMENT , `lashing_id` INT NOT NULL , `inspection_date` DATE NULL , `inspected_by` VARCHAR(100) NULL , `location` VARCHAR(250) NULL , `passed` TINYINT(1) NULL DEFAULT '0' , `remarks` TEXT NULL , `files` TEXT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;


RENAME TABLE `pf_warehouse_spare` TO `peerfleet`.`pf_warehouse_spares`;

CREATE TABLE `pf_warehouse_chemicals` (`id` INT NOT NULL AUTO_INCREMENT , `warehouse_id` INT NOT NULL , `chemical_id` INT NOT NULL , `quantity` INT NOT NULL , `min_stocks` INT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `pf_warehouse_oils` (`id` INT NOT NULL AUTO_INCREMENT , `warehouse_id` INT NOT NULL , `oil_id` INT NOT NULL , `quantity` INT NOT NULL , `min_stocks` INT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `pf_warehouse_paints` (`id` INT NOT NULL AUTO_INCREMENT , `warehouse_id` INT NOT NULL , `paint_id` INT NOT NULL , `quantity` INT NOT NULL , `min_stocks` INT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `pf_notifications` CHANGE `warehouse_spare_id` `warehouse_item_id` INT NOT NULL;
ALTER TABLE `pf_notifications` ADD `warehouse_tab` VARCHAR(20) NOT NULL AFTER `warehouse_item_id`;
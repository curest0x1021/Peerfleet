ALTER TABLE `pf_tasks` ADD `maker` VARCHAR(30) NULL AFTER `risk_assessment`;


CREATE TABLE `pf_services` (`id` INT NOT NULL AUTO_INCREMENT , `company` VARCHAR(100) NOT NULL , `serviced_ports` VARCHAR(50) NOT NULL , `service_type` VARCHAR(100) NOT NULL , `phone` VARCHAR(15) NOT NULL , `fax` VARCHAR(15) NOT NULL , `email` VARCHAR(100) NOT NULL , `website` VARCHAR(250) NOT NULL , `address` VARCHAR(255) NOT NULL , `city` VARCHAR(255) NOT NULL , `po_box` VARCHAR(255) NOT NULL , `country_id` VARCHAR(50) NOT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`company`, `serviced_ports`)) ENGINE = InnoDB;

CREATE TABLE `pf_service_contacts` (`id` INT NOT NULL AUTO_INCREMENT , `service_id` INT NOT NULL , `first_name` VARCHAR(50) NOT NULL , `last_name` VARCHAR(50) NOT NULL , `job_title` VARCHAR(50) NOT NULL , `email` VARCHAR(100) NOT NULL , `phone` VARCHAR(15) NOT NULL , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

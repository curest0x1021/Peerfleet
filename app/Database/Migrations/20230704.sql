ALTER TABLE `pf_cranes` CHANGE `rope` `wire` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
RENAME TABLE `peerfleet`.`pf_cranes` TO `peerfleet`.`pf_wires`;

ALTER TABLE `pf_cranes_history` CHANGE `rope_id` `wire_id` INT NOT NULL;
RENAME TABLE `peerfleet`.`pf_cranes_history` TO `peerfleet`.`pf_wires_history`;

ALTER TABLE `pf_cranes_info` CHANGE `rope_id` `wire_id` INT NOT NULL;
RENAME TABLE `peerfleet`.`pf_cranes_info` TO `peerfleet`.`pf_wires_info`;

ALTER TABLE `pf_cranes_loadtest` CHANGE `rope_id` `wire_id` INT NOT NULL;
RENAME TABLE `peerfleet`.`pf_cranes_loadtest` TO `peerfleet`.`pf_wires_loadtest`;

ALTER TABLE `pf_cranes_wire_inspection` CHANGE `rope_id` `wire_id` INT NOT NULL;
RENAME TABLE `peerfleet`.`pf_cranes_wire_inspection` TO `peerfleet`.`pf_wires_inspection`;

RENAME TABLE `peerfleet`.`pf_critical_spare_parts` TO `peerfleet`.`pf_spare_parts`;


ALTER TABLE `pf_spare_parts` ADD `is_critical` TINYINT(1) NOT NULL DEFAULT '0' AFTER `hs_code`;

ALTER TABLE `pf_to_do` ADD `sort` INT NOT NULL DEFAULT '0' AFTER `start_date`;
ALTER TABLE `pf_checklist_items` ADD `todo_id` INT NOT NULL DEFAULT '0' AFTER `task_id`;

CREATE TABLE `pf_to_do_status` (`id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(50) NOT NULL , `key_name` VARCHAR(50) NOT NULL , `color` VARCHAR(7) NOT NULL , `sort` INT NOT NULL , `hide_from_kanban` TINYINT(1) NOT NULL DEFAULT '0' , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `pf_to_do_status`(`title`, `key_name`, `color`, `sort`) VALUES
('To Do', 'to_do', '#F9A52D', 0),
('Done', 'done', '#00B393', 1);
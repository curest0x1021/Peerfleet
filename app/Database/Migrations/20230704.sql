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
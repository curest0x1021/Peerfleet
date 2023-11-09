ALTER TABLE `pf_units` CHANGE `code` `code` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;

TRUNCATE TABLE `pf_spare_parts`;
ALTER TABLE `pf_spare_parts` CHANGE `unit_code` `unit_id` INT NOT NULL;
ALTER TABLE `pf_spare_parts` CHANGE `part_description` `part_description` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;

TRUNCATE TABLE `pf_chemicals`;
ALTER TABLE `pf_chemicals` CHANGE `unit_code` `unit_id` INT NOT NULL;
ALTER TABLE `pf_chemicals` CHANGE `part_description` `part_description` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;

TRUNCATE TABLE `pf_oils`;
ALTER TABLE `pf_oils` CHANGE `unit_code` `unit_id` INT NOT NULL;
ALTER TABLE `pf_oils` CHANGE `part_description` `part_description` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;

TRUNCATE TABLE `pf_paints`;
ALTER TABLE `pf_paints` CHANGE `unit_code` `unit_id` INT NOT NULL;
ALTER TABLE `pf_paints` CHANGE `part_description` `part_description` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;

TRUNCATE TABLE `pf_warehouse_chemicals`;
TRUNCATE TABLE `pf_warehouse_oils`;
TRUNCATE TABLE `pf_warehouse_paints`;
TRUNCATE TABLE `pf_warehouse_spares`;
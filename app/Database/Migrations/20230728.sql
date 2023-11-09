ALTER TABLE `pf_services` CHANGE `phone` `phone` VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `fax` `fax` VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `website` `website` VARCHAR(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `address` `address` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `city` `city` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `po_box` `po_box` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;


ALTER TABLE `pf_spare_parts` CHANGE `manufacturer_id` `manufacturer_id` VARCHAR(100) NOT NULL, CHANGE `applicable_equip_id` `applicable_equip_id` VARCHAR(100) NULL, CHANGE `ship_equip_id` `ship_equip_id` VARCHAR(100) NULL, CHANGE `part_description` `part_description` VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `part_number` `part_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `article_number` `article_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `drawing_number` `drawing_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `hs_code` `hs_code` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;
ALTER TABLE `pf_chemicals` CHANGE `manufacturer_id` `manufacturer_id` VARCHAR(100) NOT NULL, CHANGE `part_number` `part_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `article_number` `article_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `hs_code` `hs_code` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;
ALTER TABLE `pf_oils` CHANGE `manufacturer_id` `manufacturer_id` VARCHAR(100) NOT NULL, CHANGE `part_number` `part_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `article_number` `article_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `hs_code` `hs_code` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;
ALTER TABLE `pf_paints` CHANGE `manufacturer_id` `manufacturer_id` VARCHAR(100) NOT NULL, CHANGE `part_number` `part_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `article_number` `article_number` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL, CHANGE `hs_code` `hs_code` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NULL;

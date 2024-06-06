CREATE TABLE IF NOT EXISTS `#__informations` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`state` TINYINT(1)  NULL  DEFAULT 1,
`ordering` INT(11)  NULL  DEFAULT 0,
`checked_out` INT(11)  UNSIGNED,
`checked_out_time` DATETIME NULL  DEFAULT NULL ,
`created_by` INT(11)  NULL  DEFAULT 0,
`modified_by` INT(11)  NULL  DEFAULT 0,
`slogan` VARCHAR(255)  NULL  DEFAULT "",
`address_1` VARCHAR(255)  NULL  DEFAULT "",
`address_2` VARCHAR(255)  NULL  DEFAULT "",
`hotline` VARCHAR(255)  NULL  DEFAULT "",
`telephone` VARCHAR(255)  NULL  DEFAULT "",
`logo` TEXT NULL ,
`email_ktx` VARCHAR(255)  NULL  DEFAULT "",
`website` VARCHAR(255)  NULL  DEFAULT "",
`facebook` VARCHAR(255)  NULL  DEFAULT "",
`zalo` VARCHAR(255)  NULL  DEFAULT "",
`twitter` VARCHAR(255)  NULL  DEFAULT "",
`instagram` VARCHAR(255)  NULL  DEFAULT "",
`students` INT(11)  NULL  DEFAULT 0,
`scholarship` INT(11)  NULL  DEFAULT 0,
`rooms` INT(11)  NULL  DEFAULT 0,
`tour_video` TEXT NULL ,
PRIMARY KEY (`id`)
,KEY `idx_state` (`state`)
,KEY `idx_checked_out` (`checked_out`)
,KEY `idx_created_by` (`created_by`)
,KEY `idx_modified_by` (`modified_by`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `#__informations_students` ON `#__informations`(`students`);

CREATE INDEX `#__informations_scholarship` ON `#__informations`(`scholarship`);

CREATE INDEX `#__informations_rooms` ON `#__informations`(`rooms`);


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `content_history_options`)
SELECT * FROM ( SELECT 'Chi tiết','com_informations.detail','{"special":{"dbtable":"#__informations","key":"id","type":"DetailTable","prefix":"Joomla\\\\Component\\\\Informations\\\\Administrator\\\\Table\\\\"}}', CASE 
                                    WHEN 'rules' is null THEN ''
                                    ELSE ''
                                    END as rules, CASE 
                                    WHEN 'field_mappings' is null THEN ''
                                    ELSE ''
                                    END as field_mappings, '{"formFile":"administrator\/components\/com_informations\/forms\/detail.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"tour_video"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_informations.detail')
) LIMIT 1;

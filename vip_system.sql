CREATE TABLE `sb_vip_system` (
	`code` VARCHAR(10) NOT NULL DEFAULT '' COLLATE 'utf8mb3_general_ci',
	`steamid` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`expire` TIMESTAMP NULL DEFAULT NULL,
	`admin_group` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`used` TINYINT(4) NULL DEFAULT '0',
	`name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`viptest_used` TINYINT(4) NULL DEFAULT '0',
	PRIMARY KEY (`code`) USING BTREE,
	UNIQUE INDEX `code` (`code`, `steamid`) USING BTREE
)
COLLATE='utf8mb3_general_ci'
ENGINE=InnoDB
;

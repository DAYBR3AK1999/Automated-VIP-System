USE `sourcebans`;

-- Drop old tables if needed
DROP TABLE IF EXISTS `sb_vip_system`;
DROP TABLE IF EXISTS `sb_vip_groups`;
DROP TABLE IF EXISTS `users`;

-- -----------------------------------
-- Create VIP system table
-- -----------------------------------
CREATE TABLE `sb_vip_system` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `steamid` VARCHAR(30) DEFAULT NULL,
  `expire` DATETIME DEFAULT NULL,
  `vip_group` VARCHAR(64) DEFAULT NULL,
  `used` TINYINT(1) DEFAULT 0,
  `name` VARCHAR(255) DEFAULT NULL,
  `viptest_used` TINYINT(1) NOT NULL DEFAULT 0,
  `added_by` VARCHAR(255) NOT NULL DEFAULT 'Console',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample VIP entries
INSERT INTO `sb_vip_system` (`code`, `steamid`, `expire`, `vip_group`, `used`, `name`, `viptest_used`, `added_by`) VALUES
  ('9khm5ss6p2', 'STEAM_0:1:666665172', NULL, NULL, 0, 'Mathieu2', 1, 'DAYBR3AK1999'),
  ('4k2mCcHLxe', 'STEAM_0:0:52902429', '2023-11-22 13:51:23', NULL, 1, 'DAYBR3AK1999', 1, 'Console'),
  ('pouugkw07b', 'STEAM_0:0:529024299999', NULL, NULL, 0, 'Mathieu', 1, 'Thieu'),
  ('3hg7h7m62g', 'STEAM_0:0:5290242999', '2023-12-07 17:23:00', 'vip', 1, 'Mathieu3', 1, 'Thieu');

-- -----------------------------------
-- Create users table (owner/admin)
-- -----------------------------------
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert demo users with password: 123456
INSERT INTO `users` (`username`, `password`, `role`) VALUES
  ('owner', '$2y$10$DJlEHvIvv1ILIi9OYi.D1.BUvXvWYN06IW/iURAfuBx/pfs0Hsjrm', 'owner'),
  ('admin', '$2y$10$DJlEHvIvv1ILIi9OYi.D1.BUvXvWYN06IW/iURAfuBx/pfs0Hsjrm', 'admin');

-- -----------------------------------
-- Create VIP groups table
-- -----------------------------------
CREATE TABLE `sb_vip_groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vip_group` VARCHAR(64) NOT NULL,
  `info` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`vip_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional VIP groups (no features)
INSERT INTO `sb_vip_groups` (`vip_group`, `info`) VALUES
  ('vip', 'Base VIP access'),
  ('vip_gold', 'Gold VIP (donator)');

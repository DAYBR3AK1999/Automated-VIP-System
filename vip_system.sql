-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           10.6.4-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de la base pour sourcebans
CREATE DATABASE IF NOT EXISTS `sourcebans` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `sourcebans`;

-- Listage de la structure de la table sourcebans. sb_vip_system
CREATE TABLE IF NOT EXISTS `sb_vip_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT '',
  `steamid` varchar(30) DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  `admin_group` varchar(30) DEFAULT NULL,
  `used` tinyint(4) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `viptest_used` tinyint(4) NOT NULL DEFAULT 1,
  `added_by` varchar(255) NOT NULL DEFAULT 'Console',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_unique` (`code`),
  UNIQUE KEY `code` (`code`,`steamid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sourcebans.sb_vip_system : ~2 rows (environ)
DELETE FROM `sb_vip_system`;
/*!40000 ALTER TABLE `sb_vip_system` DISABLE KEYS */;
INSERT INTO `sb_vip_system` (`id`, `code`, `steamid`, `expire`, `admin_group`, `used`, `name`, `viptest_used`, `added_by`) VALUES
	(43, '9khm5ss6p2', 'STEAM_0:1:666665172', NULL, NULL, 0, 'Mathieu2', 1, 'DAYBR3AK1999'),
	(44, '4k2mCcHLxe', 'STEAM_0:0:52902429', '2023-11-22 13:51:23', NULL, 1, 'DAYBR3AK1999', 1, 'Console'),
	(45, 'pouugkw07b', 'STEAM_0:0:529024299999', NULL, NULL, 0, 'Mathieu', 1, 'Thieu'),
	(46, '3hg7h7m62g', 'STEAM_0:0:5290242999', '2023-12-07 17:23:00', 'vip', 1, 'Mathieu3', 1, 'Thieu');
/*!40000 ALTER TABLE `sb_vip_system` ENABLE KEYS */;

-- Listage de la structure de la table sourcebans. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sourcebans.users : ~2 rows (environ)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
	(1, 'DAYBR3AK1999', '$2y$10$uMyJ3ngc0CRif96SgtdLzelnGcutAfj/jxS8WRqslmgjwUXn7kQ76', 'owner'),
	(8, 'Thieu', '$2y$10$7PZiDXDjr8vO7mCMFX6iWOPPZHNN4f93.1.i6Wb2niAxsNK29zeDi', 'admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

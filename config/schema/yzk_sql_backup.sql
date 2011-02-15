# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.0.67-community-nt
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-02-15 21:27:43
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for yzk
DROP DATABASE IF EXISTS `yzk`;
CREATE DATABASE IF NOT EXISTS `yzk` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yzk`;


# Dumping structure for table yzk.campaigns
DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(10) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table yzk.campaigns: ~0 rows (approximately)
DELETE FROM `campaigns`;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;


# Dumping structure for table yzk.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) NOT NULL,
  `group_id` varchar(36) NOT NULL default '0',
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `key` varchar(32) default NULL,
  `type` varchar(50) default 'guest',
  `email` varchar(100) default NULL,
  `active` tinyint(1) NOT NULL default '0',
  `item_count` int(11) NOT NULL default '0',
  `project_count` int(11) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `key` (`key`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `username`, `password`, `key`, `type`, `email`, `active`, `item_count`, `project_count`, `created`, `modified`) VALUES
	('4d187c63-9ef0-4601-8dc3-04349be3e0a3', '4cdbf51d-a8a8-4f5f-88c9-05cc9be3e0a3', 'work1', 'c129b324aee662b04eccf68babba85851346dff9', NULL, 'guest', 'work1@mm.ru', 1, 19, 4, '2010-12-27 14:45:39', '2011-02-11 20:05:09'),
	('4d5022a2-fdc0-4403-bafc-05c09be3e0a3', '4cdbf51d-a8a8-4f5f-88c9-05cc9be3e0a3', 'work2', 'c129b324aee662b04eccf68babba85851346dff9', NULL, 'guest', 'work2@mk.ru', 1, 3, 1, '2011-02-07 19:49:38', '2011-02-07 19:49:38'),
	('4d542145-8458-472a-b7ae-05989be3e0a3', '4cdbf51d-a8a8-4f5f-88c9-05cc9be3e0a3', 'work4', 'c129b324aee662b04eccf68babba85851346dff9', NULL, 'guest', 'work4@mm.ru', 1, 3, 1, '2011-02-10 20:32:53', '2011-02-10 20:32:53');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

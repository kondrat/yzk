# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.9
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-03-16 23:05:14
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for yzk
DROP DATABASE IF EXISTS `yzk`;
CREATE DATABASE IF NOT EXISTS `yzk` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yzk`;


# Dumping structure for table yzk.acos
DROP TABLE IF EXISTS `acos`;
CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.acos: ~0 rows (approximately)
DELETE FROM `acos`;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;


# Dumping structure for table yzk.aros
DROP TABLE IF EXISTS `aros`;
CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.aros: ~0 rows (approximately)
DELETE FROM `aros`;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;


# Dumping structure for table yzk.aros_acos
DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` varchar(36) NOT NULL,
  `aco_id` varchar(36) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.aros_acos: ~0 rows (approximately)
DELETE FROM `aros_acos`;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;


# Dumping structure for table yzk.campaigns
DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table yzk.campaigns: ~0 rows (approximately)
DELETE FROM `campaigns`;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;


# Dumping structure for table yzk.clients
DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `user_id` varchar(50) DEFAULT NULL,
  `agent_id` varchar(50) DEFAULT NULL,
  `ynname` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.clients: ~18 rows (approximately)
DELETE FROM `clients`;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`, `user_id`, `agent_id`, `ynname`, `pass`, `created`, `modified`) VALUES
	('4d78fa41-3c1c-43ad-868a-05d49be3e0a3', '4d78fa41-2a50-4609-b04c-05d49be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'pktelectro', NULL, '2011-03-10 16:20:17', '2011-03-10 16:20:17'),
	('4d78faa5-5c9c-4032-83e9-05d49be3e0a3', '4d78faa5-7b40-40e7-8453-05d49be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'ritmed2009', NULL, '2011-03-10 16:21:57', '2011-03-10 16:21:57'),
	('4d790b45-a67c-40a9-82e0-07d89be3e0a3', '4d790b45-b414-4e72-99fc-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'pjpmj', NULL, '2011-03-10 17:32:53', '2011-03-10 17:32:53'),
	('4d790bf4-db44-4358-a875-07d89be3e0a3', '4d790bf4-2288-4462-be70-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'limo-c', NULL, '2011-03-10 17:35:48', '2011-03-10 17:35:48'),
	('4d790e74-5594-4748-ab99-07d89be3e0a3', '4d790e74-587c-43cb-ac12-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'gagarinstudio2010', NULL, '2011-03-10 17:46:28', '2011-03-10 17:46:28'),
	('4d790f31-e19c-4b34-9b68-07d89be3e0a3', '4d790f31-f95c-468e-804d-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'mebelin2010', NULL, '2011-03-10 17:49:37', '2011-03-10 17:49:37'),
	('4d790f7a-91a4-435a-92df-07d89be3e0a3', '4d790f7a-aa08-42e0-8be0-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'anisolt', NULL, '2011-03-10 17:50:50', '2011-03-10 17:50:50'),
	('4d791332-4264-4e93-ac58-07d89be3e0a3', '4d791332-49fc-46ab-93e2-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'laccent2010', NULL, '2011-03-10 18:06:42', '2011-03-10 18:06:42'),
	('4d7913dd-3fb4-40fc-80f8-07d89be3e0a3', '4d7913dd-5564-4286-a0e7-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'vptd2010', NULL, '2011-03-10 18:09:33', '2011-03-10 18:09:33'),
	('4d79143d-57d8-455b-911e-07d89be3e0a3', '4d79143d-5f0c-4b4d-9e93-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'intersouz2010', NULL, '2011-03-10 18:11:09', '2011-03-10 18:11:09'),
	('4d7916f1-c93c-43cd-8160-07d89be3e0a3', '4d7916f1-a834-462a-9541-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'diadel2010', NULL, '2011-03-10 18:22:41', '2011-03-10 18:22:41'),
	('4d7917de-d340-4844-b4e7-07d89be3e0a3', '4d7917de-dccc-48a4-8546-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'horpol', NULL, '2011-03-10 18:26:38', '2011-03-10 18:26:38'),
	('4d79183d-fa94-4dd7-b3a8-07d89be3e0a3', '4d79183d-310c-4a4f-8d40-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'wellacity', NULL, '2011-03-10 18:28:13', '2011-03-10 18:28:13'),
	('4d7918fe-2c20-4b1d-b529-07d89be3e0a3', '4d7918fe-fa4c-4a05-88d0-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'kran-direct', NULL, '2011-03-10 18:31:26', '2011-03-10 18:31:26'),
	('4d79197c-d9b4-4f55-a2df-07d89be3e0a3', '4d79197c-3da0-4760-b9e2-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'yahta2011', NULL, '2011-03-10 18:33:32', '2011-03-10 18:33:32'),
	('4d7936bc-ccfc-401d-bfc9-07d89be3e0a3', '4d7936bc-26e4-4de3-a925-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'promkomplekt-dir', NULL, '2011-03-10 20:38:20', '2011-03-10 20:38:20'),
	('4d79375b-4d74-4979-a94f-07d89be3e0a3', '4d79375b-28cc-4634-b3b0-07d89be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'bagira-massage', NULL, '2011-03-10 20:40:59', '2011-03-10 20:40:59'),
	('4d79c48e-1d80-4f9f-a519-05449be3e0a3', '4d79c48e-bc68-41fe-ba1b-05449be3e0a3', '4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 'allmetc', 'jatruspako', '2011-03-11 06:43:26', '2011-03-11 06:43:26');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;


# Dumping structure for table yzk.details
DROP TABLE IF EXISTS `details`;
CREATE TABLE IF NOT EXISTS `details` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `position` float NOT NULL DEFAULT '1',
  `field` varchar(255) NOT NULL,
  `value` text,
  `input` varchar(16) NOT NULL,
  `data_type` varchar(16) NOT NULL,
  `label` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PROFILE_PROPERTY` (`field`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.details: ~0 rows (approximately)
DELETE FROM `details`;
/*!40000 ALTER TABLE `details` DISABLE KEYS */;
/*!40000 ALTER TABLE `details` ENABLE KEYS */;


# Dumping structure for table yzk.groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.groups: ~4 rows (approximately)
DELETE FROM `groups`;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`) VALUES
	(1, 'root'),
	(2, 'admin'),
	(3, 'agent'),
	(4, 'client');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


# Dumping structure for table yzk.modes
DROP TABLE IF EXISTS `modes`;
CREATE TABLE IF NOT EXISTS `modes` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `body` varchar(256) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table yzk.modes: ~0 rows (approximately)
DELETE FROM `modes`;
/*!40000 ALTER TABLE `modes` DISABLE KEYS */;
/*!40000 ALTER TABLE `modes` ENABLE KEYS */;


# Dumping structure for table yzk.phrases
DROP TABLE IF EXISTS `phrases`;
CREATE TABLE IF NOT EXISTS `phrases` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `agent_id` varchar(36) NOT NULL DEFAULT '',
  `banner_yn_id` varchar(36) DEFAULT NULL,
  `campaing_yn_id` varchar(36) DEFAULT NULL,
  `phrase_yn_id` varchar(36) DEFAULT NULL,
  `text` text,
  `price` double DEFAULT NULL,
  `mode` text,
  `mode_x` double DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table yzk.phrases: ~0 rows (approximately)
DELETE FROM `phrases`;
/*!40000 ALTER TABLE `phrases` DISABLE KEYS */;
INSERT INTO `phrases` (`id`, `agent_id`, `banner_yn_id`, `campaing_yn_id`, `phrase_yn_id`, `text`, `price`, `mode`, `mode_x`, `modified`, `created`) VALUES
	('4d8103b7-1090-4cbb-a074-01a89be3e0a3', '', '4335329', '1643555', '211658226', NULL, NULL, 'maxP', 23, '2011-03-16 18:39:06', '2011-03-16 18:38:47'),
	('4d8103d7-f320-40c2-880e-01a89be3e0a3', '', '4335329', '1643555', '211658230', NULL, NULL, 'maxP', 91, '2011-03-16 18:39:35', '2011-03-16 18:39:19');
/*!40000 ALTER TABLE `phrases` ENABLE KEYS */;


# Dumping structure for table yzk.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) NOT NULL DEFAULT '',
  `group_id` int(11) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `key` varchar(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

# Dumping data for table yzk.users: ~21 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `password`, `key`, `email`, `last_login`, `created`, `modified`) VALUES
	('4d5efa17-34e8-4274-995b-04619be3e0a3', 3, 'c129b324aee662b04eccf68babba85851346dff9', NULL, 'admin@mm.ru', NULL, '2011-02-19 02:00:39', '2011-02-19 02:18:04'),
	('4d5f015f-86b0-4b91-b79a-045b9be3e0a3', 3, 'c129b324aee662b04eccf68babba85851346dff9', NULL, 'test1@mm.ru', '2011-03-16 15:32:12', '2011-02-19 02:31:43', '2011-03-16 15:32:12'),
	('4d78f970-384c-48c6-8fd8-05d49be3e0a3', 4, 'ff918f543d523cc7dedac8a28e79a3a409d57f9e', NULL, 'more@more.mon', NULL, '2011-03-10 16:16:48', '2011-03-10 16:16:48'),
	('4d78fa41-2a50-4609-b04c-05d49be3e0a3', 4, '31310c37e152884444f8a5739bbebcfed5569bde', NULL, 'more2@more.mon', NULL, '2011-03-10 16:20:17', '2011-03-10 16:20:17'),
	('4d78faa5-7b40-40e7-8453-05d49be3e0a3', 4, 'aac3665877247873bb07a3f039e638bc9d19c5b0', NULL, 'tml@mm.ru', NULL, '2011-03-10 16:21:57', '2011-03-10 16:21:57'),
	('4d790b45-b414-4e72-99fc-07d89be3e0a3', 4, '66dfc853703f47c27b2dace60ab41a0b267c1fc0', NULL, 'sdf@mm.lo', NULL, '2011-03-10 17:32:53', '2011-03-10 17:32:53'),
	('4d790bf4-2288-4462-be70-07d89be3e0a3', 4, 'bec3e835ffd9d8beb3cb9aa89a54a140a69c1ba3', NULL, 'herro@mm.ru', NULL, '2011-03-10 17:35:48', '2011-03-10 17:35:48'),
	('4d790e74-587c-43cb-ac12-07d89be3e0a3', 4, '506a4f71c5cb8713f22edaccda0ea2339c57cb73', NULL, 'mm@p1.ru', NULL, '2011-03-10 17:46:28', '2011-03-10 17:46:28'),
	('4d790f31-f95c-468e-804d-07d89be3e0a3', 4, 'd84953c7d45629d4dcf4491c12129cbae7f485a0', NULL, 'hh@vvv.ru', NULL, '2011-03-10 17:49:37', '2011-03-10 17:49:37'),
	('4d790f7a-aa08-42e0-8be0-07d89be3e0a3', 4, '1e63f9483078b78eb0f86c7e36ff0e965d2141e7', NULL, 'w2w@mm.ru', NULL, '2011-03-10 17:50:50', '2011-03-10 17:50:50'),
	('4d791332-49fc-46ab-93e2-07d89be3e0a3', 4, 'c15ebe7b5cd7e1978042e8111cbd1f610f3383a5', NULL, 'get@and.com', NULL, '2011-03-10 18:06:42', '2011-03-10 18:06:42'),
	('4d7913dd-5564-4286-a0e7-07d89be3e0a3', 4, '5979117337d42d00065d73bf1dc95c541d51b959', NULL, 'sup@mpu.ko', NULL, '2011-03-10 18:09:33', '2011-03-10 18:09:33'),
	('4d79143d-5f0c-4b4d-9e93-07d89be3e0a3', 4, '46473f0dcb8ea420037a620362759ae297907316', NULL, 'mm@bag.ol', NULL, '2011-03-10 18:11:09', '2011-03-10 18:11:09'),
	('4d7916f1-a834-462a-9541-07d89be3e0a3', 4, '47afe01244909d95ef001690ab08636a3f89f156', NULL, 'last@one.ru', NULL, '2011-03-10 18:22:41', '2011-03-10 18:22:41'),
	('4d7917de-dccc-48a4-8546-07d89be3e0a3', 4, '2483badd57045fc558ceb49a525a3d73e43e52d6', NULL, 'got@it.ti', NULL, '2011-03-10 18:26:38', '2011-03-10 18:26:38'),
	('4d79183d-310c-4a4f-8d40-07d89be3e0a3', 4, 'aac694a24fb5c74e7b94019669f88fc7d754d7e9', NULL, 'super@lat.lo', NULL, '2011-03-10 18:28:13', '2011-03-10 18:28:13'),
	('4d7918fe-fa4c-4a05-88d0-07d89be3e0a3', 4, '39dd3918905d6b4494cb6a995cf3b88c60cb13ad', NULL, 'prob@colb.ru', NULL, '2011-03-10 18:31:26', '2011-03-10 18:31:26'),
	('4d79197c-3da0-4760-b9e2-07d89be3e0a3', 4, '4bebbda63df5690c15e78ea206e073719361b1f6', NULL, 'gus@mm.ru', NULL, '2011-03-10 18:33:32', '2011-03-10 18:33:32'),
	('4d7936bc-26e4-4de3-a925-07d89be3e0a3', 4, '566add30d21dc387d9023a994824f9b6983c5672', NULL, 'goo@mm.na', NULL, '2011-03-10 20:38:20', '2011-03-10 20:38:20'),
	('4d79375b-28cc-4634-b3b0-07d89be3e0a3', 4, 'f67e547907e65d61858c8aa318135ae512afaffd', NULL, 'to@create.mo', NULL, '2011-03-10 20:40:59', '2011-03-10 20:40:59'),
	('4d79c48e-bc68-41fe-ba1b-05449be3e0a3', 4, '8d1aca000f670270350ee14501ce4ac58b3f5913', NULL, 'almet@gem.ru', '2011-03-11 07:12:06', '2011-03-11 06:43:26', '2011-03-11 07:12:06');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

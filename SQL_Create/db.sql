-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.3.15-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for data
CREATE DATABASE IF NOT EXISTS `data` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `data`;

-- Dumping structure for table data.account_information
CREATE TABLE IF NOT EXISTS `account_information` (
  `id` int(11) NOT NULL,
  `device_id` varchar(36) NOT NULL,
  `lock_flag` bit(1) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` char(60) NOT NULL,
  `fname` varchar(32) DEFAULT NULL,
  `lname` varchar(32) DEFAULT NULL,
  `address` varchar(32) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  `gender` varchar(32) DEFAULT NULL,
  `picture` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table data.account_information: ~1 rows (approximately)
/*!40000 ALTER TABLE `account_information` DISABLE KEYS */;
INSERT INTO `account_information` (`id`, `device_id`, `lock_flag`, `username`, `password`, `fname`, `lname`, `address`, `email`, `gender`, `picture`) VALUES
	(1, '18140dd5-c785-492c-99a2-7615f98fc90b', b'0', 'testtest', '$2y$10$17fbR8qr78vz9A/AQwNRqerbtseja9gfd8D.MAnC/16/.GVPK.y2i', NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `account_information` ENABLE KEYS */;

-- Dumping structure for table data.uploads
CREATE TABLE IF NOT EXISTS `uploads` (
  `user_id` int(11) NOT NULL,
  `name` char(17) NOT NULL,
  `original_name` varchar(64) NOT NULL,
  `mime_type` varchar(20) NOT NULL,
  KEY `FK_uploads_account_information` (`user_id`),
  CONSTRAINT `FK_uploads_account_information` FOREIGN KEY (`user_id`) REFERENCES `account_information` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table data.uploads: ~0 rows (approximately)
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
INSERT INTO `uploads` (`user_id`, `name`, `original_name`, `mime_type`) VALUES
	(1, '599466845858.png', '', 'image/png'),
	(1, '189942691432.png', '', 'image/png'),
	(1, '932068077825.png', '', 'image/png'),
	(1, '845043891813.png', '', 'image/png'),
	(1, '688177667563.png', '', 'image/png'),
	(1, '526025261985.png', '', 'image/png'),
	(1, '439941140074.png', '', 'image/png'),
	(1, '468438478158.png', '', 'image/png'),
	(1, '659626027252.png', '', 'image/png');
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

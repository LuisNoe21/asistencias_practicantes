-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para attendance
CREATE DATABASE IF NOT EXISTS `attendance` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `attendance`;

-- Volcando estructura para tabla attendance.practicantes
CREATE TABLE IF NOT EXISTS `practicantes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Volcando datos para la tabla attendance.practicantes: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `practicantes` DISABLE KEYS */;
INSERT INTO `practicantes` (`id`, `name`) VALUES
	(1, 'Brayan Rodriguez'),
	(2, 'Luis Medina'),
	(3, 'Juan Valdez'),
	(5, 'Pedro Pablo'),
	(6, 'Pancho'),
	(7, 'Juan'),
	(8, 'Pedro');
/*!40000 ALTER TABLE `practicantes` ENABLE KEYS */;

-- Volcando estructura para tabla attendance.practicante_attendance
CREATE TABLE IF NOT EXISTS `practicante_attendance` (
  `practicante_id` bigint(20) unsigned NOT NULL,
  `date` varchar(10) COLLATE utf8_bin NOT NULL,
  `status` enum('presence','absence') COLLATE utf8_bin DEFAULT NULL,
  `hentrada` time DEFAULT NULL,
  `hsalida` time DEFAULT NULL,
  `permiso` int(1) DEFAULT NULL,
  KEY `practicante_id` (`practicante_id`),
  CONSTRAINT `practicante_attendance_ibfk_1` FOREIGN KEY (`practicante_id`) REFERENCES `practicantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Volcando datos para la tabla attendance.practicante_attendance: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `practicante_attendance` DISABLE KEYS */;
INSERT INTO `practicante_attendance` (`practicante_id`, `date`, `status`, `hentrada`, `hsalida`, `permiso`) VALUES
	(1, '2022-03-16', 'absence', NULL, NULL, 1),
	(2, '2022-03-16', NULL, NULL, NULL, 0),
	(3, '2022-03-16', NULL, NULL, NULL, 0),
	(5, '2022-03-16', NULL, NULL, NULL, 0),
	(6, '2022-03-16', NULL, NULL, NULL, 0),
	(7, '2022-03-16', NULL, NULL, NULL, 0),
	(8, '2022-03-16', NULL, NULL, NULL, 0),
	(1, '2022-03-15', 'presence', '02:35:00', '03:36:00', 0),
	(2, '2022-03-15', 'presence', '02:46:00', '01:50:00', 0),
	(3, '2022-03-15', 'presence', '04:52:00', NULL, 0),
	(5, '2022-03-15', 'absence', NULL, NULL, 1),
	(6, '2022-03-15', NULL, NULL, NULL, 0),
	(7, '2022-03-15', NULL, NULL, NULL, 0),
	(8, '2022-03-15', NULL, NULL, NULL, 0);
/*!40000 ALTER TABLE `practicante_attendance` ENABLE KEYS */;

-- Volcando estructura para tabla attendance.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `contrasenia` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Volcando datos para la tabla attendance.usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`) VALUES
	(1, 'admin', '1234');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

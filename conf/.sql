CREATE TABLE IF NOT EXISTS `databases` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dsn` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `database_name` varchar(255) NOT NULL,
  `dbdriver` varchar(50) DEFAULT 'mysqli',
  `dbprefix` varchar(100) DEFAULT NULL,
  `pconnect` tinyint(1) DEFAULT 0,
  `db_debug` tinyint(1) DEFAULT 0,
  `cache_on` tinyint(1) DEFAULT 0,
  `cachedir` varchar(255) DEFAULT NULL,
  `char_set` varchar(50) DEFAULT 'utf8',
  `dbcollat` varchar(50) DEFAULT 'utf8_general_ci',
  `swap_pre` varchar(100) DEFAULT NULL,
  `encrypt` tinyint(1) DEFAULT 0,
  `compress` tinyint(1) DEFAULT 0,
  `stricton` tinyint(1) DEFAULT 0,
  `save_queries` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `sheets` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sheets`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `array` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` longtext DEFAULT NULL,
  `query` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`query`)),
  `get` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `report` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `template` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `query` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `database_id` bigint(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` longtext DEFAULT NULL,
  `get` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `database_id` (`database_id`),
  CONSTRAINT `database` FOREIGN KEY (`database_id`) REFERENCES `databases` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `itterate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `array_id` bigint(20) DEFAULT NULL,
  `report_id` bigint(20) DEFAULT NULL,
  `direction` int(11) DEFAULT NULL,
  `col` varchar(50) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  `sheet` int(11) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `offset` int(11) DEFAULT NULL,
  `style` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `array_id` (`array_id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `array` FOREIGN KEY (`array_id`) REFERENCES `array` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `report` FOREIGN KEY (`report_id`) REFERENCES `report` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'admin', '$2y$10$whUzJ2erkG2LqmA0QkwIseiZFzeLFRsTDpo.D9W.tsEx69maOmXLy');

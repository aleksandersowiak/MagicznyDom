-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               5.5.21-log - MySQL Community Server (GPL)
-- Serwer OS:                    Win32
-- HeidiSQL Wersja:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Zrzut struktury tabela magicznydom.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_recipe` bigint(11) DEFAULT NULL,
  `user_id` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `userName` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8_polish_ci,
  `created` timestamp NULL DEFAULT NULL,
  `ips` longtext COLLATE utf8_polish_ci,
  `plus` bigint(50) NOT NULL,
  `minus` bigint(50) NOT NULL,
  `moderate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_recipe` (`id_recipe`),
  KEY `comments_ibfk_2` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usermagicznydommagicznydommagicznydommagicznydom` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.comments: ~0 rows (około)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.privileges
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.privileges: ~0 rows (około)
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.recipe
CREATE TABLE IF NOT EXISTS `recipe` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `autor_id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `recipe` longtext COLLATE utf8_polish_ci NOT NULL,
  `plus` bigint(11) NOT NULL,
  `minus` bigint(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `edited` tinyint(1) NOT NULL,
  `hits` bigint(22) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `autor` (`autor`),
  CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `user` (`name`),
  CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.recipe: ~0 rows (około)
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.setings
CREATE TABLE IF NOT EXISTS `setings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `additional_settings` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `data` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `setings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.setings: ~4 rows (około)
/*!40000 ALTER TABLE `setings` DISABLE KEYS */;
INSERT INTO `setings` (`id`, `user_id`, `type`, `additional_settings`, `active`, `data`) VALUES
	(5, '107565152282509124852', 'facebook', '{"fb-box":"0","data-layout":"standard","data-share":"true","data-colorscheme":"light","data-width":"500","data-heigt":"650","data-hide-cover":"false","data-show-facepile":"true","data-show-posts":"false"}', 1, 'http://www.facebook.com/pages/Magiczny-Dom/376351182450245'),
	(6, '107565152282509124852', 'about', '{"title_about":"Strona o mnie!"}', 1, 'Kilka słów o mnie'),
	(7, '107565152282509124852', 'web_title', NULL, 1, 'W Moim Magicznym Domu'),
	(8, '107565152282509124852', 'max_limit', NULL, 1, '5');
/*!40000 ALTER TABLE `setings` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_recipe` bigint(11) NOT NULL,
  `autor_id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `tags` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`,`id_recipe`),
  KEY `id_recipe` (`id_recipe`),
  KEY `autor_id` (`autor_id`),
  CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`),
  CONSTRAINT `tags_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.tags: ~0 rows (około)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `given_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `family_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `picture` text COLLATE utf8_polish_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `locale` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.user: ~1 rows (około)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `given_name`, `family_name`, `link`, `picture`, `gender`, `locale`, `password`, `email`, `created`, `updated`, `active`, `role`) VALUES
	('107096543867743317551', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107096543867743317551', 'https://lh5.googleusercontent.com/-_uB6SXdYeg0/AAAAAAAAAAI/AAAAAAAAF0A/DwZc0pFqloo/photo.jpg', 'male', 'pl', '', '', '2015-06-09 12:33:37', '2015-06-09 12:33:37', 0, 0),
	('107565152282509124852', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107565152282509124852', 'https://lh5.googleusercontent.com/-FkDyEvRXuUE/AAAAAAAAAAI/AAAAAAAAAEE/tGLgiWMndVg/photo.jpg', 'male', 'pl', '', '', '2015-06-09 12:09:36', '2015-06-09 12:09:36', 0, 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

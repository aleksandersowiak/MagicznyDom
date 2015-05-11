-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 11 Maj 2015, 14:30
-- Wersja serwera: 5.5.21-log
-- Wersja PHP: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `magicznydom`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_recipe` bigint(11) DEFAULT NULL,
  `userName` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8_polish_ci,
  `created` timestamp NULL DEFAULT NULL,
  `ips` longtext COLLATE utf8_polish_ci,
  `plus` bigint(50) NOT NULL,
  `minus` bigint(50) NOT NULL,
  `moderate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_recipe` (`id_recipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipe`
--

CREATE TABLE IF NOT EXISTS `recipe` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `autor_id` bigint(11) NOT NULL,
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
  KEY `autor` (`autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `setings`
--

CREATE TABLE IF NOT EXISTS `setings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `additional_settings` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `data` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `setings`
--

INSERT INTO `setings` (`id`, `user_id`, `type`, `additional_settings`, `active`, `data`) VALUES
(5, 2, 'facebook', '{"fb-box":"1","data-layout":"standard","data-share":"true","data-colorscheme":"light","data-width":"500","data-heigt":"650","data-hide-cover":"false","data-show-facepile":"false","data-show-posts":"false"}', 1, 'https://www.facebook.com/pages/Magiczny-Dom/376351182450245'),
(6, 2, 'about', NULL, 1, 'Kilka słów o mnie'),
(7, 2, 'title', NULL, 1, 'W Moim Magicznym Domu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_recipe` bigint(11) NOT NULL,
  `autor_id` bigint(11) NOT NULL,
  `tags` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`,`id_recipe`),
  KEY `id_recipe` (`id_recipe`),
  KEY `autor_id` (`autor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `created`, `updated`, `active`, `name`, `password`, `email`) VALUES
(2, '2015-05-08 13:28:40', '2015-05-08 13:28:41', 1, 'Aleksander Sowiak', '07b4d5416b25a7ac291daacaa18409a4b27f6375', 'aleksander.sowiak@gmail.com');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`);

--
-- Ograniczenia dla tabeli `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `user` (`name`),
  ADD CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `setings`
--
ALTER TABLE `setings`
  ADD CONSTRAINT `setings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `tags_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

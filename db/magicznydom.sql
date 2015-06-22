-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 22 Cze 2015, 18:30
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

DROP TABLE IF EXISTS `comments`;
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
  KEY `comments_ibfk_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=134 ;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `id_recipe`, `user_id`, `userName`, `comment`, `created`, `ips`, `plus`, `minus`, `moderate`) VALUES
(14, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>Bardzo dobre ciasto!</p>', '2015-06-10 02:03:16', '["::1","195.82.172.210","176.107.172.78"]', 1, 2, 1),
(15, 7, '100000000000000000000', 'Kamila Łucyk', '<p>Najlepsze z ostatniego czasu!</p>', '2015-06-10 02:03:51', '["::1"]', 4, 0, 1),
(16, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>Komentarz z telefonu. :)</p>', '2015-06-10 10:42:30', '["195.82.172.210","176.107.172.78"]', 452, 357, 1),
(17, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>Tak to jest jak się, pije...</p><p><br></p>', '2015-06-11 14:31:29', NULL, 0, 0, 1),
(18, 7, '107565152282509124852', 'Aleksander Sowiak', 'Sprawdzanie komentarza&nbsp;', '2015-06-11 15:08:16', NULL, 0, 0, 1),
(19, 7, '107565152282509124852', '', 'Sprawdzanie komentarza&nbsp;', '2015-06-11 15:08:21', NULL, 0, 0, 1),
(20, 7, '107565152282509124852', '', 'Sprawdzanie komentarza&nbsp;', '2015-06-11 15:08:24', NULL, 0, 0, 1),
(21, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>dfsdsdgdsg</p>', '2015-06-11 15:34:45', NULL, 0, 0, 1),
(22, 7, '107565152282509124852', '', '<p>dfsdsdgdsgsdfsdf</p>', '2015-06-11 15:34:47', NULL, 0, 0, 1),
(23, 7, '107565152282509124852', '', '<p>dfsdsdgdsgsdfsdfsdsd</p><p><br></p>', '2015-06-11 15:34:52', NULL, 0, 0, 1),
(24, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>Taki komecik</p>', '2015-06-11 15:36:21', NULL, 0, 0, 1),
(25, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvzvzxvxzcv</p>', '2015-06-11 15:38:11', NULL, 0, 0, 1),
(26, 7, '107565152282509124852', '', '<p>xcvzvzxvxzcvsdfsdfdsfsd</p>', '2015-06-11 15:38:14', NULL, 0, 0, 1),
(27, 7, '107565152282509124852', '', '<p>xcvzvzxvxzcvsdfsdfdsfsddsfdsfsd</p>', '2015-06-11 15:38:20', NULL, 0, 0, 1),
(28, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>gsdgsdgsdfg</p>', '2015-06-11 15:38:54', NULL, 0, 0, 1),
(29, 7, '107565152282509124852', '', '<p>gsdgsdgsdfgzzxvzxvx</p>', '2015-06-11 15:39:04', NULL, 0, 0, 1),
(30, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 15:40:39', NULL, 0, 0, 1),
(31, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 15:40:50', NULL, 0, 0, 1),
(32, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxcxzcxcz</p>', '2015-06-11 15:40:57', NULL, 0, 0, 1),
(33, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xzczzxc</p>', '2015-06-11 15:41:59', NULL, 0, 0, 1),
(34, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xzczzxc czvzxvzxvz</p>', '2015-06-11 15:42:05', NULL, 0, 0, 1),
(35, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>fasfsafas</p>', '2015-06-11 15:44:17', NULL, 0, 0, 1),
(36, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvccxvxcvc</p>', '2015-06-11 15:45:20', NULL, 0, 0, 1),
(37, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 15:46:07', NULL, 0, 0, 1),
(38, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 15:46:10', NULL, 0, 0, 1),
(39, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 15:46:12', NULL, 0, 0, 1),
(40, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 15:46:13', NULL, 0, 0, 1),
(41, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzxvzvz</p><p><br></p>', '2015-06-11 15:48:10', NULL, 0, 0, 1),
(42, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzxvzvz</p><p>zxczxczxc</p><p><br></p>', '2015-06-11 15:48:14', NULL, 0, 0, 1),
(43, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzxvzvz</p><p>zxczxczxc</p><p><br></p><p>zxvxzvzxvzxvzxvxzvzx</p><p>vzx</p><p>v</p><p>zxvzx</p><p>v</p><p>zxv</p><p>zx</p><p>v</p><p>zx</p>', '2015-06-11 15:48:21', NULL, 0, 0, 1),
(44, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>cxvxvxcv</p>', '2015-06-11 15:49:00', NULL, 0, 0, 1),
(45, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xzzxczxvz</p>', '2015-06-11 15:49:43', NULL, 0, 0, 1),
(46, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxvzvx</p>', '2015-06-11 15:50:14', NULL, 0, 0, 1),
(47, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzzv</p>', '2015-06-11 15:50:30', NULL, 0, 0, 1),
(48, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>dfsdfdsfsdfsdf</p>', '2015-06-11 15:51:08', NULL, 0, 0, 1),
(49, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>sdfsdfsdf</p>', '2015-06-11 15:55:32', NULL, 0, 0, 1),
(50, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>vcvxcvxcvxc</p>', '2015-06-11 15:57:31', NULL, 0, 0, 1),
(51, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xzcxzcz</p>', '2015-06-11 15:59:03', NULL, 0, 0, 1),
(52, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xzcvzxvxzv</p>', '2015-06-11 15:59:36', NULL, 0, 0, 1),
(53, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xzcvzxvxzv</p>', '2015-06-11 15:59:41', NULL, 0, 0, 1),
(54, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zvzxvzxv</p>', '2015-06-11 16:00:23', NULL, 0, 0, 1),
(55, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zvzxvzxv</p>', '2015-06-11 16:00:28', NULL, 0, 0, 1),
(56, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxczxvx</p>', '2015-06-11 16:00:58', NULL, 0, 0, 1),
(57, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>asafasffas</p>', '2015-06-11 16:01:36', NULL, 0, 0, 1),
(58, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxcvcx</p>', '2015-06-11 16:02:30', NULL, 0, 0, 1),
(59, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zzvzxv</p>', '2015-06-11 16:03:36', NULL, 0, 0, 1),
(60, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>cxcxxc</p>', '2015-06-11 16:03:59', NULL, 0, 0, 1),
(61, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zsczzcc</p>', '2015-06-11 16:08:57', NULL, 0, 0, 1),
(62, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>dddd</p>', '2015-06-11 16:09:29', NULL, 0, 0, 1),
(63, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>dddd</p>', '2015-06-11 16:09:44', NULL, 0, 0, 1),
(64, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>asdasdasdas</p>', '2015-06-11 16:14:05', NULL, 0, 0, 1),
(65, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>cczxczx</p>', '2015-06-11 16:15:57', NULL, 0, 0, 1),
(66, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zxczczxczx</p>', '2015-06-11 16:17:21', NULL, 0, 0, 1),
(67, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvcxvxcv</p>', '2015-06-11 16:17:57', NULL, 0, 0, 1),
(68, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>xccxvcxcvxcv</p>', '2015-06-11 16:18:32', NULL, 0, 0, 1),
(69, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zzvzxxzxxx</p>', '2015-06-11 16:19:22', NULL, 0, 0, 1),
(70, 7, '107565152282509124852', 'Aleksander Sowiak', NULL, '2015-06-11 16:19:26', NULL, 0, 0, 1),
(71, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zccxzcx</p>', '2015-06-11 16:20:02', NULL, 0, 0, 1),
(72, 7, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 16:20:14', NULL, 0, 0, 1),
(73, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:22:09', NULL, 0, 0, 1),
(74, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p><p><br></p>', '2015-06-11 16:24:04', NULL, 0, 0, 1),
(75, 7, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 16:26:37', NULL, 0, 0, 1),
(76, 7, '107565152282509124852', 'Aleksander Sowiak', 'xzczxczxc', '2015-06-11 16:26:43', NULL, 0, 0, 1),
(77, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:27:12', NULL, 0, 0, 1),
(78, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:27:22', NULL, 0, 0, 1),
(79, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>dfasfsd</p>', '2015-06-11 16:28:07', NULL, 0, 0, 1),
(80, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:29:01', NULL, 0, 0, 1),
(81, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:29:35', NULL, 0, 0, 1),
(82, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:30:17', NULL, 0, 0, 1),
(83, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:30:29', NULL, 0, 0, 1),
(84, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:30:38', NULL, 0, 0, 1),
(85, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:31:03', NULL, 0, 0, 1),
(86, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:31:19', NULL, 0, 0, 1),
(87, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:31:30', NULL, 0, 0, 1),
(88, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:33:28', NULL, 0, 0, 1),
(89, 7, '107565152282509124852', 'Aleksander Sowiak', 'zxvvvzv', '2015-06-11 16:33:35', NULL, 0, 0, 1),
(90, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:34:03', NULL, 0, 0, 1),
(91, 7, '107565152282509124852', 'Aleksander Sowiak', 'vvcxcxvvcxvxc', '2015-06-11 16:34:12', NULL, 0, 0, 1),
(92, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>zzzvxvzx</p>', '2015-06-11 16:34:51', NULL, 0, 0, 1),
(93, 7, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 16:34:55', NULL, 0, 0, 1),
(94, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:36:52', NULL, 0, 0, 1),
(95, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:37:14', NULL, 0, 0, 1),
(96, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:38:01', NULL, 0, 0, 1),
(97, 7, '107565152282509124852', 'Aleksander Sowiak', 'cxvvxccxvvxc', '2015-06-11 16:38:06', NULL, 0, 0, 1),
(98, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:39:49', NULL, 0, 0, 1),
(99, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:40:05', NULL, 0, 0, 1),
(100, 7, '107565152282509124852', 'Aleksander Sowiak', 'xzvxvccvcxv', '2015-06-11 16:40:21', NULL, 0, 0, 1),
(101, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>cx</p>', '2015-06-11 16:40:28', NULL, 0, 0, 1),
(102, 7, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 16:40:34', NULL, 0, 0, 1),
(103, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:41:19', NULL, 0, 0, 1),
(104, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:41:43', NULL, 0, 0, 1),
(105, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:42:13', NULL, 0, 0, 1),
(106, 7, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 16:43:09', NULL, 0, 0, 1),
(107, 7, '107565152282509124852', 'Aleksander Sowiak', 'xzvcxvcxcxvxvc', '2015-06-11 16:43:16', NULL, 0, 0, 1),
(108, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:43:48', NULL, 0, 0, 1),
(109, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:45:11', NULL, 0, 0, 1),
(110, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:45:43', NULL, 0, 0, 1),
(111, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:47:27', NULL, 0, 0, 1),
(112, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:53:30', NULL, 0, 0, 1),
(113, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 16:53:52', NULL, 0, 0, 1),
(114, 7, '107565152282509124852', 'Aleksander Sowiak', 'cscs', '2015-06-11 16:53:57', NULL, 0, 0, 1),
(115, 7, '107565152282509124852', 'Aleksander Sowiak', 'asdadsa', '2015-06-11 16:54:06', NULL, 0, 0, 1),
(116, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:54:49', NULL, 0, 0, 1),
(117, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:55:31', NULL, 0, 0, 1),
(118, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 16:55:53', NULL, 0, 0, 1),
(119, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 17:00:55', NULL, 0, 0, 1),
(120, 7, '107565152282509124852', 'Aleksander Sowiak', 'dvxcvcxvcxcvx', '2015-06-11 17:01:00', NULL, 0, 0, 1),
(121, 7, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 17:01:33', NULL, 0, 0, 1),
(122, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 17:08:32', NULL, 0, 0, 1),
(123, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>dsffdsfdssfdfds</p>', '2015-06-11 17:11:18', NULL, 0, 0, 1),
(124, NULL, '107565152282509124852', NULL, NULL, '2015-06-11 17:28:51', NULL, 0, 0, 1),
(125, 7, '107096543867743317551', 'Aleksander Sowiak', '<p>No to teraz komencik z innego konta google&nbsp;</p>', '2015-06-12 11:58:28', '["::1"]', 1, 0, 1),
(126, 7, '1236555', 'Aleksander Sowiak', '<p>Jakiś komentarz</p>', '2015-06-12 12:12:10', '["::1"]', 0, 1, 1),
(127, 7, '1236555', 'Aleksander Sowiak', '<p>o ja Cie!</p>', '2015-06-12 15:59:28', NULL, 0, 0, 1),
(128, 8, '107565152282509124852', 'Aleksander Sowiak', '<p>asd</p>', '2015-06-12 16:24:07', NULL, 0, 0, 1),
(129, 8, '1236555', 'Aleksander Sowiak', '<p>Zupa, jak zupa :D</p>', '2015-06-12 17:34:22', NULL, 0, 0, 1),
(130, 8, '1236555', 'Aleksander Sowiak', '<p>OMFG</p>', '2015-06-12 17:39:43', NULL, 0, 0, 1),
(131, 8, '10200744540453682', 'Aleksander Sowiak', '<p>:D komentarz facebookowicza</p>', '2015-06-15 15:35:27', NULL, 0, 0, 1),
(132, 8, '1429747964015393', 'Lisa Amidjfajedac Sharpesky', '<p>chooj</p>', '2015-06-15 17:10:39', NULL, 0, 0, 1),
(133, 8, '107565152282509124852', 'Aleksander Sowiak', '<p>:D</p>', '2015-06-19 14:28:47', NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `privileges`
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `provider_settings`
--

DROP TABLE IF EXISTS `provider_settings`;
CREATE TABLE IF NOT EXISTS `provider_settings` (
  `user_id` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `message` text,
  `code` int(11) DEFAULT NULL,
  `visibility` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `provider_settings`
--

INSERT INTO `provider_settings` (`user_id`, `date`, `message`, `code`, `visibility`) VALUES
('1429747964015393', '2015-06-19 14:38:27', '(#200) The user hasn''t authorized the application to perform this action', 200, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipe`
--

DROP TABLE IF EXISTS `recipe`;
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
  `active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `autor` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `recipe`
--

INSERT INTO `recipe` (`id`, `category`, `autor`, `autor_id`, `title`, `recipe`, `plus`, `minus`, `created`, `updated`, `edited`, `hits`, `active`) VALUES
(7, 'Ciasta', 'Kamila Łucyk', '114872714821609731384', 'Sernik Izaura', '<div class="post-body entry-content" id="post-body-5362672066714899128" itemprop="description articleBody">\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<a href="http://1.bp.blogspot.com/-pVabfQmUzaU/VWcHUjnlz4I/AAAAAAAACto/mP55TlDGzCw/s1600/IMG_1575.JPG" imageanchor="1"><img border="0" height="426" src="http://1.bp.blogspot.com/-pVabfQmUzaU/VWcHUjnlz4I/AAAAAAAACto/mP55TlDGzCw/s640/IMG_1575.JPG" width="640"></a></div>\r\n<br>\r\nZ okazji Dnia Matki postanowiłam skorzystać ze znanego przepisu Sernik Izaury. Bardzo często czytałam, że jest smaczny i szybki w wykonaniu. Dlatego użyczyłam przepis z jednej ze stron i postanowiłam upiec to cudo :) ciasto sprawdzone i bardzo dobre :)<br>\r\n<br>\r\n<div style="text-align: center;">\r\n<br></div>\r\n<div style="text-align: center;">\r\n<b>Składniki:</b></div>\r\n<br>\r\n<b>Ciasto:</b><br>\r\n<br>\r\n<ul>\r\n<li>125 g masła</li>\r\n<li>2 jajka</li>\r\n<li>3/4 szklanki mąki pszennej</li>\r\n<li>1/4 szklanki cukru</li>\r\n<li>2 łyżki kakao</li>\r\n<li>1 łyżeczka proszku do pieczenia</li>\r\n<li>1 cukier wanilinowy</li>\r\n</ul>\r\n<div>\r\n<b>Masa serowa:</b></div>\r\n<div>\r\n<ul>\r\n<li>500 g serka waniliowego w wiaderku</li>\r\n<li>1 budyń waniliowy</li>\r\n<li>3 jajka</li>\r\n<li>2 łyżki masła</li>\r\n<li>1/4 szklanki cukru</li>\r\n</ul>\r\n<div>\r\n<b>Polewa:</b></div>\r\n</div>\r\n<div>\r\n<ul>\r\n<li>50 g czekolady ( ja przyjęłam 30 g mlecznej 20 g gorzkiej)</li>\r\n<li>2 łyżeczki gęstej śmietany</li>\r\n<li>wiórki kokosowe, lub posypka do dekoracji</li>\r\n</ul>\r\n<div>\r\n<b>Wykonanie</b>: masło rozpuszczamy razem z cukrem i cukrem waniliowym. Odstawiamy. Kiedy już ostygnie, dodajemy żółtka, mąkę wymieszaną i przesianą z proszkiem do pieczenia i kakao - mieszamy. Białka ubijamy na sztywną pianę, następnie łączymy z masą. Delikatnie mieszamy do chwili połączenia się składników. Masę wylewamy do wysokiej tortownicy o średnicy około 18 cm. wyłożonej papierem do pieczenia.</div>\r\n</div>\r\n<div>\r\n<b>Masa serowa:</b> Masło ucieramy z jajkami i cukrem, następnie dodajemy ser, a a samym końcu budyń waniliowy. Gotową masę wylewamy na ciasto.</div>\r\n<div>\r\nSernik pieczemy przez 50-60 minut w temp. 180*C</div>\r\n<div>\r\nOstudzone ciasto polewamy polewą czekoladową, którą uzyskamy, roztapiając czekoladę w kąpieli wodnej czy też w rondelku. Do roztopionej czekolady dodajemy śmietanę, mieszamy i wylewamy na sernik.&nbsp;</div>\r\n<div>\r\nCiasto można dodatkowo posypać wiórkami, bądź posypką :)</div>\r\n<div>\r\n<br></div>\r\n<div>\r\nSmacznego :)<br>\r\n<br>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<a href="http://2.bp.blogspot.com/-NOin7D5LAKw/VWcOlwtku1I/AAAAAAAACt4/vvPvurMDvUw/s1600/IMG_1578.JPG" imageanchor="1"><img border="0" height="426" src="http://2.bp.blogspot.com/-NOin7D5LAKw/VWcOlwtku1I/AAAAAAAACt4/vvPvurMDvUw/s640/IMG_1578.JPG" width="640"></a></div>\r\n<br></div>\r\n<div style="clear: both;"></div>\r\n</div>', 0, 0, '2015-06-10 05:03:00', '2015-06-10 05:03:00', 0, 0, 1),
(8, 'Zupy', 'Kamila Łucyk', '114872714821609731384', 'Koperkowa z ryżem', '<div class="post hentry" itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">\r\n\r\n    <div class="post-body entry-content" id="post-body-2058456875013788859" itemprop="description articleBody">\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <a href="http://2.bp.blogspot.com/-UOXO0YzrW9I/VQcfDdhPazI/AAAAAAAACsk/324G48mpRfE/s1600/IMG_1412.JPG" imageanchor="1" style="margin-left: 1em; margin-right: 1em;"><img border="0" src="http://2.bp.blogspot.com/-UOXO0YzrW9I/VQcfDdhPazI/AAAAAAAACsk/324G48mpRfE/s1600/IMG_1412.JPG" height="426" width="640"></a></div>\r\n        <br>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            Dziś polecam zupę ryżową nieco inaczej :) w sam raz dla fanów dobrej zupy, koperku no i oczywiście ryżu :) czyli zupa koperkowa z ryżem ^^</div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <br></div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <b>Składniki:</b></div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <br></div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n        </div>\r\n        <ul>\r\n            <li style="text-align: left;">około 2,4 litra drobiowego bulionu</li>\r\n            <li style="text-align: left;">3/4 szklanki ryżu</li>\r\n            <li style="text-align: left;">1 duży pęczek pietruszki</li>\r\n            <li style="text-align: left;">3 łyżki śmietany 18%</li>\r\n            <li style="text-align: left;">pieprz sól</li>\r\n            <li style="text-align: left;">marchewka pozostała z przygotowywania bulionu</li>\r\n        </ul>\r\n        <div style="text-align: left;">\r\n            <b>Wykonanie: </b>Do bulionu wsypujemy &nbsp;opłukany ryż i gotujemy przez 10 minut. Marchewkę kroimy w kostkę, a pietruszkę siekamy dodając warzywa do zupy. Śmietanę łączymy z odrobiną zupy, mieszamy i łączymy z resztą zupy.</div>\r\n        <div style="text-align: left;">\r\n            <br></div>\r\n        <div style="text-align: left;">\r\n            No i cóż ? Doprawiamy solą i pieprzem , no i gotowe :) ja pokusiłam się o dodanie nieco czosnku ale to już smak dla koneserów :)</div>\r\n        <div style="text-align: left;">\r\n            &nbsp;</div>\r\n        <br>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <a href="http://2.bp.blogspot.com/-0fEdp3z_Ymk/VQcfETY8agI/AAAAAAAACss/l3gjtExGl-M/s1600/IMG_1419.JPG" imageanchor="1" style="margin-left: 1em; margin-right: 1em;"><img border="0" src="http://2.bp.blogspot.com/-0fEdp3z_Ymk/VQcfETY8agI/AAAAAAAACss/l3gjtExGl-M/s1600/IMG_1419.JPG" height="640" width="426"></a></div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <br></div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            Oto szybki przepis na smaczną zupę ryżową inaczej :)</div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            Smacznego ^^</div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            - gazetkowy przepis.</div>\r\n        <div class="separator" style="clear: both; text-align: center;">\r\n            <br></div>\r\n    </div>\r\n</div>\r\n       \r\n', 0, 0, '2015-06-12 20:21:19', '2015-06-12 20:21:23', 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `setings`
--

DROP TABLE IF EXISTS `setings`;
CREATE TABLE IF NOT EXISTS `setings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `additional_settings` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `data` longtext COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=10 ;

--
-- Zrzut danych tabeli `setings`
--

INSERT INTO `setings` (`id`, `user_id`, `type`, `additional_settings`, `active`, `data`) VALUES
(5, '107565152282509124852', 'facebook', '{"fb-box":"0","data-layout":"standard","data-share":"true","data-colorscheme":"light","data-width":"500","data-heigt":"650","data-hide-cover":"false","data-show-facepile":"true","data-show-posts":"false"}', 1, 'http://www.facebook.com/pages/Magiczny-Dom/376351182450245'),
(6, '107565152282509124852', 'about', '{"title_about":"Strona o mnie!"}', 1, 'Kilka słów o mnie'),
(7, '107565152282509124852', 'web_title', NULL, 1, 'W Moim Magicznym Domu'),
(8, '107565152282509124852', 'max_limit', NULL, 1, '5'),
(9, '107565152282509124852', 'com_per_page', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_recipe` bigint(11) NOT NULL,
  `autor_id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `tags` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`,`id_recipe`),
  KEY `id_recipe` (`id_recipe`),
  KEY `autor_id` (`autor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `tags`
--

INSERT INTO `tags` (`id`, `id_recipe`, `autor_id`, `tags`) VALUES
(2, 7, '100000000000000000000', 'Biały ser'),
(3, 7, '100000000000000000000', 'Biszkopt'),
(4, 7, '100000000000000000000', 'Ciasto'),
(5, 7, '100000000000000000000', 'Kakao'),
(6, 7, '100000000000000000000', 'Sernik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `access_token` text COLLATE utf8_polish_ci,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `given_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `family_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `link` text COLLATE utf8_polish_ci NOT NULL,
  `picture` longtext COLLATE utf8_polish_ci NOT NULL,
  `provider` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `locale` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `verified_email` varchar(50) COLLATE utf8_polish_ci DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `access_token`, `name`, `given_name`, `family_name`, `link`, `picture`, `provider`, `gender`, `locale`, `password`, `email`, `created`, `updated`, `active`, `role`, `verified_email`) VALUES
('107096543867743317551', '', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107096543867743317551', 'https://lh5.googleusercontent.com/-_uB6SXdYeg0/AAAAAAAAAAI/AAAAAAAAF0A/DwZc0pFqloo/photo.jpg', 'google', 'male', '', '', 'vuwuke@gmail.com', '2015-06-12 14:58:56', '2015-06-12 14:58:56', 0, 0, '1'),
('107565152282509124852', '', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107565152282509124852', 'https://lh5.googleusercontent.com/-FkDyEvRXuUE/AAAAAAAAAAI/AAAAAAAAAEE/tGLgiWMndVg/photo.jpg', 'google', 'male', '', '', 'aleksander.sowiak@gmail.com', '2015-06-13 06:36:14', '2015-06-13 06:36:14', 0, 0, '1'),
('114872714821609731384', '', 'Kamila Łucyk', 'Kamila', 'Łucyk', 'https://plus.google.com/114872714821609731384', 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'google', 'female', 'pl', '', '', '2015-06-09 15:59:17', '2015-06-09 15:59:17', 0, 0, '1'),
('1236555', '', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', '', '', '', 'male', 'pl', '07b4d5416b25a7ac291daacaa18409a4b27f6375', 'aleksander.sowiak@codeconcept.pl', '2015-06-09 17:47:10', '2015-06-09 17:47:11', 1, 1, '1'),
('1429747964015393', 'CAAHXyWfmlG0BAHhObkHdX35xapql2vyWiNfP89t3VCGfNEvIC3pZBPOyk4MRWM3JuPMEjYmtg68eEmbZBdVS7G4VaZAXkiMPuG8UdOxplby9D02njP08oUDegW2MrTesZABBuDNZA7yuV3ZBwzv1ZCwqb5yhYuu7Lo9ZBMqSu5qNwpZA3CuDGVXwg1QpmnKGBb2KuF07aGrYijOk6je2jxGC4', 'Lisa Amidjfajedac Sharpesky', 'Lisa', 'Sharpesky', 'https://www.facebook.com/app_scoped_user_id/1429747964015393/', 'http://graph.facebook.com/1429747964015393/picture?type=large', 'facebook', 'female', 'pl_PL', '', 'wqvtibw_sharpesky_1434393441@tfbnw.net', '2015-06-18 17:56:22', '2015-06-18 17:56:22', 0, 0, 'false'),
('859107794137276', '', 'Kamila Łucyk', 'Kamila', 'Łucyk', 'https://www.facebook.com/app_scoped_user_id/859107794137276/', 'http://graph.facebook.com/859107794137276/picture?type=large', 'facebook', 'female', 'pl_PL', '', 'kamira90@op.pl', '2015-06-15 18:36:42', '2015-06-15 18:36:42', 0, 0, '1');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`);

--
-- Ograniczenia dla tabeli `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `user` (`name`);

--
-- Ograniczenia dla tabeli `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `tags_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET autocommit=0;
SET foreign_key_checks = 0;
START TRANSACTION;

-- Zrzut struktury tabela magicznydom.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_recipe` bigint(11) DEFAULT NULL,
  `reply` int(11) DEFAULT '0',
  `user_id` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `userName` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8_polish_ci,
  `created` timestamp NULL DEFAULT NULL,
  `ips` longtext COLLATE utf8_polish_ci,
  `plus` bigint(50) NOT NULL,
  `minus` bigint(50) NOT NULL,
  `moderate` int(11) NOT NULL DEFAULT '0',
  `reply_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_recipe` (`id_recipe`),
  KEY `comments_ibfk_2` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.comments: ~129 rows (około)
DELETE FROM `comments`;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `id_recipe`, `reply`, `user_id`, `userName`, `comment`, `created`, `ips`, `plus`, `minus`, `moderate`, `reply_id`) VALUES
	(14, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>Bardzo dobre ciasto!</p>', '2015-06-10 04:03:16', '["::1","195.82.172.210","176.107.172.78"]', 1, 2, 1, NULL),
	(15, 7, 0, '100000000000000000000', 'Kamila Łucyk', '<p>Najlepsze z ostatniego czasu!</p>', '2015-06-10 04:03:51', '["::1"]', 4, 0, 1, NULL),
	(16, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>Komentarz z telefonu. :)</p>', '2015-06-10 12:42:30', '["195.82.172.210","176.107.172.78"]', 452, 357, 1, NULL),
	(17, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>Tak to jest jak się, pije...</p><p><br></p>', '2015-06-11 16:31:29', NULL, 0, 0, 1, NULL),
	(18, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'Sprawdzanie komentarza&nbsp;', '2015-06-11 17:08:16', NULL, 0, 0, 1, NULL),
	(19, 7, 0, '107565152282509124852', '', 'Sprawdzanie komentarza&nbsp;', '2015-06-11 17:08:21', NULL, 0, 0, 1, NULL),
	(20, 7, 0, '107565152282509124852', '', 'Sprawdzanie komentarza&nbsp;', '2015-06-11 17:08:24', NULL, 0, 0, 1, NULL),
	(21, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>dfsdsdgdsg</p>', '2015-06-11 17:34:45', NULL, 0, 0, 1, NULL),
	(22, 7, 0, '107565152282509124852', '', '<p>dfsdsdgdsgsdfsdf</p>', '2015-06-11 17:34:47', NULL, 0, 0, 1, NULL),
	(23, 7, 0, '107565152282509124852', '', '<p>dfsdsdgdsgsdfsdfsdsd</p><p><br></p>', '2015-06-11 17:34:52', NULL, 0, 0, 1, NULL),
	(24, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>Taki komecik</p>', '2015-06-11 17:36:21', NULL, 0, 0, 1, NULL),
	(25, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvzvzxvxzcv</p>', '2015-06-11 17:38:11', NULL, 0, 0, 1, NULL),
	(26, 7, 0, '107565152282509124852', '', '<p>xcvzvzxvxzcvsdfsdfdsfsd</p>', '2015-06-11 17:38:14', NULL, 0, 0, 1, NULL),
	(27, 7, 0, '107565152282509124852', '', '<p>xcvzvzxvxzcvsdfsdfdsfsddsfdsfsd</p>', '2015-06-11 17:38:20', NULL, 0, 0, 1, NULL),
	(28, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>gsdgsdgsdfg</p>', '2015-06-11 17:38:54', NULL, 0, 0, 1, NULL),
	(29, 7, 0, '107565152282509124852', '', '<p>gsdgsdgsdfgzzxvzxvx</p>', '2015-06-11 17:39:04', NULL, 0, 0, 1, NULL),
	(30, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 17:40:39', NULL, 0, 0, 1, NULL),
	(31, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 17:40:50', NULL, 0, 0, 1, NULL),
	(32, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxcxzcxcz</p>', '2015-06-11 17:40:57', NULL, 0, 0, 1, NULL),
	(33, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xzczzxc</p>', '2015-06-11 17:41:59', NULL, 0, 0, 1, NULL),
	(34, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xzczzxc czvzxvzxvz</p>', '2015-06-11 17:42:05', NULL, 0, 0, 1, NULL),
	(35, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>fasfsafas</p>', '2015-06-11 17:44:17', NULL, 0, 0, 1, NULL),
	(36, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvccxvxcvc</p>', '2015-06-11 17:45:20', NULL, 0, 0, 1, NULL),
	(37, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 17:46:07', NULL, 0, 0, 1, NULL),
	(38, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 17:46:10', NULL, 0, 0, 1, NULL),
	(39, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 17:46:12', NULL, 0, 0, 1, NULL),
	(40, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxvcv</p>', '2015-06-11 17:46:13', NULL, 0, 0, 1, NULL),
	(41, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzxvzvz</p><p><br></p>', '2015-06-11 17:48:10', NULL, 0, 0, 1, NULL),
	(42, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzxvzvz</p><p>zxczxczxc</p><p><br></p>', '2015-06-11 17:48:14', NULL, 0, 0, 1, NULL),
	(43, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzxvzvz</p><p>zxczxczxc</p><p><br></p><p>zxvxzvzxvzxvzxvxzvzx</p><p>vzx</p><p>v</p><p>zxvzx</p><p>v</p><p>zxv</p><p>zx</p><p>v</p><p>zx</p>', '2015-06-11 17:48:21', NULL, 0, 0, 1, NULL),
	(44, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>cxvxvxcv</p>', '2015-06-11 17:49:00', NULL, 0, 0, 1, NULL),
	(45, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xzzxczxvz</p>', '2015-06-11 17:49:43', NULL, 0, 0, 1, NULL),
	(46, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxvzvx</p>', '2015-06-11 17:50:14', NULL, 0, 0, 1, NULL),
	(47, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxzzv</p>', '2015-06-11 17:50:30', NULL, 0, 0, 1, NULL),
	(48, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>dfsdfdsfsdfsdf</p>', '2015-06-11 17:51:08', NULL, 0, 0, 1, NULL),
	(49, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>sdfsdfsdf</p>', '2015-06-11 17:55:32', NULL, 0, 0, 1, NULL),
	(50, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>vcvxcvxcvxc</p>', '2015-06-11 17:57:31', NULL, 0, 0, 1, NULL),
	(51, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xzcxzcz</p>', '2015-06-11 17:59:03', NULL, 0, 0, 1, NULL),
	(52, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xzcvzxvxzv</p>', '2015-06-11 17:59:36', NULL, 0, 0, 1, NULL),
	(53, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xzcvzxvxzv</p>', '2015-06-11 17:59:41', NULL, 0, 0, 1, NULL),
	(54, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zvzxvzxv</p>', '2015-06-11 18:00:23', NULL, 0, 0, 1, NULL),
	(55, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zvzxvzxv</p>', '2015-06-11 18:00:28', NULL, 0, 0, 1, NULL),
	(56, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxczxvx</p>', '2015-06-11 18:00:58', NULL, 0, 0, 1, NULL),
	(57, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>asafasffas</p>', '2015-06-11 18:01:36', NULL, 0, 0, 1, NULL),
	(58, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvxcvcx</p>', '2015-06-11 18:02:30', NULL, 0, 0, 1, NULL),
	(59, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zzvzxv</p>', '2015-06-11 18:03:36', NULL, 0, 0, 1, NULL),
	(60, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>cxcxxc</p>', '2015-06-11 18:03:59', NULL, 0, 0, 1, NULL),
	(61, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zsczzcc</p>', '2015-06-11 18:08:57', NULL, 0, 0, 1, NULL),
	(62, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>dddd</p>', '2015-06-11 18:09:29', NULL, 0, 0, 1, NULL),
	(63, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>dddd</p>', '2015-06-11 18:09:44', NULL, 0, 0, 1, NULL),
	(64, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>asdasdasdas</p>', '2015-06-11 18:14:05', NULL, 0, 0, 1, NULL),
	(65, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>cczxczx</p>', '2015-06-11 18:15:57', NULL, 0, 0, 1, NULL),
	(66, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zxczczxczx</p>', '2015-06-11 18:17:21', NULL, 0, 0, 1, NULL),
	(67, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xcvcxvxcv</p>', '2015-06-11 18:17:57', NULL, 0, 0, 1, NULL),
	(68, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>xccxvcxcvxcv</p>', '2015-06-11 18:18:32', NULL, 0, 0, 1, NULL),
	(69, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zzvzxxzxxx</p>', '2015-06-11 18:19:22', NULL, 0, 0, 1, NULL),
	(70, 7, 0, '107565152282509124852', 'Aleksander Sowiak', NULL, '2015-06-11 18:19:26', NULL, 0, 0, 1, NULL),
	(71, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zccxzcx</p>', '2015-06-11 18:20:02', NULL, 0, 0, 1, NULL),
	(72, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 18:20:14', NULL, 0, 0, 1, NULL),
	(73, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:22:09', NULL, 0, 0, 1, NULL),
	(74, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p><p><br></p>', '2015-06-11 18:24:04', NULL, 0, 0, 1, NULL),
	(75, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 18:26:37', NULL, 0, 0, 1, NULL),
	(76, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'xzczxczxc', '2015-06-11 18:26:43', NULL, 0, 0, 1, NULL),
	(77, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:27:12', NULL, 0, 0, 1, NULL),
	(78, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:27:22', NULL, 0, 0, 1, NULL),
	(79, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>dfasfsd</p>', '2015-06-11 18:28:07', NULL, 0, 0, 1, NULL),
	(80, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:29:01', NULL, 0, 0, 1, NULL),
	(81, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:29:35', NULL, 0, 0, 1, NULL),
	(82, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:30:17', NULL, 0, 0, 1, NULL),
	(83, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:30:29', NULL, 0, 0, 1, NULL),
	(84, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:30:38', NULL, 0, 0, 1, NULL),
	(85, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:31:03', NULL, 0, 0, 1, NULL),
	(86, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:31:19', NULL, 0, 0, 1, NULL),
	(87, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:31:30', NULL, 0, 0, 1, NULL),
	(88, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:33:28', NULL, 0, 0, 1, NULL),
	(89, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'zxvvvzv', '2015-06-11 18:33:35', NULL, 0, 0, 1, NULL),
	(90, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:34:03', NULL, 0, 0, 1, NULL),
	(91, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'vvcxcxvvcxvxc', '2015-06-11 18:34:12', NULL, 0, 0, 1, NULL),
	(92, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>zzzvxvzx</p>', '2015-06-11 18:34:51', NULL, 0, 0, 1, NULL),
	(93, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 18:34:55', NULL, 0, 0, 1, NULL),
	(94, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:36:52', NULL, 0, 0, 1, NULL),
	(95, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:37:14', NULL, 0, 0, 1, NULL),
	(96, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:38:01', NULL, 0, 0, 1, NULL),
	(97, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'cxvvxccxvvxc', '2015-06-11 18:38:06', NULL, 0, 0, 1, NULL),
	(98, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:39:49', NULL, 0, 0, 1, NULL),
	(99, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:40:05', NULL, 0, 0, 1, NULL),
	(100, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'xzvxvccvcxv', '2015-06-11 18:40:21', NULL, 0, 0, 1, NULL),
	(101, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>cx</p>', '2015-06-11 18:40:28', NULL, 0, 0, 1, NULL),
	(102, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 18:40:34', NULL, 0, 0, 1, NULL),
	(103, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:41:19', NULL, 0, 0, 1, NULL),
	(104, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:41:43', NULL, 0, 0, 1, NULL),
	(105, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:42:13', NULL, 0, 0, 1, NULL),
	(106, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '', '2015-06-11 18:43:09', NULL, 0, 0, 1, NULL),
	(107, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'xzvcxvcxcxvxvc', '2015-06-11 18:43:16', NULL, 0, 0, 1, NULL),
	(108, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:43:48', NULL, 0, 0, 1, NULL),
	(109, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:45:11', NULL, 0, 0, 1, NULL),
	(110, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:45:43', NULL, 0, 0, 1, NULL),
	(111, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:47:27', NULL, 0, 0, 1, NULL),
	(112, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:53:30', NULL, 0, 0, 1, NULL),
	(113, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 18:53:52', NULL, 0, 0, 1, NULL),
	(114, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'cscs', '2015-06-11 18:53:57', NULL, 0, 0, 1, NULL),
	(115, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'asdadsa', '2015-06-11 18:54:06', NULL, 0, 0, 1, NULL),
	(116, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:54:49', NULL, 0, 0, 1, NULL),
	(117, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:55:31', NULL, 0, 0, 1, NULL),
	(118, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 18:55:53', NULL, 0, 0, 1, NULL),
	(119, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 19:00:55', NULL, 0, 0, 1, NULL),
	(120, 7, 0, '107565152282509124852', 'Aleksander Sowiak', 'dvxcvcxvcxcvx', '2015-06-11 19:01:00', NULL, 0, 0, 1, NULL),
	(121, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p><br></p>', '2015-06-11 19:01:33', NULL, 0, 0, 1, NULL),
	(122, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 19:08:32', NULL, 0, 0, 1, NULL),
	(123, 7, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>dsffdsfdssfdfds</p>', '2015-06-11 19:11:18', NULL, 0, 0, 1, NULL),
	(124, NULL, 0, '107565152282509124852', NULL, NULL, '2015-06-11 19:28:51', NULL, 0, 0, 1, NULL),
	(125, 7, 0, '107096543867743317551', 'Aleksander Sowiak', '<p>No to teraz komencik z innego konta google&nbsp;</p>', '2015-06-12 13:58:28', '["::1"]', 1, 0, 1, NULL),
	(126, 7, 0, '1236555', 'Aleksander Sowiak', '<p>Jakiś komentarz</p>', '2015-06-12 14:12:10', '["::1"]', 0, 1, 1, NULL),
	(127, 7, 0, '1236555', 'Aleksander Sowiak', '<p>o ja Cie!</p>', '2015-06-12 17:59:28', NULL, 0, 0, 1, NULL),
	(128, 8, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>asd</p>', '2015-06-12 18:24:07', NULL, 0, 0, 1, NULL),
	(129, 8, 0, '1236555', 'Aleksander Sowiak', '<p>Zupa, jak zupa :D</p>', '2015-06-12 19:34:22', NULL, 0, 0, 1, NULL),
	(130, 8, 0, '1236555', 'Aleksander Sowiak', '<p>OMFG</p>', '2015-06-12 19:39:43', NULL, 0, 0, 1, NULL),
	(131, 8, 0, '10200744540453682', 'Aleksander Sowiak', '<p>:D komentarz facebookowicza</p>', '2015-06-15 17:35:27', NULL, 0, 0, 1, NULL),
	(132, 8, 0, '1429747964015393', 'Lisa Amidjfajedac Sharpesky', '<p>chooj</p>', '2015-06-15 19:10:39', NULL, 0, 0, 1, NULL),
	(133, 8, 0, '107565152282509124852', 'Aleksander Sowiak', '<p>:D</p>', '2015-06-19 16:28:47', NULL, 0, 0, 1, NULL),
	(134, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p><b>Wykonanie</b>: masło rozpuszczamy razem z cukrem i cukrem waniliowym. Odstawiamy. Kiedy już ostygnie, dodajemy żółtka, mąkę wymieszaną i przesianą z proszkiem do pieczenia i kakao - mieszamy. Białka ubijamy na sztywną pianę, następnie łączymy z masą. Delikatnie mieszamy do chwili połączenia się składników. Masę wylewamy do wysokiej tortownicy o średnicy około 18 cm. wyłożonej papierem do pieczenia.</p>', '2015-07-23 03:45:20', NULL, 0, 0, 1, NULL),
	(135, NULL, 0, '10200744540453682', NULL, NULL, '2015-07-23 04:47:17', NULL, 0, 0, 1, NULL),
	(136, NULL, 0, '10200744540453682', NULL, NULL, '2015-07-23 04:49:30', NULL, 0, 0, 1, NULL),
	(137, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>ytutyu</p>', '2015-07-23 05:14:03', NULL, 0, 0, 1, NULL),
	(138, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>5757</p>', '2015-07-23 05:14:42', NULL, 0, 0, 1, NULL),
	(139, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>3456456</p>', '2015-07-23 05:17:16', NULL, 0, 0, 1, NULL),
	(140, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>tutyu</p>', '2015-07-23 05:21:05', NULL, 0, 0, 1, NULL),
	(141, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>5686</p>', '2015-07-23 05:22:19', NULL, 0, 0, 1, NULL),
	(142, 7, 0, '10200744540453682', 'Aleksander Sowiak', '65868', '2015-07-23 05:22:32', NULL, 0, 0, 1, NULL),
	(143, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>4567457457</p>', '2015-07-23 05:23:19', NULL, 0, 0, 1, NULL),
	(144, 7, 0, '10200744540453682', 'Aleksander Sowiak', 'fff', '2015-07-23 05:23:59', NULL, 0, 0, 1, NULL),
	(145, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>111111111111111111111111111</p>', '2015-07-23 05:25:50', NULL, 0, 0, 1, NULL),
	(146, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>579</p>', '2015-07-23 05:31:43', NULL, 0, 0, 1, NULL),
	(147, 7, 0, '10200744540453682', 'Aleksander Sowiak', '2345234534', '2015-07-23 05:32:15', NULL, 0, 0, 1, NULL),
	(148, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>4546757</p>', '2015-07-23 05:33:30', NULL, 0, 0, 1, NULL),
	(149, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>dfghdfhfgh</p>', '2015-07-23 05:36:38', NULL, 0, 0, 1, NULL),
	(150, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>4574</p>', '2015-07-23 05:38:50', NULL, 0, 0, 1, NULL),
	(151, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>568</p>', '2015-07-23 05:40:58', NULL, 0, 0, 1, NULL),
	(152, 7, 0, '10200744540453682', 'Aleksander Sowiak', '56867', '2015-07-23 05:41:10', NULL, 0, 0, 1, NULL),
	(153, 7, 0, '10200744540453682', 'Aleksander Sowiak', '<p>4564456</p>', '2015-07-23 05:42:46', NULL, 0, 0, 1, NULL),
	(154, NULL, 0, '107565152282509124852', 'Aleksander Sowiak', 'reply text', '2015-07-23 08:24:48', NULL, 0, 0, 1, 134),
	(155, NULL, 0, '107565152282509124852', 'Aleksander Sowiak', 'test reply text 4', '2015-07-23 09:55:33', NULL, 0, 0, 1, 134),
	(156, NULL, 0, '107565152282509124852', 'Aleksander Sowiak', 'test reply text 1', '2015-07-23 09:55:35', NULL, 0, 0, 1, 134),
	(157, NULL, 0, '107565152282509124852', 'Aleksander Sowiak', 'test reply text 3', '2015-07-23 09:55:32', NULL, 0, 0, 1, 134),
	(158, NULL, 0, '107565152282509124852', 'Aleksander Sowiak', 'test reply text 2', '2015-07-23 09:55:34', NULL, 0, 0, 1, 134),
	(159, NULL, 0, NULL, 'Aleksander Sowiak', '<p>odpowiedź do 4564456</p><p>:)</p>', '2015-07-23 10:29:37', NULL, 0, 0, 1, 153),
	(160, NULL, 0, '10200744540453682', 'Aleksander Sowiak', '<p>457575</p>', '2015-07-23 10:30:40', NULL, 0, 0, 1, 153),
	(161, NULL, 0, '10200744540453682', 'Aleksander Sowiak', '<p>Chciałbym coś jeszcze napisać, ale co?</p>', '2015-07-23 10:31:56', NULL, 0, 0, 1, 153),
	(162, NULL, 0, '10200744540453682', 'Aleksander Sowiak', '<p>Spoko chyba tak moze być, ale to damy do modernizacji Kamilce, administratorowi&nbsp;</p>', '2015-07-23 10:32:47', NULL, 0, 0, 1, 153);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.notice
CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) DEFAULT NULL,
  `link` text COLLATE utf8_polish_ci,
  `text` text COLLATE utf8_polish_ci,
  `visibility` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.notice: ~0 rows (około)
DELETE FROM `notice`;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.privileges
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.privileges: ~0 rows (około)
DELETE FROM `privileges`;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.provider_settings
CREATE TABLE IF NOT EXISTS `provider_settings` (
  `user_id` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `message` text,
  `code` int(11) DEFAULT NULL,
  `visibility` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli magicznydom.provider_settings: ~1 rows (około)
DELETE FROM `provider_settings`;
/*!40000 ALTER TABLE `provider_settings` DISABLE KEYS */;
INSERT INTO `provider_settings` (`user_id`, `date`, `message`, `code`, `visibility`) VALUES
	('1429747964015393', '2015-06-19 16:38:27', '(#200) The user hasn\'t authorized the application to perform this action', 200, NULL);
/*!40000 ALTER TABLE `provider_settings` ENABLE KEYS */;


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
  `active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `autor` (`autor`),
  CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `user` (`name`),
  CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.recipe: ~1 rows (około)
DELETE FROM `recipe`;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` (`id`, `category`, `autor`, `autor_id`, `title`, `recipe`, `plus`, `minus`, `created`, `updated`, `edited`, `hits`, `active`) VALUES
	(7, 'Ciasta', 'Kamila Łucyk', '100000000000000000000', 'Sernik Izaura', '<div class="post-body entry-content" id="post-body-5362672066714899128" itemprop="description articleBody">\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<a href="http://1.bp.blogspot.com/-pVabfQmUzaU/VWcHUjnlz4I/AAAAAAAACto/mP55TlDGzCw/s1600/IMG_1575.JPG" imageanchor="1"><img border="0" height="426" src="http://1.bp.blogspot.com/-pVabfQmUzaU/VWcHUjnlz4I/AAAAAAAACto/mP55TlDGzCw/s640/IMG_1575.JPG" width="640"></a></div>\r\n<br>\r\nZ okazji Dnia Matki postanowiłam skorzystać ze znanego przepisu Sernik Izaury. Bardzo często czytałam, że jest smaczny i szybki w wykonaniu. Dlatego użyczyłam przepis z jednej ze stron i postanowiłam upiec to cudo :) ciasto sprawdzone i bardzo dobre :)<br>\r\n<br>\r\n<div style="text-align: center;">\r\n<br></div>\r\n<div style="text-align: center;">\r\n<b>Składniki:</b></div>\r\n<br>\r\n<b>Ciasto:</b><br>\r\n<br>\r\n<ul>\r\n<li>125 g masła</li>\r\n<li>2 jajka</li>\r\n<li>3/4 szklanki mąki pszennej</li>\r\n<li>1/4 szklanki cukru</li>\r\n<li>2 łyżki kakao</li>\r\n<li>1 łyżeczka proszku do pieczenia</li>\r\n<li>1 cukier wanilinowy</li>\r\n</ul>\r\n<div>\r\n<b>Masa serowa:</b></div>\r\n<div>\r\n<ul>\r\n<li>500 g serka waniliowego w wiaderku</li>\r\n<li>1 budyń waniliowy</li>\r\n<li>3 jajka</li>\r\n<li>2 łyżki masła</li>\r\n<li>1/4 szklanki cukru</li>\r\n</ul>\r\n<div>\r\n<b>Polewa:</b></div>\r\n</div>\r\n<div>\r\n<ul>\r\n<li>50 g czekolady ( ja przyjęłam 30 g mlecznej 20 g gorzkiej)</li>\r\n<li>2 łyżeczki gęstej śmietany</li>\r\n<li>wiórki kokosowe, lub posypka do dekoracji</li>\r\n</ul>\r\n<div>\r\n<b>Wykonanie</b>: masło rozpuszczamy razem z cukrem i cukrem waniliowym. Odstawiamy. Kiedy już ostygnie, dodajemy żółtka, mąkę wymieszaną i przesianą z proszkiem do pieczenia i kakao - mieszamy. Białka ubijamy na sztywną pianę, następnie łączymy z masą. Delikatnie mieszamy do chwili połączenia się składników. Masę wylewamy do wysokiej tortownicy o średnicy około 18 cm. wyłożonej papierem do pieczenia.</div>\r\n</div>\r\n<div>\r\n<b>Masa serowa:</b> Masło ucieramy z jajkami i cukrem, następnie dodajemy ser, a a samym końcu budyń waniliowy. Gotową masę wylewamy na ciasto.</div>\r\n<div>\r\nSernik pieczemy przez 50-60 minut w temp. 180*C</div>\r\n<div>\r\nOstudzone ciasto polewamy polewą czekoladową, którą uzyskamy, roztapiając czekoladę w kąpieli wodnej czy też w rondelku. Do roztopionej czekolady dodajemy śmietanę, mieszamy i wylewamy na sernik.&nbsp;</div>\r\n<div>\r\nCiasto można dodatkowo posypać wiórkami, bądź posypką :)</div>\r\n<div>\r\n<br></div>\r\n<div>\r\nSmacznego :)<br>\r\n<br>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<a href="http://2.bp.blogspot.com/-NOin7D5LAKw/VWcOlwtku1I/AAAAAAAACt4/vvPvurMDvUw/s1600/IMG_1578.JPG" imageanchor="1"><img border="0" height="426" src="http://2.bp.blogspot.com/-NOin7D5LAKw/VWcOlwtku1I/AAAAAAAACt4/vvPvurMDvUw/s640/IMG_1578.JPG" width="640"></a></div>\r\n<br></div>\r\n<div style="clear: both;"></div>\r\n</div>', 0, 0, '2015-06-10 05:03:00', '2015-06-10 05:03:00', 0, 0, 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.setings: ~5 rows (około)
DELETE FROM `setings`;
/*!40000 ALTER TABLE `setings` DISABLE KEYS */;
INSERT INTO `setings` (`id`, `user_id`, `type`, `additional_settings`, `active`, `data`) VALUES
	(5, '107565152282509124852', 'facebook', '{"fb-box":"0","data-layout":"standard","data-share":"true","data-colorscheme":"light","data-width":"500","data-heigt":"650","data-hide-cover":"false","data-show-facepile":"true","data-show-posts":"false"}', 1, 'http://www.facebook.com/pages/Magiczny-Dom/376351182450245'),
	(6, '107565152282509124852', 'about', '{"title_about":"Strona o mnie!"}', 1, 'Kilka słów o mnie'),
	(7, '107565152282509124852', 'web_title', NULL, 1, 'W Moim Magicznym Domu'),
	(8, '107565152282509124852', 'max_limit', NULL, 1, '5'),
	(9, '107565152282509124852', 'com_per_page', NULL, 1, '5');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.tags: ~5 rows (około)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `id_recipe`, `autor_id`, `tags`) VALUES
	(2, 7, '100000000000000000000', 'Biały ser'),
	(3, 7, '100000000000000000000', 'Biszkopt'),
	(4, 7, '100000000000000000000', 'Ciasto'),
	(5, 7, '100000000000000000000', 'Kakao'),
	(6, 7, '100000000000000000000', 'Sernik');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;


-- Zrzut struktury tabela magicznydom.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `given_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `family_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `picture` text COLLATE utf8_polish_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `locale` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `verified_email` varchar(50) COLLATE utf8_polish_ci NOT NULL DEFAULT 'false',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `provider` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `access_token` text COLLATE utf8_polish_ci,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.user: ~5 rows (około)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `given_name`, `family_name`, `link`, `picture`, `gender`, `locale`, `password`, `email`, `verified_email`, `created`, `updated`, `active`, `role`, `provider`, `access_token`) VALUES
	('100000000000000000000', 'Kamila Łucyk', 'Kamila', 'Łucyk', '', '', 'female', 'pl', '07b4d5416b25a7ac291daacaa18409a4b27f6375', 'kamira90@gmail.com', '1', '2015-06-09 14:51:50', '2015-06-09 14:51:50', 1, 1, NULL, NULL),
	('10200744540453682', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://www.facebook.com/app_scoped_user_id/10200744540453682/', 'http://graph.facebook.com/10200744540453682/picture?type=large', 'male', 'pl_PL', '', 'sowka-rule@o2.pl', 'false', '2015-07-20 07:01:52', '2015-07-20 07:01:52', 0, 0, 'facebook', 'CAAHYFt0sBHkBAISZBt8C2LUMrt9FoiVQZCchxw8NsTg9BwN9Via0Af1MUcp63GAExYZAWh2nn5oxv9Qyg9jLEoDSAHjlOUw9cC5KUREgGqNalNjjb0njx82SfijtRUCwg3ZAuTN6VL1clP7pmVN2XZC4AojvJvn47CtFO3QB8lox8JwLP2LtixV343dLArhYsZBVkYDwhxhY3DDgEyqh3L'),
	('107096543867743317551', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107096543867743317551', 'https://lh5.googleusercontent.com/-_uB6SXdYeg0/AAAAAAAAAAI/AAAAAAAAF0A/DwZc0pFqloo/photo.jpg', 'male', '', '', 'vuwuke@gmail.com', 'false', '2015-06-16 03:30:07', '2015-06-16 03:30:07', 0, 0, 'google', NULL),
	('107565152282509124852', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107565152282509124852', 'https://lh5.googleusercontent.com/-FkDyEvRXuUE/AAAAAAAAAAI/AAAAAAAAAEE/tGLgiWMndVg/photo.jpg', 'male', 'pl', '', '', 'false', '2015-06-09 12:09:36', '2015-06-09 12:09:36', 0, 0, NULL, NULL),
	('1429747964015393', 'Lisa Amidjfajedac Sharpesky', 'Lisa', 'Sharpesky', 'https://www.facebook.com/app_scoped_user_id/142974', 'http://graph.facebook.com/1429747964015393/picture?type=large', 'female', 'pl_PL', '', 'wqvtibw_sharpesky_1434393441@tfbnw.net', 'false', '2015-06-19 05:51:34', '2015-06-19 05:51:34', 0, 0, 'facebook', 'CAAHXyWfmlG0BAFDmSWr6HNUANDmW4rwGI5AFUuRFST51ZCZCHimSxMVAQ2btl3AZBbpXVTO1ELdtdSWI2uZCBxU0kxiGnOVgulkChXYLu5A5lUjyYYgfwISDe8biIxuGbRodwCsz2VTHZBqHXF0piHGo7PZB4N0sAhICCER2SIBgHfBGHQHhJDaOcCVDvlvm8muZBVc4XjB8EnpYqT9OehV');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
COMMIT;
SET foreign_key_checks = 1;
SET autocommit=1;
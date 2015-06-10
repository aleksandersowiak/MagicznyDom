SET autocommit=0;
SET foreign_key_checks = 0;
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
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.comments: ~2 rows (około)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `id_recipe`, `user_id`, `userName`, `comment`, `created`, `ips`, `plus`, `minus`, `moderate`) VALUES
	(14, 7, '107565152282509124852', 'Aleksander Sowiak', '<p>Bardzo dobre ciasto!</p>', '2015-06-10 04:03:16', '["::1"]', 0, 1, 1),
	(15, 7, '100000000000000000000', 'Kamila Łucyk', '<p>Najlepsze z ostatniego czasu!</p>', '2015-06-10 04:03:51', '["::1"]', 1, 0, 1);
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
  `active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `autor` (`autor`),
  CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `user` (`name`),
  CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.recipe: ~1 rows (około)
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.tags: ~5 rows (około)
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
  `link` varchar(50) COLLATE utf8_polish_ci NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Zrzucanie danych dla tabeli magicznydom.user: ~3 rows (około)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `given_name`, `family_name`, `link`, `picture`, `gender`, `locale`, `password`, `email`, `verified_email`, `created`, `updated`, `active`, `role`) VALUES
	('100000000000000000000', 'Kamila Łucyk', 'Kamila', 'Łucyk', '', '', 'female', 'pl', '07b4d5416b25a7ac291daacaa18409a4b27f6375', 'kamira90@gmail.com', 'false', '2015-06-09 14:51:50', '2015-06-09 14:51:50', 1, 1),
	('107096543867743317551', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107096543867743317551', 'https://lh5.googleusercontent.com/-_uB6SXdYeg0/AAAAAAAAAAI/AAAAAAAAF0A/DwZc0pFqloo/photo.jpg', 'male', 'pl', '', '', 'false', '2015-06-09 12:33:37', '2015-06-09 12:33:37', 0, 0),
	('107565152282509124852', 'Aleksander Sowiak', 'Aleksander', 'Sowiak', 'https://plus.google.com/107565152282509124852', 'https://lh5.googleusercontent.com/-FkDyEvRXuUE/AAAAAAAAAAI/AAAAAAAAAEE/tGLgiWMndVg/photo.jpg', 'male', 'pl', '', '', 'false', '2015-06-09 12:09:36', '2015-06-09 12:09:36', 0, 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
SET autocommit=1;
SET foreign_key_checks = 1;
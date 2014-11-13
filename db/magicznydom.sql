-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 13 Lis 2014, 15:58
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
-- Struktura tabeli dla tabeli `recipe`
--

CREATE TABLE IF NOT EXISTS `recipe` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `recipe` text COLLATE utf8_polish_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `hits` bigint(22) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `recipe`
--

INSERT INTO `recipe` (`id`, `category`, `autor`, `title`, `recipe`, `created`, `updated`, `hits`) VALUES
(1, 'Ciasta', 'Aleksander Sowiak', 'Ciasto z makiem i serem na kruchym cieście', '<div class="post-body entry-content" id="post-body-1342671366611124891" itemprop="description articleBody">\r\n\r\n<div class="separator" style="clear: both; text-align: center;">\r\nZnalazłam w sieci przepis cieszący się dużym uznaniem łącząc z sobą ser i mak.</div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\nJak dla osoby, która kocha mam , a nie przepada za serem te ciasto wywarło na mnie duże wrażenie. Jak na dużą blachę jaką zrobiłam znikło dość szybko :) a to chyba dobrze świadczy o cieście prawda ?</div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\nPrzepis na ciasto nieco został zmodyfikowany :)&nbsp;</div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<b>Składniki:</b></div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<b><br></b></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n<b>Ciasto:</b></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n</div>\r\n<ul>\r\n<li>1,5 szklanki mąki pszennej</li>\r\n<li>0,5 kostki margaryny</li>\r\n<li>0,5 szklanki cukru pudru</li>\r\n<li>1 żółtko</li>\r\n<li>1 łyżka rumu</li>\r\n</ul>\r\n<div>\r\n<b>Masa Makowa:</b></div>\r\n<div>\r\n<ul>\r\n<li>gotowa masa makowa z puszki (800 gr -900 gr)</li>\r\n<li>3 białka</li>\r\n<li>2 łyżki bułki tartej</li>\r\n<li>1 olejek waniliowy</li>\r\n</ul>\r\n<div>\r\n<b>Masa Serowa:</b></div>\r\n</div>\r\n<div>\r\n<ul>\r\n<li>1 kg sera w wiaderku (ważne aby ser nie był za rzadki )</li>\r\n<li>1 szklanka cukru pudru</li>\r\n<li>5 jajek</li>\r\n<li>0,5 kostki masła</li>\r\n</ul>\r\n</div>\r\n<br>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<b>Wykonanie</b></div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<b><br></b></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\nZ podanych składników na ciasto wyrabiamy kruche ciasto , wszystko razem zagniatając i uzyskując jednolitą masę, którą wkładamy na około godziny do lodówki</div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\nFormę o wymiarach 37 x 23 cm smarujemy tłuszczem i obsypujemy bułką tartą / mąką. Wyciągamy ciasto i wykładamy je na blaszkę nakłuwając je widelcem w kilku miejscach.</div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\nCiasto wkładamy na około 15-20 minut do piekarnika rozgrzanego w 180*C - trzymamy ciasto tak długo aż nabierze złotego koloru</div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\nMasę makową wykładamy z puszki. Jeżeli jest za luźne na wszelki wypadek polecam je nieco odsączyć. Bułkę tartą oraz olejek waniliowy łączymy z makiem, następnie dodajemy do maku ubita pianę z białek.</div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\nMasa serowa: Oddzielamy żółtka od białek. Masło ucieramy z cukrem i żółtkami. W dalszym ciągu miksując dodajemy po łyżce białego sera z wiaderka. Białka ubijamy , dodając na koniec ubitą piane z białek</div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\nNa podpieczone wcześniej ciasto wykładamy masę makową , następnie masę serową i raz jeszcze wkładamy ciasto do piekarnika o tej samej temperaturze ( 180* C) na godzinę :)</div>\r\n<div class="separator" style="clear: both; text-align: left;">\r\n<br></div>\r\n\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<br></div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\nŻyczę smacznego :)</div>\r\n<div class="separator" style="clear: both; text-align: center;">\r\n<br></div>\r\n<br>\r\n<br>\r\n<br>\r\n\r\n<div style="clear: both;"></div>\r\n</div>', '2014-11-12 00:00:00', '2014-11-12 00:00:00', 0),
(2, 'Ciasta', 'Aleksander Sowiak', 'First featurette heading.', 'List group item heading\r\nDonec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.', '2014-11-11 00:00:00', '2014-11-11 00:00:00', 0),
(3, 'Desery', 'Aleksander Sowiak', 'Deser', 'Opis deseru', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `setings`
--

CREATE TABLE IF NOT EXISTS `setings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `data` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `setings`
--

INSERT INTO `setings` (`id`, `type`, `data`) VALUES
(1, 'menu', '[{"name":"Główna","link":"\\/","dropdown":null},{"name":"Przepisy","link":"\\/recipes-for-cakes","dropdown":[{"drop_name":"Ciasta Kruche","drop_link":"\\/recipes-for-cakes\\/brittle-cakes"},{"drop_name":"Serniki","drop_link":"\\/recipes-for-cakes\\/cheesecakes"},{"drop_name":"Babki","drop_link":"\\/recipes-for-cakes\\/babka"}]},\r\n{"name":"O mnie","link":"/about","dropdown":null}]'),
(2, 'about', '{"active":true,"text":"Tekst o sobie. Jeżeli w ustawieniach jest zazaczone \\"Nie pokazuj\\", wtedy ta informacja nie będzie wyświetlana"}');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `created`, `updated`, `active`, `name`, `password`, `email`) VALUES
(1, '2014-11-10 00:00:00', '2014-11-10 00:00:00', 1, 'Aleksander Sowiak', '07b4d5416b25a7ac291daacaa18409a4b27f6375', 'aleksander.sowiak@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

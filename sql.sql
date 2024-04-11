-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2012 at 08:22 PM
-- Server version: 5.1.56
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alan948_hacked`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `what` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4902 ;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `cat` tinyint(2) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;



--
-- Table structure for table `banned`
--

CREATE TABLE IF NOT EXISTS `banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mod` int(8) NOT NULL,
  `id_user` int(10) NOT NULL,
  `text` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `active` int(11) NOT NULL,
  `ip` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=147 ;

--
-- Dumping data for table `banned`
--



-- --------------------------------------------------------

--
-- Table structure for table `blocked`
--

CREATE TABLE IF NOT EXISTS `blocked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=64 ;

--
-- Dumping data for table `blocked`
--



-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET utf8 NOT NULL,
  `url` tinytext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`) VALUES
(33, 'Ecolog&iacute;a', 'ecologia'),
(32, 'Hazlo tu mismo', 'hazlo-tu-mismo'),
(31, 'Ciencia y educaci&oacute;n', 'ciencia-educacion'),
(30, 'Anime / Manga / Otros', 'anime-manga-otros'),
(29, 'Mascotas', 'mascotas'),
(28, 'Econom&iacute;a y Negocios', 'economia-negocios'),
(27, 'Moovax', 'comunidad-moovax'),
(26, 'Salud y bienestar', 'salud-bienestar'),
(25, 'Ebooks / Tutoriales', 'ebooks-tutoriales'),
(24, 'Humor', 'humor'),
(23, 'Autos y motos', 'autos-motos'),
(22, 'Mujer', 'femme'),
(21, 'Mac', 'mac'),
(20, 'Recetas y Cocina', 'recetas-y-cocina'),
(19, 'Solidaridad', 'solidaridad'),
(18, 'Comic''s', 'comics'),
(17, 'Apuntes y Monografias', 'apuntes-y-monografias'),
(16, 'Celulares', 'celulares'),
(15, 'Deportes', 'deportes'),
(14, 'Linux', 'linux'),
(13, 'Patrocinadores', 'patrocinados'),
(12, 'Cine / Tv / Musicales', 'cine-tv-musicales'),
(11, 'Info', 'info'),
(10, 'Noticias', 'noticias'),
(9, 'Downloads', 'downloads'),
(8, 'M&uacute;sica', 'musica'),
(7, 'Animaciones', 'animaciones'),
(6, 'Off-topic', 'off-topic'),
(5, 'Arte', 'arte'),
(4, 'Videos', 'videos'),
(34, 'Fotos', 'imagenes'),
(35, 'Juegos', 'juegos');

-- --------------------------------------------------------

--
-- Table structure for table `censorship`
--

CREATE TABLE IF NOT EXISTS `censorship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `author` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=69 ;

--
-- Dumping data for table `censorship`
--



-- --------------------------------------------------------

--
-- Table structure for table `chat`
--


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `positive` tinyint(4) NOT NULL,
  `negative` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5343 ;


-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL,
  `author` int(11) NOT NULL,
  `num` tinyint(1) NOT NULL,
  `id_post` int(11) NOT NULL,
  `what` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  `comment` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `office` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schedule` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `motive` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL,
  `comment` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `img_pais` varchar(2) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=461 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `img_pais`) VALUES
(144, 'Afganist&aacute;n', 'af'),
(114, 'Albania', 'al'),
(18, 'Alemania', 'de'),
(98, 'Algeria', 'dz'),
(145, 'Andorra', 'ad'),
(119, 'Angola', 'ao'),
(4, 'Anguilla', 'ai'),
(147, 'Antigua y Barbuda', 'ag'),
(207, 'Antillas Neerlandesas', 'an'),
(91, 'Arabia Saudita', 'sa'),
(5, 'Argentina', 'ar'),
(6, 'Armenia', 'am'),
(142, 'Aruba', 'aw'),
(1, 'Australia', 'au'),
(2, 'Austria', 'at'),
(3, 'Azerbaiy&aacute;n', 'az'),
(80, 'Bahamas', 'bs'),
(127, 'Bahrein', 'bh'),
(149, 'Bangladesh', 'bd'),
(128, 'Barbados', 'bb'),
(9, 'B&eacute;lgica', 'be'),
(8, 'Belice', 'bz'),
(151, 'Ben&iacute;n', 'bj'),
(10, 'Bermudas', 'bm'),
(7, 'Bielorrusia', 'by'),
(123, 'Bolivia', 'bo'),
(79, 'Bosnia y Herzegovina', 'ba'),
(100, 'Botswana', 'bw'),
(12, 'Brasil', 'br'),
(155, 'Brun&eacute;i', 'bn'),
(11, 'Bulgaria', 'bg'),
(156, 'Burkina Faso', 'bf'),
(157, 'Burundi', 'bi'),
(152, 'But&aacute;n', 'bt'),
(159, 'Cabo Verde', 'cv'),
(158, 'Camboya', 'kh'),
(31, 'Camer&uacute;n', 'cm'),
(32, 'Canad&aacute;', 'ca'),
(130, 'Chad', 'td'),
(81, 'Chile', 'cl'),
(35, 'China', 'cn'),
(33, 'Chipre', 'cy'),
(82, 'Colombia', 'co'),
(164, 'Comores', 'km'),
(112, 'RepUblica DemocrAtica del Congo', 'cd'),
(166, 'Islas Cook', 'ck'),
(84, 'Corea del Norte', 'kp'),
(69, 'Corea del Sur', 'kr'),
(168, 'Costa de Marfil', 'ci'),
(36, 'Costa Rica', 'cr'),
(71, 'Croacia', 'hr'),
(113, 'Cuba', 'cu'),
(22, 'Dinamarca', 'dk'),
(103, 'Ecuador', 'ec'),
(23, 'Egipto', 'eg'),
(51, 'El Salvador', 'sv'),
(93, 'Emiratos &Aacute;rabes Unidos', 'ae'),
(173, 'Eritrea', 'er'),
(52, 'Eslovaquia', 'sk'),
(53, 'Eslovenia', 'si'),
(28, 'Espa&ntilde;a', 'es'),
(55, 'Estados Unidos', 'us'),
(68, 'Estonia', 'ee'),
(121, 'Etiop&iacute;a', 'et'),
(175, 'Islas Feroe', 'fo'),
(90, 'Filipinas', 'ph'),
(63, 'Finlandia', 'fi'),
(176, 'Fiyi', 'fj'),
(64, 'Francia', 'fr'),
(180, 'Gab&oacute;n', 'ga'),
(181, 'Gambia', 'gm'),
(21, 'Georgia', 'ge'),
(105, 'Ghana', 'gh'),
(143, 'Gibraltar', 'gi'),
(184, 'Granada', 'gd'),
(20, 'Grecia', 'gr'),
(94, 'Groenlandia', 'gl'),
(17, 'Guadalupe', 'gp'),
(185, 'Guatemala', 'gt'),
(186, 'Guernsey', 'gg'),
(187, 'Guinea', 'gn'),
(172, 'Guinea Ecuatorial', 'gq'),
(188, 'Guinea-Bissau', 'gw'),
(189, 'Guyana', 'gy'),
(16, 'Haiti', 'ht'),
(137, 'Honduras', 'hn'),
(73, 'Hong Kong', 'hk'),
(14, 'Hungr&iacute;a', 'hu'),
(25, 'India', 'in'),
(74, 'Indonesia', 'id'),
(140, 'Irak', 'iq'),
(26, 'Ir&aacute;n', 'ir'),
(27, 'Irlanda', 'ie'),
(215, 'Isla Pitcairn', 'pn'),
(83, 'Islandia', 'is'),
(228, 'Islas Salom&oacute;n', 'sb'),
(58, 'Islas Turcas y Caicos', 'tc'),
(154, 'Islas Virgenes Brit&aacute;nicas', 'vg'),
(24, 'Israel', 'il'),
(29, 'Italia', 'it'),
(132, 'Jamaica', 'jm'),
(70, 'Jap&oacute;n', 'jp'),
(193, 'Jersey', 'je'),
(75, 'Jordania', 'jo'),
(30, 'Kazajst&aacute;n', 'kz'),
(97, 'Kenia', 'ke'),
(34, 'Kirguist&aacute;n', 'kg'),
(195, 'Kiribati', 'ki'),
(37, 'Kuwait', 'kw'),
(196, 'Laos', 'la'),
(197, 'Lesotho', 'ls'),
(38, 'Letonia', 'lv'),
(99, 'L&iacute;bano', 'lb'),
(198, 'Liberia', 'lr'),
(39, 'Libia', 'ly'),
(126, 'Liechtenstein', 'li'),
(40, 'Lituania', 'lt'),
(41, 'Luxemburgo', 'lu'),
(134, 'Madagascar', 'mg'),
(76, 'Malasia', 'my'),
(125, 'Malawi', 'mw'),
(200, 'Maldivas', 'mv'),
(133, 'Mal&iacute;', 'ml'),
(86, 'Malta', 'mt'),
(131, 'Isla de Man', 'im'),
(104, 'Marruecos', 'ma'),
(201, 'Martinica', 'mq'),
(202, 'Mauricio', 'mu'),
(108, 'Mauritania', 'mr'),
(42, 'M&eacute;xico', 'mx'),
(43, 'Moldavia', 'md'),
(44, 'M&oacute;naco', 'mc'),
(139, 'Mongolia', 'mn'),
(117, 'Mozambique', 'mz'),
(205, 'Myanmar', 'mm'),
(102, 'Namibia', 'na'),
(206, 'Nauru', 'nr'),
(107, 'Nepal', 'np'),
(209, 'Nicaragua', 'ni'),
(210, 'N&iacute;ger', 'ne'),
(115, 'Nigeria', 'ng'),
(212, 'Norfolk', 'nf'),
(46, 'Noruega', 'no'),
(208, 'Nueva Caledonia', 'nc'),
(45, 'Nueva Zelanda', 'nz'),
(213, 'Om&aacute;n', 'om'),
(19, 'Pa&iacute;ses Bajos', 'nl'),
(87, 'Pakist&aacute;n', 'pk'),
(124, 'Panam&aacute;', 'pa'),
(88, 'Pap&uacute;a-Nueva Guinea', 'pg'),
(110, 'Paraguay', 'py'),
(89, 'Per&uacute;', 'pe'),
(178, 'Polinesia Francesa', 'pf'),
(47, 'Polonia', 'pl'),
(48, 'Portugal', 'pt'),
(246, 'Puerto Rico', 'pr'),
(216, 'Qatar', 'qa'),
(13, 'Reino Unido', 'gb'),
(65, 'Rep&uacute;blica Checa', 'cz'),
(138, 'Rep&uacute;blica Dominicana', 'do'),
(49, 'Reuni&oacute;n', 're'),
(217, 'Ruanda', 'rw'),
(72, 'Ruman&iacute;a', 'ro'),
(50, 'Rusia', 'ru'),
(223, 'Samoa', 'ws'),
(219, 'San Cristobal y Nevis', 'kn'),
(224, 'San Marino', 'sm'),
(221, 'San Pedro y Miquel&oacute;n', 'pm'),
(225, 'San Tom&eacute; y Pr&iacute;ncipe', 'st'),
(222, 'San Vincente y Granadinas', 'vc'),
(218, 'Santa Elena', 'sh'),
(220, 'Santa Luc&iacute;a', 'lc'),
(135, 'Senegal', 'sn'),
(226, 'Serbia y Montenegro', 'rs'),
(109, 'Seychelles', 'sc'),
(227, 'Sierra Leona', 'sl'),
(77, 'Singapur', 'sg'),
(106, 'Siria', 'sy'),
(229, 'Somalia', 'so'),
(120, 'Sri Lanka', 'lk'),
(141, 'Sud&aacute;frica', 'za'),
(232, 'Sud&aacute;n', 'sd'),
(67, 'Suecia', 'se'),
(66, 'Suiza', 'ch'),
(54, 'Surinam', 'sr'),
(234, 'Suazilandia', 'sz'),
(56, 'Tayikistan', 'tj'),
(92, 'Tailandia', 'th'),
(78, 'Taiwan', 'tw'),
(101, 'Tanzania', 'tz'),
(171, 'Timor Oriental', 'tl'),
(136, 'Togo', 'tg'),
(235, 'Tokelau', 'tk'),
(236, 'Tonga', 'to'),
(237, 'Trinidad y Tobago', 'tt'),
(122, 'T&uacute;nez', 'tn'),
(57, 'Turkmenistan', 'tm'),
(59, 'Turqu&iacute;a', 'tr'),
(239, 'Tuvalu', 'tv'),
(62, 'Ucrania', 'ua'),
(60, 'Uganda', 'ug'),
(111, 'Uruguay', 'uy'),
(61, 'Uzbekist&aacute;n', 'uz'),
(240, 'Vanuatu', 'vu'),
(95, 'Venezuela', 've'),
(15, 'Vietnam', 'vn'),
(241, 'Wallis y Futuna', 'wf'),
(243, 'Yemen', 'ye'),
(116, 'Zambia', 'zm'),
(96, 'Zimbabwe', 'zw');

-- --------------------------------------------------------

--
-- Table structure for table `c_votes`
--

CREATE TABLE IF NOT EXISTS `c_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `comment` int(11) NOT NULL,
  `type` enum('1','-1') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `type2` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1375 ;

--
-- Dumping data for table `c_votes`
--


-- --------------------------------------------------------

--
-- Table structure for table `drafts`
--

CREATE TABLE IF NOT EXISTS `drafts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `cat` tinyint(2) NOT NULL,
  `sticky` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  `closed` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `private` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `cause` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1796 ;

--
-- Dumping data for table `drafts`
--


-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `id_pf` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=836 ;

--
-- Dumping data for table `favorites`
--



-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `desc` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `cat` tinyint(4) NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `private` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `rankdefault` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_actions`
--

CREATE TABLE IF NOT EXISTS `groups_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  `action` enum('0','1','2','3','4') COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=261 ;

--
-- Dumping data for table `groups_actions`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_ban`
--

CREATE TABLE IF NOT EXISTS `groups_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `cause` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reamingtime` int(10) NOT NULL,
  `group` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups_ban`
--



-- --------------------------------------------------------

--
-- Table structure for table `groups_categories`
--

CREATE TABLE IF NOT EXISTS `groups_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `groups_categories`
--

INSERT INTO `groups_categories` (`id`, `name`, `url`, `img`) VALUES
(1, 'Deportes', 'deportes', 'deportes'),
(2, 'Econom&iacute;a y Negocios', 'economia-negocios', 'economia_negocios'),
(3, 'Entretenimiento y Medios', 'entretenimiento-medios', 'entretenimientos'),
(4, 'Regiones', 'regiones', 'medio_naturaleza'),
(5, 'Internet y Tecnolog&iacute;a', 'internet-tecnologia', 'internet_tecnologia'),
(6, 'M&uacute;sica y Bandas', 'musica-bandas', 'musica'),
(7, 'Grupos y Organizaciones', 'grupos-organizaciones', 'sociedad_cultura'),
(8, 'Inter&eacute;s general', 'interes-general', 'otras'),
(9, 'Arte y Literatura', 'arte-literatura', 'arte_literatura'),
(10, 'Diversi&oacute;n y Esparcimiento', 'diversion-esparcimiento', 'juegos_recreacion');

-- --------------------------------------------------------

--
-- Table structure for table `groups_comments`
--

CREATE TABLE IF NOT EXISTS `groups_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `id_topic` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=258 ;

--
-- Dumping data for table `groups_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_history`
--

CREATE TABLE IF NOT EXISTS `groups_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `text` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `group` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  `duration` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `groups_history`
--



-- --------------------------------------------------------

--
-- Table structure for table `groups_members`
--

CREATE TABLE IF NOT EXISTS `groups_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `group` int(11) NOT NULL,
  `rank` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=360 ;

--
-- Dumping data for table `groups_members`
--



-- --------------------------------------------------------

--
-- Table structure for table `groups_topics`
--

CREATE TABLE IF NOT EXISTS `groups_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `sticky` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `closed` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `votes` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=206 ;

--
-- Dumping data for table `groups_topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_votes`
--

CREATE TABLE IF NOT EXISTS `groups_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `topic` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=98 ;

--
-- Dumping data for table `groups_votes`
--



-- --------------------------------------------------------

--
-- Table structure for table `help_categories`
--

CREATE TABLE IF NOT EXISTS `help_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `help_categories`
--

INSERT INTO `help_categories` (`id`, `name`, `url`, `description`) VALUES
(1, 'InformaciÃ³n general', 'informacion', 'AquÃ­ se publica todo lo relacionado con el estado del sitios'),
(2, 'Denuncias', 'Denuncias', 'InformaciÃ³n sobre denuncias'),
(3, 'Sistema de puntuaciÃ³n', 'Sistema-de-puntuacin', 'Todo lo relacionado con el sistema de rangos'),
(4, 'Perfil de usuario', 'Perfil-de-usuario', 'InformaciÃ³n sobre los perfiles'),
(5, 'Chat', 'Chat', 'InformaciÃ³n sobre el chat'),
(6, 'Buscador', 'Buscador', 'Ayuda con el buscador');

-- --------------------------------------------------------

--
-- Table structure for table `history_mod`
--

CREATE TABLE IF NOT EXISTS `history_mod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `photo` int(11) NOT NULL,
  `moderador` int(11) NOT NULL,
  `reason` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=366 ;

--
-- Dumping data for table `history_mod`
--



-- --------------------------------------------------------

--
-- Table structure for table `ips_ban`
--

CREATE TABLE IF NOT EXISTS `ips_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `author` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=156 ;

--
-- Dumping data for table `ips_ban`
--



-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `mail` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `type` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1065 ;

--
-- Dumping data for table `mails`
--



-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `issue` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `author_read` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `receiver_read` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `author_status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  `receiver_status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1126 ;

--
-- Dumping data for table `messages`
--



--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `act` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `news`
--



-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `url` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `ext` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52068 ;

--
-- Dumping data for table `notifications`
--



-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=245611 ;

--
-- Dumping data for table `online`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `body` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `author` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `private` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  `closed` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `cat` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=502 ;

--
-- Dumping data for table `photos`
--



--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `cat` tinyint(2) NOT NULL,
  `time` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `points` mediumint(9) NOT NULL,
  `visits` int(11) NOT NULL DEFAULT '0',
  `private` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `closed` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `sticky` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2295 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `post_visits`
--

CREATE TABLE IF NOT EXISTS `post_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('0','1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=163305 ;

--
-- Dumping data for table `post_visits`
--



-- --------------------------------------------------------

--
-- Table structure for table `p_categories`
--

CREATE TABLE IF NOT EXISTS `p_categories` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `p_categories`
--

INSERT INTO `p_categories` (`id`, `name`, `url`) VALUES
(1, 'Anime / Manga / Otros', 'anime-manga-otros'),
(2, 'Arte', 'arte'),
(3, 'Famosos', 'famosos'),
(4, 'Fotos', 'fotos'),
(5, 'Paisajes', 'paisajes'),
(6, 'Deportivas', 'deportivas'),
(7, 'Hazlo tu mismo', 'hazlo-tu-mismo'),
(8, 'Turismo', 'turismo'),
(9, 'Humor', 'humor');

-- --------------------------------------------------------

--
-- Table structure for table `p_comments`
--

CREATE TABLE IF NOT EXISTS `p_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  `positive` tinyint(4) NOT NULL,
  `negative` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=403 ;

--
-- Dumping data for table `p_comments`
--



--
-- Table structure for table `p_votes`
--

CREATE TABLE IF NOT EXISTS `p_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `photo` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=502 ;

--
-- Dumping data for table `p_votes`
--


-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci NOT NULL,
  `img` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `name`, `permissions`, `img`, `points`) VALUES
(1, 'Novato', 'add_points', 'turista.png', 50),
(2, 'New Full User', 'add_points', 'casero.png', 60),
(3, 'Full User', 'add_points', 'vecino.png', 70),
(4, 'Silver User', 'add_points', 'amigo.png', 80),
(5, 'Great User', 'add_points', 'familiar.png', 90),
(6, 'Gold User', 'add_points', 'casero.png', 100),
(7, 'Abastecedor', 'add_points', 'abastecedor.gif', 150),
(8, 'Moderador', 'complaints_posts;complaints_photos;complaints_users;delete_posts;delete_photos;show_userlist;ban;track_ip;show_mps;show_panel;delete_comments;add_points;editgroup;edittopic;deletereply;elimgroup;elimtopic', 'moderador.gif', 200),
(9, 'Administrador', 'complaints_posts;complaints_photos;complaints_users;delete_posts;delete_photos;show_userlist;ban;track_ip;censure;friend_sites;manage_news;stitches;edit_ranks;category_manage;show_mps;edit_user;show_panel;delete_comments;sticky;sponsor;add_points;show_contact;edit_settings;ban_ip;admin_help;editgroup;edittopic;deletereply;elimgroup;elimtopic', 'administrador.gif', 500),
(16, 'Beta Tester', 'add_points', 'beta.png', 50),
(19, 'Patrocinador', 'sticky;sponsor', 'patrocinado.png', 50),
(21, 'El gran pete', '', 'pete.gif', 1),
(22, 'Diseñador', 'delete_posts;delete_photos;add_points', 'disenador.png', 50),
(23, 'Miembro VIP', 'add_points', 'VIP.gif', 90),
(24, 'Roberto', 'complaints_posts;complaints_photos;complaints_users;delete_posts;delete_photos;show_userlist;ban;track_ip;censure;show_mps;show_panel;delete_comments;add_points;editgroup;edittopic;deletereply;elimgroup;elimtopic', 'robert.png', 60),
(25, 'Don Cirio', 'add_points', 'cirio.gif', 500),
(26, 'Jason Derulo', 'add_points', 'jason.png', 800),
(27, 'Moderador VIP', 'complaints_posts;complaints_photos;complaints_users;delete_posts;delete_photos;show_userlist;ban;track_ip;censure;category_manage;show_mps;edit_user;show_panel;delete_comments;add_points;show_contact;ban_ip;admin_help;editgroup;edittopic;deletereply;elimgroup;elimtopic', 'sirena.gif', 500),
(28, 'Mc Donalds', 'add_points', 'MAK-DONALS.jpg', 30),
(29, 'Jefe de diseño', 'delete_posts;delete_photos;add_points', 'paintbrush.png', 50);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `img`) VALUES
(1, 'Muy contento(a)', 'contento.gif'),
(2, 'Con sue&ntilde;o', 'con-sueno.gif'),
(3, 'Relajandome', 'coffe-break.gif'),
(4, 'Triste', 'triste.gif'),
(5, 'Enfermo(a)', 'enfermo.gif'),
(6, 'Escuchando m&uacute;sica', 'musica.gif'),
(7, 'Navegando en comunidad', 'favicon.gif'),
(8, 'En Facebook', 'facebook.gif'),
(9, 'Chateando', 'chateando.gif'),
(10, 'Pajeandome', 'paja.gif');

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`id`, `url`, `name`, `time`) VALUES
(26, 'http://proyectoouch.com.ar/', 'Proyecto!', 1342846492),
(17, 'http://zincomienzo.net', 'Zincomienzo', 1335737536),
(19, 'http://tnetwork.com.ar', 'T!Network', 1335991483),
(22, 'http://besodeletzel.activo.mx', 'Beso de Letztel', 1337205831),
(23, 'http://blog.moovax.net', 'El blog de Moovax!', 1339344679),
(24, 'http://mundohd.16mb.com', 'Mundo HD', 1339441238);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `act` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `ban` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `nick` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `rank` tinyint(2) NOT NULL,
  `password` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `lastip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `day` tinyint(2) NOT NULL,
  `month` tinyint(2) NOT NULL,
  `date` tinyint(11) NOT NULL,
  `year` int(4) NOT NULL,
  `time` int(11) NOT NULL,
  `sex` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `country` int(11) NOT NULL,
  `city` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `points2` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `message` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `firm` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `studies` enum('0','1','2','3','4','5','6','7','8','9','10') COLLATE utf8_unicode_ci NOT NULL,
  `profession` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `sector` tinyint(2) NOT NULL,
  `income` enum('0','1','2','3','4') COLLATE utf8_unicode_ci NOT NULL,
  `interests` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `skills` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `like` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `marital_status` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `children` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `live_with` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `height` int(3) NOT NULL,
  `weight` int(3) NOT NULL,
  `hair` enum('0','1','2','3','4','5','6','7','8','9','10') COLLATE utf8_unicode_ci NOT NULL,
  `eyes` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `physical` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `diet` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `smoke` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `drink_alcohol` enum('0','1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `my_interests` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `hobbies` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `favorite_series` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `favorite_music` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `favorite_sports` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `favorite_books` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `favorite_movies` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `favorite_food` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `my_heroes` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `numposts` int(11) NOT NULL,
  `show_info` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `walls_comments` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `friends_request` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `receive_pms` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL,
  `notifications` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0:1,1:1,2:1,3:1,4:1,5:1,6:1,7:1,8:1,9:1,10:1,11:1,12:1,13:1,14:1,15:1,16:1,17:1,18:1,19:1,20:1',
  `background` text COLLATE utf8_unicode_ci NOT NULL,
  `background_repeat` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `background_color` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1023 ;

--
-- Dumping data for table `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  `author` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4019 ;

--
-- Dumping data for table `votes`
--



-- --------------------------------------------------------

--
-- Table structure for table `walls`
--

CREATE TABLE IF NOT EXISTS `walls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `profile` int(11) NOT NULL,
  `body` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2174 ;

--
-- Dumping data for table `walls`
--


-- --------------------------------------------------------

--
-- Table structure for table `w_likes`
--

CREATE TABLE IF NOT EXISTS `w_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `what` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  `type` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1474 ;

--
-- Dumping data for table `w_likes`
--



-- --------------------------------------------------------

--
-- Table structure for table `w_replies`
--

CREATE TABLE IF NOT EXISTS `w_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `what` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `like` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1354 ;

--
-- Dumping data for table `w_replies`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

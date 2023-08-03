-- phpMyAdmin SQL Dump
-- version 3.4.10.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 17 2023 г., 01:18
-- Версия сервера: 5.0.67
-- Версия PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `eventdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `adr_birth`
--

CREATE TABLE IF NOT EXISTS `adr_birth` (
  `id` int(11) NOT NULL auto_increment,
  `id_place` int(11) NOT NULL,
  `country` varchar(255) NOT NULL COMMENT 'Страна',
  `region` varchar(255) default NULL COMMENT 'Область',
  `address` varchar(255) default NULL COMMENT 'Адрес',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица мест рождений' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `adr_live`
--

CREATE TABLE IF NOT EXISTS `adr_live` (
  `id` int(11) NOT NULL auto_increment,
  `id_place` int(11) NOT NULL,
  `country` varchar(255) NOT NULL COMMENT 'Страна',
  `region` varchar(255) default NULL COMMENT 'Область',
  `area` varchar(255) default NULL COMMENT 'Район',
  `locality` varchar(255) default NULL COMMENT 'Населенный пункт',
  `street` varchar(255) default NULL COMMENT 'Улица',
  `house` varchar(255) default NULL COMMENT 'Дом',
  `frame` varchar(255) default NULL COMMENT 'Корпус',
  `apartment` varchar(255) default NULL COMMENT 'Квартира',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица мест жительства' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `adr_other`
--

CREATE TABLE IF NOT EXISTS `adr_other` (
  `id` int(11) NOT NULL auto_increment,
  `id_place` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL COMMENT 'Описание',
  `country` varchar(255) NOT NULL COMMENT 'Страна',
  `region` varchar(255) default NULL COMMENT 'Область',
  `area` varchar(255) default NULL COMMENT 'Район',
  `locality` varchar(255) default NULL COMMENT 'Населенный пункт',
  `street` varchar(255) default NULL COMMENT 'Улица',
  `house` varchar(255) default NULL COMMENT 'Дом',
  `frame` varchar(255) default NULL COMMENT 'Корпус',
  `apartment` varchar(255) default NULL COMMENT 'Квартира',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица прочих мест' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `adr_work`
--

CREATE TABLE IF NOT EXISTS `adr_work` (
  `id` int(11) NOT NULL auto_increment,
  `id_place` int(11) NOT NULL,
  `entity` varchar(255) default NULL COMMENT 'Юридическое лицо',
  `division` varchar(255) default NULL COMMENT 'Дивизион',
  `filial` varchar(255) default NULL COMMENT 'Филиал',
  `repr` varchar(255) default NULL COMMENT 'Представительство',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица мест работы' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `change_event`
--

CREATE TABLE IF NOT EXISTS `change_event` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(255) NOT NULL,
  `id_record` int(11) NOT NULL,
  `time_change` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `edit_from` text NOT NULL,
  `edit_to` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица изменений событий' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `change_person`
--

CREATE TABLE IF NOT EXISTS `change_person` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(255) NOT NULL,
  `id_record` int(11) NOT NULL,
  `time_change` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `edit_from` text NOT NULL,
  `edit_to` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Таблица изменений описаний лиц' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `id_division` tinyint(4) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `id_entity` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id_division`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица дивизионов' AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `division`
--

INSERT INTO `division` (`id_division`, `name`, `id_entity`) VALUES
(1, 'Московский', 1),
(2, 'Приволжский', 1),
(3, 'Северный', 1),
(4, 'Сибирский', 1),
(5, 'Уральский', 1),
(6, 'Южный', 1),
(7, 'Штаб-квартира', 1),
(8, 'Все дивизионы', 2),
(10, 'Казахстан', 1),
(9, 'Беларусь', 1),
(11, 'Калининград', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `entity`
--

CREATE TABLE IF NOT EXISTS `entity` (
  `id_entity` tinyint(11) NOT NULL auto_increment COMMENT 'ID Юр.лица',
  `name` varchar(255) NOT NULL COMMENT 'Юридическое лицо',
  PRIMARY KEY  (`id_entity`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица юридических лиц' AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `entity`
--

INSERT INTO `entity` (`id_entity`, `name`) VALUES
(1, 'ООО "ТБМ"'),
(2, 'АО "ТБМ"');

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(100) NOT NULL auto_increment COMMENT 'ID',
  `date_incedent` datetime NOT NULL COMMENT 'Дата события',
  `author` varchar(100) character set cp1251 NOT NULL COMMENT 'Автор',
  `change_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'Дата изменения',
  `entity` varchar(100) character set cp1251 NOT NULL default '-' COMMENT 'Юридическое лицо',
  `division` varchar(100) character set cp1251 NOT NULL default '-' COMMENT 'Дивизион',
  `filial` varchar(100) character set cp1251 NOT NULL default '-' COMMENT 'Филиал',
  `repr` varchar(100) character set cp1251 NOT NULL default '-' COMMENT 'Представительство',
  `desc` text character set cp1251 NOT NULL COMMENT 'Описание',
  `type` varchar(100) character set cp1251 NOT NULL COMMENT 'Вид события',
  `way` varchar(100) character set cp1251 NOT NULL COMMENT 'Способ проникновения',
  `instr` varchar(100) character set cp1251 NOT NULL COMMENT 'Средство совершения',
  `relation` varchar(100) character set cp1251 NOT NULL COMMENT 'В отношении',
  `object` varchar(100) character set cp1251 NOT NULL COMMENT 'Предмет посягательства',
  `place` varchar(100) character set cp1251 NOT NULL COMMENT 'Место',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица событий' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `file_event`
--

CREATE TABLE IF NOT EXISTS `file_event` (
  `id` int(11) NOT NULL auto_increment,
  `id_event` int(11) NOT NULL,
  `file` varchar(500) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица файлов событий' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `file_person`
--

CREATE TABLE IF NOT EXISTS `file_person` (
  `id` int(11) NOT NULL auto_increment,
  `id_person` int(11) NOT NULL,
  `file` varchar(500) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица файлов лиц' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `filial`
--

CREATE TABLE IF NOT EXISTS `filial` (
  `id_filial` tinyint(4) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `id_division` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id_filial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица филиалов' AUTO_INCREMENT=91 ;

--
-- Дамп данных таблицы `filial`
--

INSERT INTO `filial` (`id_filial`, `name`, `id_division`) VALUES
(1, 'Логистический комплекс', 7),
(2, 'Самара', 2),
(3, 'Санкт-Петербург', 3),
(4, 'Новосибирск', 4),
(81, 'Все филиалы', 9),
(82, 'Астана', 10),
(83, 'Алматы', 10),
(84, 'Актобе', 10),
(85, 'Костанай', 10),
(86, 'Павлодар', 10),
(87, 'Петропаловск', 10),
(88, 'Уральск', 10),
(89, 'Усть-Каменогорск', 10),
(90, 'Ташкент', 11),
(52, 'Сургут', 5),
(11, 'Обособленное подразделение д.Юрово', 8),
(67, 'Обособленное подразделение г.Ермолино', 8),
(68, 'Обособленное подразделение г.Слободской', 8),
(71, 'Москва', 1),
(72, 'Москва-Регионы', 1),
(27, 'Киров', 1),
(22, 'Воронеж', 1),
(39, 'Нижний Новгород', 1),
(64, 'Ярославль', 1),
(29, 'Красноярск', 4),
(40, 'Новокузнецк', 4),
(16, 'Барнаул', 4),
(24, 'Иркутск', 4),
(59, 'Хабаровск', 4),
(18, 'Благовещенск', 4),
(20, 'Владивосток', 4),
(48, 'Саратов', 2),
(42, 'Оренбург', 2),
(44, 'Пенза', 2),
(58, 'Уфа', 2),
(57, 'Ульяновск', 2),
(25, 'Казань', 2),
(37, 'Набережные Челны', 2),
(14, 'Архангельск', 3),
(36, 'Мурманск', 3),
(73, 'Екатеринбург', 5),
(41, 'Омск', 5),
(45, 'Пермь', 5),
(55, 'Тюмень', 5),
(60, 'Челябинск', 5),
(21, 'Владикавказ', 6),
(74, 'Волгоград', 6),
(75, 'Краснодар', 6),
(35, 'Махачкала', 6),
(76, 'Пятигорск', 6),
(77, 'Ростов-на-Дону', 6),
(50, 'Сочи', 6),
(51, 'Ставрополь', 6),
(49, 'Симферополь', 6),
(15, 'Астрахань', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `img_person`
--

CREATE TABLE IF NOT EXISTS `img_person` (
  `id_person` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_person`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица изображений лиц';

-- --------------------------------------------------------

--
-- Структура таблицы `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `id` int(11) NOT NULL auto_increment,
  `author_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `short_desc` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `add_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `checked` tinyint(1) NOT NULL default '0',
  `correct` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица информации' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `logging`
--

CREATE TABLE IF NOT EXISTS `logging` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `log_event` varchar(255) NOT NULL,
  `log_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Логирование действий' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `logging_user`
--

CREATE TABLE IF NOT EXISTS `logging_user` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица логирования входа/выхода' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL auto_increment,
  `add_at` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT 'Добавлено:',
  `fio` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `second_name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `sex` varchar(1) NOT NULL,
  `birthday` date NOT NULL,
  `id_related` int(11) default NULL,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица лиц' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `id` int(11) NOT NULL auto_increment,
  `id_event` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `role_desc` varchar(255) default NULL,
  `id_person` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица отношений' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `represent`
--

CREATE TABLE IF NOT EXISTS `represent` (
  `id_rep` tinyint(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_filial` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id_rep`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица представительств';

--
-- Дамп данных таблицы `represent`
--

INSERT INTO `represent` (`id_rep`, `name`, `id_filial`) VALUES
(3, 'Представительство г.Гуанчжоу', 1),
(4, 'Региональное представительство г. Подольск', 71),
(5, 'Региональное представительство г. Брянск', 72),
(6, 'Региональное представительство г. Владимир', 72),
(7, 'Региональное представительство г. Калуга', 72),
(8, 'Региональное представительство г. Рязань', 72),
(9, 'Региональное представительство г. Смоленск', 72),
(10, 'Региональное представительство г. Тверь', 72),
(11, 'Региональное представительство г. Тула', 72),
(12, 'Региональное представительство г. Сыктывкар', 27),
(13, 'Региональное представительство г. Белгород', 22),
(14, 'Региональное представительство г. Курск', 22),
(15, 'Региональное представительство г. Липецк', 22),
(16, 'Региональное представительство г. Тамбов', 22),
(17, 'Региональное представительство г. Рыбинск', 64),
(18, 'Региональное представительство г. Череповец', 64),
(19, 'Региональное представительство г. Томск', 4),
(20, 'Региональное представительство г. Кемерово', 4),
(21, 'Региональное представительство г. Абакан', 29),
(22, 'Региональное представительство г. Братск', 24),
(23, 'Региональное представительство г. Улан-Удэ', 24),
(24, 'Региональное представительство г. Чита', 24),
(25, 'Региональное представительство г. Комсомольск-на-Амуре', 59),
(26, 'Региональное представительство г. Южно-Сахалинск', 59),
(27, 'Региональное представительство г. Якутск', 18),
(28, 'Региональное представительство г. Петропавловск-Камчатский', 20),
(29, 'Региональное представительство г. Тольятти', 2),
(30, 'Региональное представительство г. Балаково', 48),
(31, 'Региональное представительство г. Орск', 42),
(32, 'Региональное представительство г. Саранск', 44),
(33, 'Региональное представительство г. Октябрьский', 58),
(34, 'Региональное представительство г. Стерлитамак', 58),
(35, 'Региональное представительство г. Димитровград', 57),
(36, 'Региональное представительство г. Чебоксары', 25),
(37, 'Региональное представительство г. Ижевск', 37),
(38, 'Региональное представительство г. Нижневартовск', 52),
(39, 'Региональное представительство г. Курган', 60),
(40, 'Региональное представительство г. Магнитогорск', 60),
(41, 'Региональное представительство г. Миасс', 60),
(42, 'Региональное представительство г. Элиста', 74),
(43, 'Региональное представительство г. Анапа', 75),
(44, 'Региональное представительство г. Краснодар', 75),
(45, 'Региональное представительство г. Нальчик', 76),
(46, 'Региональное представительство г. Черкесск', 76),
(47, 'Региональное представительство Чеченская Республика', 76),
(48, 'Региональное представительство г. Таганрог', 77),
(55, 'Региональное представительство г. Брест', 81),
(56, 'Региональное представительство г. Витебск', 81),
(57, 'Региональное представительство г. Гомель', 81),
(58, 'Региональное представительство г. Гродно', 81),
(59, 'Региональное представительство г. Могилев', 81),
(60, 'Региональное представительство г. Караганды', 82),
(61, 'Региональное представительство г. Шымкент', 83),
(62, 'Региональное представительство г. Атырау', 88),
(63, 'Региональное представительство г. Андижан', 90),
(64, 'Региональное представительство г. Наманган', 90),
(2, 'Обособленное подразделение д.Юрово', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `admin` tinyint(4) NOT NULL,
  `username` varchar(255) character set utf8 NOT NULL,
  `fio` varchar(255) character set utf8 NOT NULL,
  `email` varchar(255) character set utf8 NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

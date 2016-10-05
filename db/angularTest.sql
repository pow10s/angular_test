-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 05 2016 г., 07:07
-- Версия сервера: 5.7.11
-- Версия PHP: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `angularTest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL COMMENT 'question id',
  `title` varchar(100) DEFAULT NULL COMMENT 'question title',
  `text` longtext COMMENT 'question description',
  `votes` int(11) DEFAULT '0' COMMENT 'count votes',
  `answers` int(11) DEFAULT '0' COMMENT 'count answers',
  `view` int(11) DEFAULT '0' COMMENT 'count views',
  `tags` varchar(100) DEFAULT NULL COMMENT 'question tags',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `title`, `text`, `votes`, `answers`, `view`, `tags`, `created_at`) VALUES
(2, 'test link2', 'dasdasdasdasdasd2', 12, 22, 32, 'tes2t', '2016-09-26 04:16:00'),
(4, 'test link1', 'dasdasdasdasdasd2', 12, 22, 32, 'tes2t', '2016-09-01 04:36:00'),
(6, 'dasdas', 'asdasdasd', 1, 1, 1, 'dsds', '2016-10-03 05:55:00'),
(7, 'dasdasd', 'dsadasdasd', 1, 2, 3, 'dasdas', '2016-10-02 21:32:00'),
(9, 'test link1', 'dasdasdasdasdasd2', 12, 22, 32, 'tes2t', '2016-10-02 04:36:00'),
(10, 'dasdasd', 'dsadasdasd', 1, 2, 3, 'dasdas', '2016-10-02 21:32:00'),
(11, 'test link1', 'dasdasdasdasdasd2', 12, 22, 32, 'tes2t', '2016-09-03 23:20:00'),
(114, 'dasdasdaasdasdasdas', 'dasdasdaasdasdasdas', 0, 0, 0, 'dasdasda', '2016-10-04 21:46:08'),
(115, 'dasdasdasdasd', 'questionForm', 0, 0, 0, 'que', '2016-10-04 22:47:08'),
(116, 'dasdasdasd', 'dasdasdasd', 0, 0, 0, 'dsa', '2016-10-04 23:47:22'),
(117, 'adsadasdasdasdsa', 'adsadasdasdasdsa', 0, 0, 0, 'dsadsa', '2016-10-05 01:18:55'),
(118, 'asdasdasdasd', 'asdasdasdasd', 0, 0, 0, 'dsad', '2016-10-05 02:10:48'),
(119, 'dsadasdasdasdasd', 'dsadasdasdasdasd', 0, 0, 0, 'dsad', '2016-10-05 02:31:54'),
(120, '1234567891', '1234567891', 0, 0, 0, 'das', '2016-10-05 03:44:35'),
(121, '12345678910', '12345678910', 0, 0, 0, '123', '2016-10-05 05:54:51'),
(122, '312312312312', '312312312312', 0, 0, 0, '3123123123', '2016-10-05 07:02:16'),
(123, 'dasdasdasdasdasdas', 'dasdasdasdasdasdas', 0, 0, 0, '123', '2016-10-05 07:03:09');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'question id',AUTO_INCREMENT=124;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 07 2024 г., 22:41
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `reforbo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `lecture`
--

CREATE TABLE `lecture` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `file` tinyint(1) NOT NULL DEFAULT 0,
  `id_them` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `lecture`
--

INSERT INTO `lecture` (`id`, `name`, `text`, `file`, `id_them`) VALUES
(32, 'простые числа', './thems/Slozhenie/06042024Задание Хакатона.docx', 1, 28),
(42, 'простые числа', './thems/Slozhenie/1712492535Задание Хакатона.docx', 1, 28),
(43, '', './thems/Fotosintez/17125184911 Практика леттеринг.pdf', 1, 35),
(44, 'Фотосинтез у хвойных', './thems/Fotosintez/1712521299Задание Хакатона.docx', 1, 35);

-- --------------------------------------------------------

--
-- Структура таблицы `object`
--

CREATE TABLE `object` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `object`
--

INSERT INTO `object` (`id`, `name`) VALUES
(29, 'Математика'),
(33, 'Биология');

-- --------------------------------------------------------

--
-- Структура таблицы `them`
--

CREATE TABLE `them` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `id_object` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `them`
--

INSERT INTO `them` (`id`, `name`, `id_object`) VALUES
(28, 'Сложение', 29),
(35, 'Фотосинтез', 33);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `password_hash` text NOT NULL,
  `login` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `password_hash`, `login`) VALUES
(11, 'Вадим', '05039911', '$2y$10$075HkcoUIMWLfCcTS1CS4uPcGuJ9b/WzYSc8cj0KZAYugwMihUZl2', 'Xicocer');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `lecture`
--
ALTER TABLE `lecture`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_them` (`id_them`);

--
-- Индексы таблицы `object`
--
ALTER TABLE `object`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `them`
--
ALTER TABLE `them`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_object` (`id_object`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `lecture`
--
ALTER TABLE `lecture`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `object`
--
ALTER TABLE `object`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `them`
--
ALTER TABLE `them`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_ibfk_1` FOREIGN KEY (`id_them`) REFERENCES `them` (`id`);

--
-- Ограничения внешнего ключа таблицы `them`
--
ALTER TABLE `them`
  ADD CONSTRAINT `them_ibfk_1` FOREIGN KEY (`id_object`) REFERENCES `object` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

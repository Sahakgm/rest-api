-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 02 2018 г., 10:17
-- Версия сервера: 10.1.26-MariaDB
-- Версия PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `slimdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `img` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `u_id`, `img`) VALUES
(1, 4, '2d4f3f792953bc37.jpg'),
(2, 3, '51743cb621daa23b.jpg'),
(3, 15, '631e811ab246461b.jpg'),
(4, 15, 'N2FjYTIzYzczODY5MGU4OS5qcGc=');

-- --------------------------------------------------------

--
-- Структура таблицы `s_users`
--

CREATE TABLE `s_users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `user_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `s_users`
--

INSERT INTO `s_users` (`id`, `name`, `surname`, `password`, `user_status`) VALUES
(1, 'S', 'G', '123', 1),
(2, 'Sahakg', 'G', '111', 1),
(3, 'Jon', 'J', '222', 1),
(4, 'Sahak', 'G', '111', 0),
(5, 'Joni', 'J', '222', 1),
(6, 'Name', 'Surname', '333', 1),
(7, 'Лариса', 'Федорова ', '555', 1),
(8, 'Лариса', 'Федорова ', '555', 1),
(9, 'Ксения', 'Новикова ', '666', 1),
(10, 'AA', 'BBB', '$2y$10$t5XOzfUpUWoJFlrDplxOS.7SSHIsHnSCl4j/pYtM9kg2GCAs8dkUe', 0),
(11, 'firstname', 'firstsurname', 'firstpassword', 1),
(12, 'Lora', 'LEON', '$2y$10$gQfGM79rDzXy1S/E6qeuBOKNr0EF6VNjL9gL7dh2fquSNbPBjAVYC', 1),
(13, 'Lora', 'LEON', '$2y$10$qZlpfxPGyBctG2fIsYR0b.c2B8EjiU1WDNWSt6tLb5C.RBTsxYb3C', 1),
(14, 'Lora2', 'LEON2', '$2y$10$IFaHYtzkkTlIImSoVe6LC.e5sU2qPfHR8MH8FMeq023Gu5lrtVygS', 1),
(15, 'sg', 'sgsg', '$2y$10$GcHeqFELnUUVx9UQT/iuTOMRMjM/0LtNvv0.7sxyTOtv5ci28feO6', 0),
(16, 'sg', 'VIVIN', '$2y$10$.bMjKuQ3pntP7grIrpqaBOjBuk4cNMat8YlaJxCH0ONWBc4mXUewu', 0),
(17, 'sg', 'niv', '$2y$10$a22MxuaROx/yYC8zT08q4O.Kp8at3wiBO4IEnxLqAzPZv2OZMJwaC', 0),
(18, 'win', 'niv', '$2y$10$ruImjOcaTaNJx9khlVlmXuir2JjqhvpYVFesoM2v5mEhrciQzJgeC', 0),
(19, 'Sahak', 'Ginovyan', '$2y$10$/Vg9B2nvMNcBEYlm0USSQ.5dMiYrq/eDDA4S2wsN61P/XYpwRinL.', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`);

--
-- Индексы таблицы `s_users`
--
ALTER TABLE `s_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `s_users`
--
ALTER TABLE `s_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `s_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

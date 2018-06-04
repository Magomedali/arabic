-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 04 2018 г., 23:40
-- Версия сервера: 5.5.54
-- Версия PHP: 7.0.16RC1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `arabic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`, `updated_at`) VALUES
('superadmin', '1', 1527324437, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('administrator', 1, 'Администратор - данная роль предоставляет максимально расширенные права которые позволяют выполнять конфигурирование системы, управление правами других пользователей и другие функции администрировния', NULL, NULL, 1527324437, 1527324437),
('superadmin', 1, 'Супер админ', NULL, NULL, 1527324437, 1527324437);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `block`
--

CREATE TABLE `block` (
  `id` int(11) NOT NULL,
  `lesson` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `isPublic` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `block`
--

INSERT INTO `block` (`id`, `lesson`, `position`, `isPublic`) VALUES
(8, 1, 1, 1),
(9, 1, 2, 0),
(10, 1, 3, 0),
(11, 1, 4, 0),
(12, 1, 5, 0),
(13, 1, 6, 0),
(14, 1, 7, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `element`
--

CREATE TABLE `element` (
  `id` int(11) NOT NULL,
  `block` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL,
  `isPublic` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `element`
--

INSERT INTO `element` (`id`, `block`, `type`, `content`, `file_name`, `position`, `isPublic`) VALUES
(1, 8, 1, '<p>Алиф (араб. ﺍ‎ — ’алиф) — первая буква арабского алфавита. Используется для обозначения длинного звука /aː/ или (реже) гортанной смычки.</p><p>Стоящая отдельно или в начале слова — ﺍ; в середине или в конце — ﺎ.</p><p>Филолог арабского языка Халиль ибн Ахмад пишет: «Звуков в арабском языке 29. 25 из них правильные, так как имеют фиксированные места образования и определённые преграды (в речевом аппарате, о которые ударяется голос), а 4 — полостные:</p><p>الواو — уау, الياء — йа, الألف اللينة — мягкая алиф, الهمزة — хамза (гортанная смычка).</p><p>Их назвали полостными (الجوفية), так как у голоса, выходящего из лёгких, нет преград (в речевом аппарате) ни в горле, ни в язычке, ни в языке. Звук состоит только из голоса, и у этих звуков нет определённого места образования»</p>', NULL, 1, 1),
(3, 8, 3, '', '5b158f6183f80_1528139617.png', 1, 1),
(4, 8, 2, '', '5b158f82c7582_1528139650.m4a', 3, 1),
(5, 9, 1, '<p>Буква «ба» обозначает звонкий губно-губной взрывной согласный [b]. Особенно выразительно, он произносится, если над ним стоит знак беззвучности «сукун», так как «ба» — одна из букв калькаля</p>', NULL, 1, 1),
(6, 9, 3, '', '5b159e39652fc_1528143417.png', 2, 1),
(7, 9, 2, '', '5b159e51d93bf_1528143441.m4a', 1, 1),
(8, 10, 1, '<p>«Буква ﺕ обозначает средний согласный звук [t], представляющий собой глухую параллель арабского звонкого (д).</p><p>Эти точки располагаются рядом по горизонтали; в скорописи они часто „сливаются“ и заменяются коротеньким горизонтальным штрихом»</p>', NULL, 1, 1),
(9, 10, 3, '', '5b15a077bdd74_1528143991.png', 1, 1),
(10, 10, 2, '', '5b15a08f2078e_1528144015.m4a', 1, 1),
(11, 11, 1, '<p>В отличие (Т) -мягкой, арабская буква (Са)-межзубная — обладает тремя пирамидальными точками над своим каркасом.</p><p>«Точки ставятся „пирамидкой“, но в скорописи их иногда заменяют маленьким „уголком“ вершиной кверху».</p><p>Звук, обозначаемый буквой, произносится с кончиком языка между зубами.</p>', NULL, 1, 1),
(12, 11, 3, '', '5b15a162c9191_1528144226.png', 1, 1),
(13, 11, 2, '', '5b15a170da22c_1528144240.m4a', 1, 1),
(14, 12, 1, '<p>Буква «джим» обозначает средний согласный (дж), представляющий собой как бы слившееся в один нераздельный звук сочетание средних (д) и (ж)</p><p>переднеязычная звонкая аффриката. В нём элементы «д» и «ж» произносятся слитно, причём смычное начало «д» не кончается взрывом, а мгновенно переходит в щелевой, очень мягкий звук «ж»</p>', NULL, 1, 1),
(15, 12, 3, NULL, '5b15a1de7ea11_1528144350.png', 1, 1),
(16, 12, 2, NULL, '5b15a1ecb308c_1528144364.m4a', 1, 1),
(17, 13, 1, '<p>Глухой звук «Ха» образуется, когда выдыхаемый воздух проходит через сузившуюся глотку, вследствие чего возникает специфический шум, производящий на слух впечатление шипения в полости глотки.</p><p>Согласный [x] является глубоко-задненебным шумным фрикативным глухим согласным звуком. Аналогичного звука в русском языке нет.</p>', NULL, 1, 1),
(18, 13, 3, NULL, '5b15a23a82ba1_1528144442.png', 1, 1),
(19, 13, 2, NULL, '5b15a247ca9ad_1528144455.m4a', 1, 1),
(20, 14, 1, '<p>Арабское [x] гораздо твёрже русского Х в таких случаях, как «хрип», «храп», «хрупкий».</p><p>При артикуляции звука [x] язык отодвигается назад к язычку, а задняя спинка языка поднимается к мягкому нёбу. Между задней спинкой языка и язычком образуется узкая щель, через которую выдувается воздух. Речевой аппарат при артикуляции звука [x] напряжен</p>', NULL, 1, 1),
(21, 14, 3, NULL, '5b15a299b7967_1528144537.png', 1, 1),
(22, 14, 2, NULL, '5b15a2b909693_1528144569.m4a', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `learning_process`
--

CREATE TABLE `learning_process` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `block_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `isPublic` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `lesson`
--

INSERT INTO `lesson` (`id`, `level`, `number`, `title`, `desc`, `isPublic`) VALUES
(1, 1, 1, 'Первый урок', NULL, 1),
(2, 1, 2, 'Второй урок', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `isPublic` tinyint(1) DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `level`
--

INSERT INTO `level` (`id`, `title`, `desc`, `isPublic`, `position`) VALUES
(1, 'Первый уровень', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1526881519),
('m130524_201442_init', 1527324437),
('m171208_115012_rbac', 1527324437),
('m171208_121331_auth', 1527324437),
('m180521_084651_learning', 1527324438);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `bdate` date DEFAULT NULL,
  `isDeleted` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `version_id` int(11) DEFAULT NULL,
  `last_action` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `sname`, `patronymic`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `email_token`, `email_confirmed`, `phone`, `phone_token`, `phone_confirmed`, `bdate`, `isDeleted`, `status`, `version_id`, `last_action`) VALUES
(1, 'admin', 'administrator', NULL, '2hAMuAtkHXTN5fRMU-Dyvh_zRMndN44p', '$2y$13$2RJTv8naHqLxtz73oLfBYuaMOriDDCpeeSCYz2bLnST6gFkG5KWIK', NULL, 'admin@admin.ru', NULL, 1, NULL, NULL, 0, NULL, 0, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_history`
--

CREATE TABLE `user_history` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `isDelete` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_action` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'created',
  `version` int(11) NOT NULL DEFAULT '1',
  `isDeleted` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `block_lesson_position_unique_index` (`position`,`lesson`),
  ADD KEY `fk-block-lesson` (`lesson`);

--
-- Индексы таблицы `element`
--
ALTER TABLE `element`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-element-block` (`block`);

--
-- Индексы таблицы `learning_process`
--
ALTER TABLE `learning_process`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-learning_process-user_id` (`user_id`),
  ADD KEY `fk-learning_process-block_id` (`block_id`),
  ADD KEY `fk-learning_process-lesson_id` (`lesson_id`);

--
-- Индексы таблицы `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson_number_unique_index` (`number`,`level`),
  ADD KEY `fk-lesson-level` (`level`);

--
-- Индексы таблицы `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level_position_unique_index` (`position`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk-user-version_id` (`version_id`),
  ADD KEY `fk-user-last_action` (`last_action`);

--
-- Индексы таблицы `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-user_history-entity_id` (`entity_id`),
  ADD KEY `fk-user_history-user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `block`
--
ALTER TABLE `block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `element`
--
ALTER TABLE `element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT для таблицы `learning_process`
--
ALTER TABLE `learning_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `fk-block-lesson` FOREIGN KEY (`lesson`) REFERENCES `lesson` (`id`);

--
-- Ограничения внешнего ключа таблицы `element`
--
ALTER TABLE `element`
  ADD CONSTRAINT `fk-element-block` FOREIGN KEY (`block`) REFERENCES `block` (`id`);

--
-- Ограничения внешнего ключа таблицы `learning_process`
--
ALTER TABLE `learning_process`
  ADD CONSTRAINT `fk-learning_process-block_id` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`),
  ADD CONSTRAINT `fk-learning_process-lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`),
  ADD CONSTRAINT `fk-learning_process-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `fk-lesson-level` FOREIGN KEY (`level`) REFERENCES `level` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk-user-last_action` FOREIGN KEY (`last_action`) REFERENCES `learning_process` (`id`),
  ADD CONSTRAINT `fk-user-version_id` FOREIGN KEY (`version_id`) REFERENCES `user_history` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `fk-user_history-entity_id` FOREIGN KEY (`entity_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk-user_history-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

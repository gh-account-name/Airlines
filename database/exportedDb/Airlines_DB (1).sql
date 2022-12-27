-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 27 2022 г., 06:16
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Airlines_DB`
--

-- --------------------------------------------------------

--
-- Структура таблицы `airplanes`
--

CREATE TABLE `airplanes` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_seats` int NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `airplanes`
--

INSERT INTO `airplanes` (`id`, `title`, `count_seats`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Rj-233', 23, 5000.00, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(2, 'LSA-366', 14, 15000.00, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(5, 'KAI-663', 12, 14599.59, '2022-12-21 04:06:34', '2022-12-25 10:52:46');

-- --------------------------------------------------------

--
-- Структура таблицы `airports`
--

CREATE TABLE `airports` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `airports`
--

INSERT INTO `airports` (`id`, `title`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'Московский аэропорт', 1, '2022-12-22 01:55:00', '2022-12-25 10:52:16'),
(2, 'Аэропорт Пулково', 2, '2022-12-22 01:56:00', '2022-12-22 01:56:00'),
(3, 'Международный аэропорт Внуково', 1, '2022-12-22 01:57:07', '2022-12-22 01:57:07'),
(4, 'Аэропорт Сочи (Адлер)', 3, '2022-12-22 01:58:58', '2022-12-22 01:58:58'),
(7, 'Аэропорт имени В. П. Чкалова', 17, '2022-12-26 01:09:24', '2022-12-26 01:09:24'),
(8, 'Международный аэропорт Красноярск', 16, '2022-12-26 01:10:14', '2022-12-26 01:10:14');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `title`, `img`, `created_at`, `updated_at`) VALUES
(1, 'Москва', '/storage/img/FVTF9VKqTmbQ0Ek9cXFuZzqrw4ul6TEfge2o3WlE.jpg', '2022-12-20 04:33:23', '2022-12-20 04:33:23'),
(2, 'Санкт-Петербург', '/storage/img/fMtLmtJnOcFlUgYMfeEpCtOx9jlFbf0E7H092P55.jpg', '2022-12-20 05:00:28', '2022-12-20 05:00:28'),
(3, 'Сочи', '/storage/img/4iWHLlFzVYgmdkz35RxPPNUWNVjWlajXczl0y8Et.jpg', '2022-12-20 05:05:51', '2022-12-20 05:05:51'),
(16, 'Красноярск', '/storage/img/X9Zn4TBXXbytZDRsr0u7m546wlmBcofve5MGh0oF.jpg', '2022-12-26 00:54:30', '2022-12-26 00:54:30'),
(17, 'Нижний Новгород', '/storage/img/YWtQlGtb8gKdh6XUdymlSFKaAUYFboMk8KKWRup4.jpg', '2022-12-26 01:01:37', '2022-12-26 01:01:37');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `id` bigint UNSIGNED NOT NULL,
  `from_city_id` bigint UNSIGNED NOT NULL,
  `to_city_id` bigint UNSIGNED NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `timeFrom` time NOT NULL,
  `timeTo` time NOT NULL,
  `timeWay` time NOT NULL,
  `percentPrice` double(8,2) NOT NULL,
  `airplane_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'готов',
  `from_airport_id` bigint UNSIGNED NOT NULL,
  `to_airport_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `flights`
--

INSERT INTO `flights` (`id`, `from_city_id`, `to_city_id`, `dateFrom`, `dateTo`, `timeFrom`, `timeTo`, `timeWay`, `percentPrice`, `airplane_id`, `status`, `from_airport_id`, `to_airport_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2022-12-22', '2022-12-22', '12:00:00', '20:10:00', '08:10:00', 15.00, 1, 'готов', 1, 4, '2022-12-22 04:52:16', '2022-12-26 05:46:08'),
(6, 1, 2, '2022-12-22', '2022-12-22', '13:00:00', '14:30:00', '01:30:00', 12.00, 1, 'готов', 1, 2, '2022-12-22 07:53:05', '2022-12-22 07:53:05'),
(7, 2, 1, '2022-12-22', '2022-12-22', '14:15:00', '18:20:00', '04:10:00', 10.00, 2, 'готов', 2, 3, '2022-12-22 08:16:07', '2022-12-22 08:16:07'),
(9, 3, 2, '2022-12-23', '2022-12-24', '22:30:00', '05:50:00', '07:20:00', 20.00, 2, 'в полете', 4, 2, '2022-12-22 23:41:20', '2022-12-25 09:59:17'),
(10, 3, 1, '2022-12-02', '2022-12-02', '13:40:00', '18:30:00', '04:50:00', 13.00, 1, 'готов', 4, 1, '2022-12-23 05:39:31', '2022-12-25 10:27:15'),
(11, 1, 2, '2022-01-12', '2023-01-13', '10:40:00', '13:50:00', '03:10:00', 25.00, 5, 'готов', 3, 2, '2022-12-23 05:45:05', '2022-12-25 10:53:28'),
(13, 2, 3, '2023-02-17', '2023-02-17', '13:50:00', '16:20:00', '02:30:00', 17.00, 2, 'готов', 2, 4, '2022-12-23 07:51:24', '2022-12-23 07:51:24'),
(14, 3, 1, '2022-12-23', '2022-12-23', '13:53:00', '15:00:00', '01:07:00', 66.00, 5, 'готов', 4, 3, '2022-12-23 07:53:20', '2022-12-23 07:59:20'),
(15, 16, 1, '2022-12-26', '2022-12-26', '08:20:00', '18:10:00', '09:50:00', 5.00, 1, 'готов', 8, 1, '2022-12-26 01:11:03', '2022-12-26 01:11:03'),
(16, 2, 17, '2022-12-26', '2022-12-26', '08:30:00', '15:00:00', '06:30:00', 8.00, 2, 'готов', 2, 7, '2022-12-26 01:12:21', '2022-12-26 01:12:21');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2022_12_16_122434_create_cities_table', 1),
(16, '2022_12_16_122752_create_airplanes_table', 1),
(17, '2022_12_16_122836_create_seats_table', 1),
(18, '2022_12_16_123022_create_airports_table', 1),
(19, '2022_12_16_123137_create_flights_table', 1),
(21, '2022_12_16_123223_create_tickets_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `seats`
--

CREATE TABLE `seats` (
  `id` bigint UNSIGNED NOT NULL,
  `airplane_id` bigint UNSIGNED NOT NULL,
  `seat` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `seats`
--

INSERT INTO `seats` (`id`, `airplane_id`, `seat`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(2, 1, 2, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(3, 1, 3, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(4, 1, 4, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(5, 1, 5, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(6, 1, 6, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(7, 1, 7, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(8, 1, 8, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(9, 1, 9, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(10, 1, 10, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(11, 1, 11, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(12, 1, 12, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(13, 1, 13, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(14, 1, 14, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(15, 1, 15, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(16, 1, 16, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(17, 1, 17, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(18, 1, 18, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(19, 1, 19, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(20, 1, 20, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(21, 1, 21, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(22, 1, 22, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(23, 1, 23, '2022-12-21 03:19:30', '2022-12-21 03:19:30'),
(24, 2, 1, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(25, 2, 2, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(26, 2, 3, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(27, 2, 4, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(28, 2, 5, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(29, 2, 6, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(30, 2, 7, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(31, 2, 8, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(32, 2, 9, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(33, 2, 10, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(34, 2, 11, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(35, 2, 12, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(36, 2, 13, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(37, 2, 14, '2022-12-21 03:21:36', '2022-12-21 03:21:36'),
(146, 5, 1, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(147, 5, 2, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(148, 5, 3, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(149, 5, 4, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(150, 5, 5, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(151, 5, 6, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(152, 5, 7, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(153, 5, 8, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(154, 5, 9, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(155, 5, 10, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(156, 5, 11, '2022-12-25 10:52:46', '2022-12-25 10:52:46'),
(157, 5, 12, '2022-12-25 10:52:46', '2022-12-25 10:52:46');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate` int DEFAULT NULL,
  `flight_id` bigint UNSIGNED NOT NULL,
  `seat` int NOT NULL,
  `price` double(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'оформлен',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `fio`, `birthday`, `passport`, `certificate`, `flight_id`, `seat`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Иван Иванович', '2007-02-09', '23423423423', NULL, 1, 6, 5750.00, 'оформлен', '2022-12-25 08:13:03', '2022-12-26 05:45:40'),
(4, 1, 'Иван Иванович', '2007-01-16', '23423423423', NULL, 11, 11, 18249.49, 'оформлен', '2022-12-25 08:22:06', '2022-12-25 10:45:28'),
(5, 2, 'Владимир Викторович', '2016-06-09', NULL, 12323123, 9, 3, 18000.00, 'оформлен', '2022-12-25 09:02:10', '2022-12-25 09:02:10'),
(6, 2, 'Фёдор Васильевич', '1997-02-21', '234234234', NULL, 1, 20, 5750.00, 'оформлен', '2022-12-25 09:21:11', '2022-12-26 05:45:40'),
(7, 2, 'Василий Викторович', '2007-06-13', '12312312', NULL, 16, 1, 16200.00, 'оформлен', '2022-12-26 01:16:19', '2022-12-26 01:16:19'),
(10, 2, 'Пётр Викторович', '2019-02-13', '23123123', NULL, 14, 1, 24235.32, 'оформлен', '2022-12-26 06:21:31', '2022-12-26 06:21:31'),
(11, 2, 'Пётр Павлович', '2017-10-11', NULL, 12321123, 10, 2, 5650.00, 'оформлен', '2022-12-26 07:01:09', '2022-12-26 07:01:09'),
(12, 2, 'Виктор Викторович', '2022-12-15', '1231232', NULL, 10, 9, 5650.00, 'оформлен', '2022-12-26 07:02:10', '2022-12-26 07:02:10');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `fio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fio`, `birthday`, `passport`, `email`, `phone`, `login`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Иван Иванович', '2013-02-06', '12312312312', 'ivan@dss.sd', '89999999999', 'ivan', 'e10adc3949ba59abbe56e057f20f883e', 'user', NULL, '2022-12-20 00:13:32', '2022-12-25 10:51:02'),
(2, 'Виктор Викторович', '2000-06-16', '12312313212', 'viktor@sfss.sdfs', '89988999999', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', NULL, '2022-12-20 01:26:00', '2022-12-20 01:26:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `airplanes`
--
ALTER TABLE `airplanes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `airplanes_title_unique` (`title`);

--
-- Индексы таблицы `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `airports_title_unique` (`title`),
  ADD KEY `airports_city_id_foreign` (`city_id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_title_unique` (`title`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flights_from_city_id_foreign` (`from_city_id`),
  ADD KEY `flights_to_city_id_foreign` (`to_city_id`),
  ADD KEY `flights_airplane_id_foreign` (`airplane_id`),
  ADD KEY `flights_from_airport_id_foreign` (`from_airport_id`),
  ADD KEY `flights_to_airport_id_foreign` (`to_airport_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seats_airplane_id_foreign` (`airplane_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_flight_id_foreign` (`flight_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_passport_unique` (`passport`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_login_unique` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `airplanes`
--
ALTER TABLE `airplanes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `seats`
--
ALTER TABLE `seats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `airports`
--
ALTER TABLE `airports`
  ADD CONSTRAINT `airports_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_airplane_id_foreign` FOREIGN KEY (`airplane_id`) REFERENCES `airplanes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flights_from_airport_id_foreign` FOREIGN KEY (`from_airport_id`) REFERENCES `airports` (`id`),
  ADD CONSTRAINT `flights_from_city_id_foreign` FOREIGN KEY (`from_city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `flights_to_airport_id_foreign` FOREIGN KEY (`to_airport_id`) REFERENCES `airports` (`id`),
  ADD CONSTRAINT `flights_to_city_id_foreign` FOREIGN KEY (`to_city_id`) REFERENCES `cities` (`id`);

--
-- Ограничения внешнего ключа таблицы `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_airplane_id_foreign` FOREIGN KEY (`airplane_id`) REFERENCES `airplanes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

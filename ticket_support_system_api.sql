-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 11:48 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_support_system_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2014_10_12_000000_create_users_table', 1),
(22, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(25, '2023_03_26_210552_create_password_resets_table', 1),
(26, '2023_03_27_184418_create_ticket_table', 1),
(27, '2023_03_28_220747_create_jobs_table', 1),
(28, '2023_03_31_212152_create_priorities_table', 1),
(29, '2023_03_31_212210_create_statuses_table', 1),
(30, '2023_03_31_214049_create_permissions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignee_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `assignee_id`, `assignee_name`, `guid`, `token`, `ticket_id`, `created_at`, `updated_at`) VALUES
(6, 'What do you expect?', '2', 'bruh', '1ce8617e-51c0-438e-8bd2-2374767c9a99', '18|yuhKdyZry66CitQQNdcc0D76KS3ZZ5IfQbiGH1A2', 6, '2023-04-02 13:55:08', '2023-04-02 15:04:32'),
(7, 'What do you expect?', '4', 'bruh', 'd79b4896-39ea-42e8-b560-f29d0580e64c', '20|Ad6tWbTyQU6Nl9Bng5eQfJXx2pX6SeZphIPgkOB8', 7, '2023-04-02 13:58:29', '2023-04-02 15:09:18'),
(8, NULL, NULL, NULL, NULL, NULL, 8, '2023-04-02 13:58:48', '2023-04-02 13:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Ticket', 1, 'Highway to Nowhere', '6867201a821ea9bcfa2364ef75003f84a99cc0b24b68790f1c6639afa9c936c7', '[\"*\"]', NULL, NULL, '2023-04-02 13:53:34', '2023-04-02 13:53:34'),
(2, 'App\\Models\\Ticket', 2, 'Highway to Nowhere', '7238d04c18c07eec4e81f4863e365f9fc6f1be56c4ae878c00691f18232a4f4e', '[\"*\"]', NULL, NULL, '2023-04-02 13:53:35', '2023-04-02 13:53:35'),
(3, 'App\\Models\\Ticket', 3, 'Highway to Nowhere', '53a83fe72fc907a10482d8369267c4074c883007a9a4dc80e33e44409d6aee62', '[\"*\"]', NULL, NULL, '2023-04-02 13:53:37', '2023-04-02 13:53:37'),
(4, 'App\\Models\\Ticket', 4, 'Highway to Nowhere', '73e017a97e3f4ae3d0ce1c0fbadf70237256f8ba4cd8325f54c8d46d6212706c', '[\"*\"]', NULL, NULL, '2023-04-02 13:55:05', '2023-04-02 13:55:05'),
(5, 'App\\Models\\Ticket', 5, 'Highway to Nowhere', '422b1edd20f663c15c1d4adc98efd7a9ea0755ef1c9e3cdad59d8a7e320be15d', '[\"*\"]', NULL, NULL, '2023-04-02 13:55:07', '2023-04-02 13:55:07'),
(6, 'App\\Models\\Ticket', 6, 'Highway to Nowhere', '1617fca3c1b5930984042f2e987d05dbe2a3c928801dc103143e8c327a5ef7b0', '[\"*\"]', NULL, NULL, '2023-04-02 13:55:08', '2023-04-02 13:55:08'),
(7, 'App\\Models\\Ticket', 4, 'What the hell is that?', '5bcc5007803a446fa68bc4d8a37fa9dd2c6d1fe723b4d1ce582c9f65949036f8', '[\"*\"]', NULL, NULL, '2023-04-02 13:55:43', '2023-04-02 13:55:43'),
(8, 'App\\Models\\Ticket', 7, 'Highway to Nowhere', 'e7c8f01a38aafd24475b8c6f6fb590f65f5ec5d17793486a50a23d7f631900e4', '[\"*\"]', NULL, NULL, '2023-04-02 13:58:29', '2023-04-02 13:58:29'),
(9, 'App\\Models\\Ticket', 8, 'Highway to Nowhere', '3000cc4149a1bdc9c91c046a640af2e6fa915f1e94552f9ea02e42fc093dd0c6', '[\"*\"]', NULL, NULL, '2023-04-02 13:58:48', '2023-04-02 13:58:48'),
(10, 'App\\Models\\Ticket', 5, 'What the hell is that?', '8c7b003a7f890d81077d62ea4344a40f5f684cb086032d01ff338ee665cb41ad', '[\"*\"]', NULL, NULL, '2023-04-02 13:59:25', '2023-04-02 13:59:25'),
(11, 'App\\Models\\Status', 6, 'Open', '73b03bb65bbe6f7cad1d06ccaee785a0143c88aa5675e14b51e4f5742b078eb0', '[\"*\"]', NULL, NULL, '2023-04-02 14:01:04', '2023-04-02 14:01:04'),
(12, 'App\\Models\\Status', 6, 'Open', '921e559e1a7a1b10e6de02609cfedf1ea89fbea4b7c1bb43055807a151a28e99', '[\"*\"]', NULL, NULL, '2023-04-02 14:01:25', '2023-04-02 14:01:25'),
(14, 'App\\Models\\User', 1, 'authToken', '0d5ef221a2518463135c95746f77eb7e3295367b1b8420c75918da58ea394e5c', '[\"*\"]', NULL, NULL, '2023-04-02 14:58:49', '2023-04-02 14:58:49'),
(15, 'App\\Models\\User', 1, 'authToken', '4dfa42cd986caaa2a95f5199cf669fda9a7bd0988808533167b59b9bcabc3500', '[\"*\"]', NULL, NULL, '2023-04-02 15:01:53', '2023-04-02 15:01:53'),
(16, 'App\\Models\\Priority', 6, 'Very high', '2c003cf7b4c6325fc7c3cc9b5e5fb6dd5b4e73b23c20f3cb3b01a80aaea266d4', '[\"*\"]', NULL, NULL, '2023-04-02 15:04:15', '2023-04-02 15:04:15'),
(17, 'App\\Models\\permission', 6, 'What do you expect?', 'a4acbb92b99c732062f2a3c53d11754ae8d6692c66401cc897fd408af06a1150', '[\"*\"]', NULL, NULL, '2023-04-02 15:04:25', '2023-04-02 15:04:25'),
(18, 'App\\Models\\permission', 6, 'What do you expect?', 'ee9b2499ebc7bef4f0aa225a8886b9d19b6cad1ea60fe35ddd82d972295f9572', '[\"*\"]', NULL, NULL, '2023-04-02 15:04:32', '2023-04-02 15:04:32'),
(19, 'App\\Models\\permission', 7, 'What do you expect?', '2564013a8c8b72868c9224c5243637054b1827c9b5716fa9f84dc7e826ffbd84', '[\"*\"]', NULL, NULL, '2023-04-02 15:06:28', '2023-04-02 15:06:28'),
(20, 'App\\Models\\permission', 7, 'What do you expect?', '646a8f25635657297683f5e0293339425662f192799dcbafa53eb545058b25b6', '[\"*\"]', NULL, NULL, '2023-04-02 15:09:18', '2023-04-02 15:09:18'),
(21, 'App\\Models\\Status', 6, 'Close', 'c195a51291f29e0fb590a06c7019f71c6f41014d5cd78d83463172a0a6903f69', '[\"*\"]', NULL, NULL, '2023-04-02 15:11:23', '2023-04-02 15:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '----',
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignee_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `comment`, `priority`, `assignee_id`, `assignee_name`, `guid`, `token`, `ticket_id`, `created_at`, `updated_at`) VALUES
(6, 'This is bullshit', 'Very high', '1', 'Mg Mg', 'ae4db4dd-7ba3-44a0-a430-15fe9f782979', '16|T62J2HzXRuHgrDjPhty5OjgHrDaKTfJS2IKPGnMm', 6, '2023-04-02 13:55:08', '2023-04-02 15:04:15'),
(7, '----', NULL, NULL, NULL, NULL, NULL, 7, '2023-04-02 13:58:29', '2023-04-02 13:58:29'),
(8, '----', NULL, NULL, NULL, NULL, NULL, 8, '2023-04-02 13:58:48', '2023-04-02 13:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Open','Pending','Close') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `assignee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignee_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status`, `assignee_id`, `assignee_name`, `guid`, `token`, `ticket_id`, `created_at`, `updated_at`) VALUES
(6, 'Close', '1', 'Kaung Htet Kyaw', '3a3b21f5-f414-401a-bf97-b9b49105116b', '21|3ULX7D3xzbrIBfpztKqp3QAlgr7k6BwtNhsAYAkS', 6, '2023-04-02 13:55:08', '2023-04-02 15:11:23'),
(7, 'Pending', NULL, NULL, NULL, NULL, 7, '2023-04-02 13:58:29', '2023-04-02 13:58:29'),
(8, 'Pending', NULL, NULL, NULL, NULL, 8, '2023-04-02 13:58:48', '2023-04-02 13:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Open','Pending','Close') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `content`, `message`, `attachment_file`, `status`, `guid`, `token`, `created_at`, `updated_at`) VALUES
(6, 'Highway to Nowhere', 'This is a ticket for highway to nowhere', 'This is for good people to go to heaven', 'fL3DZx4pXcDylJK58hmPBOe3q5qK2D32.png', 'Close', '3a3b21f5-f414-401a-bf97-b9b49105116b', '6|Id2kZlBUb69TzMnorNP0fGvnvWOXO1l07emSPYH2', '2023-04-02 13:55:08', '2023-04-02 15:11:23'),
(7, 'Highway to Nowhere', 'This is a ticket for highway to nowhere', 'This is for good people to go to heaven', '4keG2AVEYgkLdAs4M7aV1awZly5AuCaK.png', 'Open', '0b4751df-3512-44ea-ad31-fca881215bbe', '8|DiP5P7Wxyz6jzsNvPHaPd98wmu9Zx3n1ElVuGikh', '2023-04-02 13:58:29', '2023-04-02 13:58:29'),
(8, 'Highway to Nowhere', 'This is a ticket for highway to nowhere', 'This is for good people to go to heaven', 'xC2V84O88UkG8QMF7OD3RcS7m9MNRWZO.png', 'Open', 'da27bb00-dbf5-44ac-a32d-63ecd72b792d', '9|CkqfSDARovnK0XvFuYBjl93Td6TJJFBfOaytvHIK', '2023-04-02 13:58:48', '2023-04-02 13:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tc` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `guid`, `remember_token`, `tc`, `created_at`, `updated_at`) VALUES
(1, 'Kaung Htet Kyaw', 'user', 'khk@gmail.com', NULL, '$2y$10$JDv5ipsubU9YhvaDrgVgiuicgG7lku6Wc6nFADXLeJlYFRlI49.96', '0ab2f2eb-f89d-4049-b8b2-eed6d04ce1e1', '13|MfDyFhf4Be74TQQrbVQoZMvTV2eFCiWHi1vSE2ml', 1, '2023-04-02 14:28:10', '2023-04-02 14:28:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `priorities_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statuses_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `priorities`
--
ALTER TABLE `priorities`
  ADD CONSTRAINT `priorities_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statuses`
--
ALTER TABLE `statuses`
  ADD CONSTRAINT `statuses_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

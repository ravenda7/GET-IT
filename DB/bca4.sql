-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2023 at 04:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bca4`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `lock_category` tinyint(4) NOT NULL DEFAULT 0,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `lock_category`, `date_time`) VALUES
(3, 'life', 'fsdfsdfsd', 0, '2023-06-25 13:59:45'),
(9, 'Uncategorized', 'this is where all uncategorized projects will lie', 1, '2023-06-25 13:59:45'),
(10, 'Music', 'sadasd sas asgsg', 0, '2023-07-10 02:09:27'),
(11, 'Food', 'Food ashf  fagsfg lf asfgsfsfa hfashfasfasfasfas', 0, '2023-07-14 10:56:58'),
(12, 'Ecommerce', 'asfsafsafasfasf', 0, '2023-10-08 16:49:39'),
(13, 'Blog', 'fsafasf', 0, '2023-10-08 16:50:01'),
(14, 'Game', 'affsasf', 0, '2023-10-08 16:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `liker` int(11) NOT NULL,
  `liked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `liker`, `liked`) VALUES
(80, 31, 31),
(95, 32, 35),
(99, 29, 36),
(101, 32, 36),
(103, 40, 39),
(118, 29, 39),
(119, 32, 37),
(120, 32, 39),
(123, 29, 31),
(124, 41, 40),
(125, 41, 39),
(126, 41, 30),
(128, 32, 40),
(129, 29, 40),
(156, 29, 41),
(157, 29, 35);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(70) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_shown` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `status`, `date`, `is_shown`) VALUES
(4, 32, 'test test', 'hyolmokesu777@gmail.com', 'this is for the testing', 'this is for the message testing for the admin if there message is displayed or not.', 1, '2023-10-31 17:59:14', 1),
(5, 65, 'test user', 'kesanghyolmo288@gmail.com', 'test', 'this message is for the the test.', 0, '2023-10-31 18:02:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `author_id` int(11) UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `projects` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `count` int(11) NOT NULL DEFAULT 0,
  `downloads` int(6) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`, `projects`, `status`, `count`, `downloads`, `views`) VALUES
(30, 'MOON-LIGHT(A PLATFORM OF ONLINE ARTS) ', 'Welcome to Moon-Light, the premier online art destination for enthusiasts, collectors, and artists alike. ArtScape is a vibrant virtual platform that celebrates creativity, diversity, and the power of art to inspire and engage.\r\n\r\nAt Moon-Light, we curate an extensive collection of artwork from talented artists across the globe, spanning various genres, styles, and mediums. From traditional oil paintings to contemporary digital art, our website showcases a diverse range of masterpieces that cater to every artistic taste.\r\n\r\nExplore our intuitive and user-friendly interface that allows you to browse through the extensive gallery effortlessly. With advanced search filters and categories, you can easily discover art that resonates with your personal preferences or find hidden gems that captivate your imagination.', '1686749119Screenshot 2023-06-07 195558.jpg', '2023-06-14 13:25:19', 9, 29, 0, '1686749119first.zip', 0, 1, 0, 7),
(31, 'FUZZIES. (A Culture focused illustration project.)', 'Fuzzies are a custom illustrative world, created by Hank Washington, aiming to show culture, hip hop and individuality. Oh yeah, and Fuzz. Through dynamic hand-drawn hairstyles, donut lips, and Cheeto eyebrows, Fuzzies embraces what it means to be on the common ground but having a sense of individuality.\r\n\r\nThese culture-driven figures are here to embrace relatability and representation and to make sure it doesn&rsquo;t get left behind in the new wave of art. ', '1686754285fuzzie.jpg', '2023-06-14 14:51:25', 9, 29, 0, '1686754285project_new.zip', 0, 2, 3, 9),
(35, 'GDevelop', 'Unleash your creativity with GDevelop and create all kinds of gamesUnleash your creativity with GDevelop and create all kinds of gamesUnleash your creativity with GDevelop and create all kinds of games\r\n\r\nUnleash your creativity with GDevelop and create all kinds of gamesUnleash your creativity with GDevelop and create all kinds of games', '1687355378dawa1.jpg', '2023-06-21 13:49:38', 3, 31, 1, '1687355378drive-download-20230526T072759Z-001.zip', 0, 2, 1, 6),
(36, 'Marmoset Meticulously.', 'Meticulously curated premium music licensing. With Marmoset agency, find up-and-coming bands, vintage recordings and rare music for all of your licensing needs.Meticulously curated premium music licensing. With Marmoset agency, find up-and-coming bands, vintage recordings and rare music for all of your licensing needs.\r\n\r\nMeticulously curated premium music licensing. With Marmoset agency, find up-and-coming bands, vintage recordings and rare music for all of your licensing needs.Meticulously curated premium music licensing. With Marmoset agency, find up-and-coming bands, vintage recordings and rare music for all of your licensing needs.', '1688895883dong1.jpg', '2023-07-09 09:44:43', 3, 32, 0, '1688895883first.zip', 0, 2, 0, 9),
(37, 'OOKI.', 'Try non-custodial crypto margin trading on Ooki, the simplest DeFi platform. Enter into short or long margin trades with up to 15x leverage.Try non-custodial crypto margin trading on Ooki, the simplest DeFi platform. Enter into short or long margin trades with up to 15x leverage.\r\n\r\nTry non-custodial crypto margin trading on Ooki, the simplest DeFi platform. Enter into short or long margin trades with up to 15x leverage.Try non-custodial crypto margin trading on Ooki, the simplest DeFi platform. Enter into short or long margin trades with up to 15x leverage.', '1688898561dong2.jpg', '2023-07-09 10:29:21', 9, 32, 0, '1688898561first.zip', 0, 1, 1, 18),
(39, 'Samurices NFT', 'Samurices is a delicious collection of 7,777 unique Onigiris creatively cooked from a combination of over 200 traits, with some rarer than others, all inspired by food and asian culture on the Ethereum Blockchain.Samurices is a delicious collection of 7,777 unique Onigiris creatively cooked from a combination of over 200 traits, with some rarer than others, all inspired by food and asian culture on the Ethereum Blockchain.\r\n\r\nSamurices is a delicious collection of 7,777 unique Onigiris creatively cooked from a combination of over 200 traits, with some rarer than others, all inspired by food and asian culture on the Ethereum Blockchain.Samurices is a delicious collection of 7,777 unique Onigiris creatively cooked from a combination of over 200 traits, with some rarer than others, all inspired by food and asian culture on the Ethereum Blockchain.', '1689331942ra1.png', '2023-07-14 10:52:22', 3, 40, 0, '1689331942first.zip', 0, 4, 2, 12),
(40, 'testing project', 'fhjf fj f fjjhf', '1689821339Screenshot 2023-06-07 195558.jpg', '2023-07-20 02:48:59', 3, 32, 0, '1689821339first.zip', 0, 3, 2, 8),
(41, 'this is for testing', 'this is for the testing approach...', '1701712230project4.jpg', '2023-12-04 17:50:30', 14, 29, 0, '17017122301689331942first.zip', 0, 1, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `foldername` varchar(255) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `verify_token` varchar(255) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`, `foldername`, `status`, `verify_token`, `register_date`) VALUES
(29, 'Kesang', 'Lama', 'kesang', 'hylmokesu777@gmail.com', '$2y$10$2zzWvNWt8T5xq9EcGtmn3.MkKHOF.3k32B8WKot3d88PiWp8qHYzG', '1686748950kesang.jpg', 1, '6489bf1639958', 0, '3a14f7c2d6d7ff9278cc7bd1c756a7ea', '2023-05-05 05:55:44'),
(31, 'Dawa', 'Tamang', 'dawa', 'dawa123@gmail.com', '$2y$10$bCHyPeRMCpM1rznQ5KMfRugl19w4ZAv/yevd55435S80rhNhxHHIe', '1686753859roshan.jpg', 1, '6489d24395243', 0, '', '2023-06-05 05:55:44'),
(32, 'Deepak', 'Syangdan', 'deepak123', 'hyolmokesu777@gmail.com', '$2y$10$CN3Guu.49gcxFL43IeZSpeV71hxkPhCAL9s9nKXitN4E2fEQnLM46', '1686802709deepak.jpg', 0, '648a9115afd35', 0, '5613fc1191c0dbe0c0525a1ce398d1c4', '2023-04-05 05:55:44'),
(34, 'youkun', 'Blash', 'abc123456', 'admin@gmail.com', '$2y$10$1EsW.tG44wlqbljSX7rirOhCzL1DfSeQ1rtITlYy3PNWZ5mU6Fxw6', '1686885640crab.jpg', 0, '648bd507e83fa', 0, '', '2023-07-05 05:55:44'),
(35, 'Santosh', 'Karki', '1ghanteyyy', 'ghanteyyy@gmail.com', '$2y$10$XG7q9UXjpaxiYXMP.HhxZ.yqSqsrfQ2SPG4GcAhEQDwxSx0uFFzVa', '1687407519er(new).drawio.png', 0, '6493cb9fd37bf', 0, '25f476166fd5e209b7cd58954f3777c9', '2023-07-05 05:55:44'),
(40, 'Rajkumar', 'Tamang', 'raja123', 'rajkumar@gmail.com', '$2y$10$cVJgXzSZpSOmE2ZfQgfHCurs7.ymWI6YNWOqoU1u.tjoCFFrjpTG2', '1689331738rajkumar.jpg', 0, '64b1281a464bf', 0, '', '2023-07-14 10:48:58'),
(41, 'user1', 'user', 'user', 'user@gmail.com', '$2y$10$Hb6vGWgY08S7PlX8VarOCOk06H0r8.TQqFYP6HTimo1t8W1tWMT4q', '1692244467profile2.jpg', 0, '64cfcb3755a1e', 0, '', '2023-08-06 16:32:55'),
(42, 'user', 'user', 'user1', 'user1@gmail.com', '$2y$10$JV9CSPmhnxxRu8r9lfM40um2bqpY79Jd8znQBLH4fSDXQ9FXX1xBy', '1695272569123.png', 0, '650bce7935d2f', 0, '', '2023-09-21 05:02:49'),
(65, 'test', 'user', 'user123', 'kesanghyolmo288@gmail.com', '$2y$10$nk4qJQQUM45XVxWTL.5uve4YwayftFTQVUlKbUViD.JGOed6cWFeS', '1696783567123.png', 0, '6522dccfa8bd4', 0, '', '2023-10-08 16:46:07'),
(66, 'test', 'user', 'user1313', 'dasdas@gmail.com', '$2y$10$85Kaxk/b0HZgulz6ACNxeuvTP1PRwwgU6t63BPbQhf40zyFFoH/um', '1696783633123.png', 0, '6522dd115a2c2', 0, '', '2023-10-08 16:47:13'),
(67, 'tet', 'tewetwe', 'gdsdgsgsd', 'qqwqewre@gmail.com', '$2y$10$LyVx9GE7PR0x9FjStXIN4.89zi3TIkI5N/JGLUIr18ZzyCughMd3W', '1696783700123.png', 0, '6522dd5455478', 0, '', '2023-10-08 16:48:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_blog_category` (`category_id`),
  ADD KEY `FK_blog_author` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_blog_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

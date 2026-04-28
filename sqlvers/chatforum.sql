-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 28 apr 2026 kl 13:29
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `chatforum`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_favorites`
--

CREATE TABLE `tbl_favorites` (
  `id` int(11) NOT NULL,
  `favtype` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `favid` int(11) NOT NULL,
  `favdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `parentid` int(11) NOT NULL,
  `parenttype` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `text` text NOT NULL,
  `topic` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbl_posts`
--

INSERT INTO `tbl_posts` (`id`, `created`, `parentid`, `parenttype`, `rating`, `text`, `topic`, `userid`) VALUES
(1, '2026-04-13 09:28:26', 0, 'none', 5, 'yeah this is the first post', 'first post on chatforum', 1),
(2, '2026-04-18 17:35:35', 0, 'none', 0, 'Kfkdkdkdkrkkk', 'hej', 2),
(3, '2026-04-18 17:38:36', 1, 'none', 4, 'Test', '', 2),
(4, '2026-04-18 22:49:22', 0, 'none', 0, 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggghjkadsfhjkdhjskgfhdskjafghdsjkfhsjfkgsdhfjkdsghafkjdsga hfuscakfgdhjfghdsfkgdshjfkdsgafhuskad gysuk gfyuskgafydsuakfgsdahufkgsdahfjksadgfhsduakfghasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsddjhfdjsafgdhsfakj gshafjkdsgahfjkdsgafhdskjafgdhsakjfgdshafkdsgahfjkdsgafhjdskagfhdsjakgfhdsjkfgsdhjakfgsdhajfkgdshafjkdgsahfkjdgsahfjkdsgahfkjdsagfhdkjsaghfsdjkagfhdsjakfgdshajfkgsdhafjkdgsahfjkdsgafhdjksaghfdskjagfsdhkfgdhsajkfdghsajfkdgshajfkdgshafjkdsgahfkjsdgafkjsafghdsajkfdghsfjkgsdhfdjkfghdjfkshjdhajkgHGhsldghJLGFShdghgfhsGFDGHFDSGFHDsgfdhsfkjgdhsJFKDGSHjfkdghsFJKDGShfjkdgsHFJDGSHFGHFGHjkgFHJKghjgHGhj', 'Showcasing longer texts', 1),
(5, '2026-04-21 07:45:08', 0, 'none', 5, 'NEVER BACK DOWN!!! NEVER GIVE UP!!!!! 🔥🔥🔥', 'EEEEEEEEEEEEEEHHH-MAZING!!!!', 5),
(53, '2026-04-21 12:05:10', 4, 'none', 0, 'another thing that will test longer textsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '', 1),
(54, '2026-04-21 12:10:17', 0, 'none', 5, 'blir det m&ouml;te ikv&auml;ll ?\r\n', 'till sniperking', 5),
(55, '2026-04-21 12:12:14', 54, 'none', 0, 'det blir f&ouml;rmogligen det f&ouml;r vi borde jobba med opponieringen, vi borde kontakta anton med om m&ouml;te men han anv&auml;nder inte denna sida.', '', 1),
(56, '2026-04-21 12:18:43', 54, 'none', 5, 'yes de borde vi', '', 5),
(58, '2026-04-21 12:21:07', 54, 'none', 0, 'n&auml;r ska vi ha m&ouml;te?', '', 1),
(59, '2026-04-21 12:58:37', 54, 'none', 0, 'ja du, ja kan n&auml;rsomhelst det berpor mer p&aring; anton', '', 5),
(60, '2026-04-21 12:58:58', 54, 'none', 5, 'ja sant', '', 1),
(61, '2026-04-23 09:05:29', 0, 'none', 0, 'aaaa', 'a', 1),
(62, '2026-04-23 09:05:32', 0, 'none', 5, 'aa', 'aaaa', 1),
(63, '2026-04-23 09:05:36', 0, 'none', 0, 'aaaa', 'aaaaaaaaaa', 1),
(64, '2026-04-23 12:52:31', 0, 'none', 0, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\n\r\naaaaaaaaaaaa\r\naaaaaa\r\n\r\n\r\naaaaaaaaaaaaa', 'testing with more stuf', 1),
(65, '2026-04-24 09:23:40', 0, 'none', 5, '&aring;&aring;&auml;&auml;&auml;&ouml;&ouml;', '&auml;&auml;&aring;&aring;&aring;&aring;&ouml;&ouml;&ouml;', 1),
(66, '2026-04-24 09:23:51', 65, 'none', 5, '&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&aring;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&auml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;&ouml;', '', 1),
(67, '2026-04-24 09:26:21', 0, 'none', 5, '?&gt;', '?&gt;', 1),
(68, '2026-04-24 09:26:38', 67, 'none', 5, 'zz?&gt;', '', 1),
(69, '2026-04-24 09:48:38', 1, 'none', 0, 'a', '', 1),
(70, '2026-04-28 08:55:53', 54, 'none', 0, 'abslout men n&auml;r ska vi jobba med opponeringen o fixa v&aring;r &aring;rsredovining', '', 5),
(71, '2026-04-28 10:46:38', 0, 'none', 0, '&lt;/h2&gt;&lt;h3&gt;aaaaAAAAAAaaaaa&lt;/h3&gt;&lt;h2&gt;', '&lt;/h2&gt;&lt;h3&gt;aaaaAAAAAAaaaaa&lt;/h3&gt;&lt;h2&gt;', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `id` int(11) NOT NULL,
  `rated` datetime NOT NULL DEFAULT current_timestamp(),
  `revid` int(11) NOT NULL,
  `revtype` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`id`, `rated`, `revid`, `revtype`, `score`, `userid`) VALUES
(1, '2026-04-24 11:20:16', 1, '0', 5, 2),
(2, '2026-04-18 19:43:13', 1, '0', 3, 3),
(3, '2026-04-18 19:43:41', 3, '0', 4, 3),
(4, '2026-04-18 20:57:17', 1, '0', 5, 1),
(5, '2026-04-18 20:57:17', 1, '0', 5, 4),
(6, '2026-04-21 09:45:18', 5, '0', 5, 5),
(7, '2026-04-21 14:18:52', 56, '0', 5, 5),
(8, '2026-04-21 14:20:35', 56, '0', 5, 1),
(9, '2026-04-21 14:20:37', 54, '0', 5, 1),
(10, '2026-04-21 14:44:34', 54, '0', 5, 5),
(11, '2026-04-24 11:12:07', 60, '0', 5, 1),
(12, '2026-04-24 11:20:20', 62, '0', 5, 1),
(13, '2026-04-24 11:23:45', 65, '0', 5, 1),
(14, '2026-04-24 11:23:53', 66, '0', 5, 1),
(15, '2026-04-24 11:26:29', 67, '0', 5, 1),
(16, '2026-04-24 11:26:41', 68, '0', 5, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastlogin` timestamp NOT NULL DEFAULT current_timestamp(),
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `userlevel` int(11) NOT NULL DEFAULT 10,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `created`, `lastlogin`, `mail`, `password`, `realname`, `userlevel`, `username`) VALUES
(1, '2026-04-13 09:28:02', '2026-04-28 10:36:34', '1@1', '1bbd886460827015e5d605ed44252251', 'a', 10000, '1'),
(2, '2026-04-18 17:35:01', '2026-04-18 20:46:55', '', 'f5b0bdcf286e440e04bab20e2359bb16', '', 10, 'Johan'),
(3, '2026-04-18 17:42:44', '2026-04-18 17:42:44', '', '7203446a1e4c269d1c17e32c4dc5f002', '', 10, 'Jessica'),
(4, '2026-04-18 18:57:11', '2026-04-25 12:42:50', '', 'bae5e3208a3c700e3db642b6631e95b9', '', 10, '2'),
(5, '2026-04-21 07:41:48', '2026-04-28 08:54:43', '', '25d55ad283aa400af464c76d713c07ad', 'mostafa', 10, 'mustafa.ali22'),
(7, '2026-04-23 12:36:29', '2026-04-23 12:36:29', '', '1bbd886460827015e5d605ed44252251', '', 10, '3'),
(8, '2026-04-24 08:13:15', '2026-04-24 08:13:15', '', 'b857eed5c9405c1f2b98048aae506792', '', 10, '4');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT för tabell `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 14 apr 2026 kl 09:34
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
(1, '2026-04-13 09:28:26', 0, 'none', 0, 'yeah this is the first post', 'first post on chatforum', 1);

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
(1, '2026-04-13 09:28:02', '2026-04-14 07:32:46', '1@1', '1bbd886460827015e5d605ed44252251', 'a', 10, '1');

--
-- Index för dumpade tabeller
--

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
-- AUTO_INCREMENT för tabell `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

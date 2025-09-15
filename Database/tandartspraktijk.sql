-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 sep 2025 om 00:37
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tandartspraktijk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dentistappointments`
--

CREATE TABLE `dentistappointments` (
  `id` int(11) NOT NULL,
  `customid` int(11) NOT NULL,
  `dentistname` varchar(255) NOT NULL,
  `patientname` varchar(255) NOT NULL,
  `timeperiod` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `customid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tandartassistent`
--

CREATE TABLE `tandartassistent` (
  `id` int(11) NOT NULL,
  `customid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tandartsen`
--

CREATE TABLE `tandartsen` (
  `id` int(11) NOT NULL,
  `customid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `customid` int(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `customid`, `firstname`, `lastname`, `email`, `password`, `phonenumber`) VALUES
(1, NULL, 'testname', 'testlast', 'test@example.com', '$2y$10$rl/rLPbxfdrLcTncU0lkm.Bz3oFa9nlNB4hE28BLLHVF.oQjWhCYW', NULL),
(2, NULL, 'testname', 'testlast', 'test@example.com', '$2y$10$nRlS0EGGuH1hW0kbFDE/Ve6urnbRYMAtl2Bqovz76PcH5u6H/N2XK', NULL),
(3, NULL, 'testname', 'testlast', 'test@example.com', '$2y$10$S4ItPSr6YjF/Zx3wp0DZqelNps0z6LfItHAHOnKK70N8GCa8R.Jja', NULL),
(4, NULL, 'testname', 'testlast323', 'test@gmail.com', '$2y$10$AwKWYzYr9PqgbZT1BKwTrOaKGvAaQdzCyQhPyRYEIfGvmI8B9.RnC', NULL),
(5, NULL, 'testname', 'testlast', 'test@example.com', '$2y$10$LQaeCHIL2kcX.vQKiQIIuOf0wIuQBvY21g3QHmyIO.1mcU/NKVqby', NULL),
(6, NULL, 'testname', 'testlast', 'test@gmail.com', '$2y$10$f75b06.p6dyeG8y6FZzp4u5nVtojEmFdLJJUuKwc.sxWTlBVzvf0i', NULL),
(7, NULL, 'jan', 'willem', 'janwillem@gmail.com', '$2y$10$GpBr8goCeAx6ITkWz3yYSekmZSKJ5tr7KloS67kpsJgjWRApqXfq.', NULL),
(8, NULL, 'testname', 'testlast', 'testt@example.com', '$2y$10$rJQjmZll0MLMQl9sy784QOGFe9ZNlvFs7z.lUGn7MJT4NO3Y2zoMq', NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `dentistappointments`
--
ALTER TABLE `dentistappointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `tandartsen`
--
ALTER TABLE `tandartsen`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `dentistappointments`
--
ALTER TABLE `dentistappointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `tandartsen`
--
ALTER TABLE `tandartsen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

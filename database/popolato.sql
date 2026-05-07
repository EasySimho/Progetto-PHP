-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 04, 2026 alle 11:21
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lanificio_sella`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`) VALUES
(2, 'simho', '$2y$12$lcFYjyRIIt.USX4UZQEw.OzygkXXIJWIafc4zrXFADuzZpR3JDZtW', '2026-05-04 08:11:46');

-- --------------------------------------------------------

--
-- Struttura della tabella `media_contents`
--

CREATE TABLE `media_contents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('Tradizione','Innovazione') NOT NULL,
  `media_type` enum('video','image','youtube') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `media_contents`
--

INSERT INTO `media_contents` (`id`, `title`, `description`, `category`, `media_type`, `file_path`, `created_at`) VALUES
(2, 'Rai luce - Lanificio nazionale', 'lanificio nazionale', 'Tradizione', 'video', 'uploads/videos/1777882796_Le grandi industrie italiane_ un moderno lanificio_480p.mp4', '2026-05-04 08:19:56'),
(3, 'Lanificio robotico', 'nuove tecnologie', 'Innovazione', 'image', 'uploads/images/1777883692_contactus-def-950x600-1.png', '2026-05-04 08:34:52'),
(4, 'Nuovo lanificio', 'test per link youtube', 'Innovazione', 'youtube', 'http://youtube.com/watch?v=9Y0KhV1zYHg', '2026-05-04 08:46:26');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indici per le tabelle `media_contents`
--
ALTER TABLE `media_contents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `media_contents`
--
ALTER TABLE `media_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

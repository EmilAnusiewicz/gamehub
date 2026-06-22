-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 23, 2026 at 12:46 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamehub`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `favourites`
--

CREATE TABLE `favourites` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `game_id`, `user_id`) VALUES
(4, 4, 1),
(3, 5, 1),
(5, 5, 2),
(9, 6, 1),
(6, 6, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `games`
--

CREATE TABLE `games` (
  `id` int(10) UNSIGNED NOT NULL,
  `genre_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `developer` varchar(150) DEFAULT NULL,
  `release_year` smallint(6) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `genre_id`, `title`, `developer`, `release_year`, `cover`, `description`, `rating`) VALUES
(2, 3, 'Wiedźmin 3', 'CD Projekt Red', 2015, '1780753921_PL_CDProjektRED_W3NG_S2_1200x1600_1200x1600-3e9f25a85cec2a8704c7db55f580f560.jpg', 'Ambitny, piękny i bezkompromisowy projekt. Jedna z najwspanialszych gier wideo w historii.\r\nNie warto przebierać w słowach. Wiedźmin 3 to arcydzieło, a pod wieloma względami po prostu najlepsza i najbardziej fascynująca gra ostatnich lat. Urzeka wizją artystyczną, zniewala ogromnym światem, pochłania opowieścią. Twórcy nie szukają taniego poklasku. Ich projekt jest bezkompromisowy i konsekwentny. Przemyślany i dopracowany.', 10.0),
(3, 2, 'Counter Strike Global Offensive 2', 'Valve Corporation', 2023, '1780754150_counter-strike-2-pc-mac-game-steam-cover.jpg', 'Counter-Strike 2 to techniczna ewolucja kultowego CS:GO, przenosząca rozgrywkę na nowoczesny silnik Source 2. Gra zachowuje legendarne mechaniki strzelania i mapy, dodając odświeżoną oprawę graficzną, dynamiczne granaty dymne i zmieniony system tickrate. Mimo lepszej fizyki, spotyka się z krytyką weteranów za niedopracowany matchmaking, sporadyczne błędy i wysoką liczbę oszustów.', 7.0),
(4, 4, 'EA SPORTS FC 26', 'EA Vancouver', 2025, '1780754312_ce668aa6-01fb-4751-8c18-0db969944e9a.jpg', 'EA Sports FC 26 to udana ewolucja serii, chociaż nie wprowadza rewolucyjnych zmian. Gra dzieli się na dwa style rozgrywki – szybszy, zręcznościowy oraz wolniejszy, stawiający na realizm. Ulepszona fizyka, poprawione zachowanie bramkarzy i odświeżony tryb kariery czynią z niej jedną z najlepszych odsłon od lat.Zarówno w opiniach graczy, jak i branżowych recenzjach, EA Sports FC 26 zbiera zróżnicowane noty, od zachwytów nad płynnością, po głosy o braku znaczących nowości.', 7.0),
(5, 5, 'Forza Horizon 6', 'Playground Games', 2026, '1780754560_fh6_evergreen_16x9-master_3840x2160.jpeg', 'Forza Horizon 6 (premiera: 19 maja 2026 r.) zabiera graczy do Japonii, oferując wybitny model jazdy i zróżnicowany otwarty świat. Mimo świetnych opraw i tras, gra bywa krytykowana za brak rewolucyjnych zmian i recykling niektórych elementów z poprzednich odsłon, a także za wyższe ceny (wersja Premium kosztuje ponad 500 zł).Kluczowe zaletyZjawiskowa Japonia: Zróżnicowana mapa, od neonowych ulic Tokio po kręte górskie drogi (touge).Model jazdy: Znakomite odczucie prędkości oraz poprawiona fizyka podsterowności i środka ciężkości pojazdów.Więcej opcji tuningu: Bogatsze możliwości modyfikacji, w tym opcje przeszczepiania silników z motocykli.Klimatyczne aktywności: Świetnie oceniane Nocne Zawody Uliczne, zloty typu Drag Meet oraz trasy Horizon Time Attack.', 6.0),
(6, 3, 'Gotchic Remake', 'CD-Action', 2026, '1780862127_cde9662b-da3f-4846-bd86-4872e3f14de4.png', 'Twoje słowa: gothic remake recenzjaGothic 1 Remake to produkcja o niesamowitym klimacie Górniczej Doliny, która na premierę w czerwcu 2026 roku cierpi jednak na poważne problemy techniczne oraz kontrowersyjne zmiany w mechanice. Recenzenci są zgodni, że studio Alkimia Interactive stworzyło świetny, bezkompromisowy fundament dla powrotu legendy. Mimo to, obecny stan gry wywołuje skrajne emocje wśród krytyków.', 9.0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `genres`
--

CREATE TABLE `genres` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `description`) VALUES
(1, 'RPG', NULL),
(2, 'FPS', NULL),
(3, 'Strategia', NULL),
(4, 'Sportowa', NULL),
(5, 'Wyścigowa', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `game_id`, `user_id`, `score`, `content`, `created_at`) VALUES
(6, 4, 2, 7, ':)', '2026-06-07 19:49:47'),
(7, 5, 1, 7, 'Bardzo fajna gra', '2026-06-08 11:00:24'),
(8, 5, 2, 10, 'Polecam, gra jest bardzo realistyczna :)', '2026-06-08 11:00:52');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_blocked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `is_admin`, `created_at`, `is_blocked`) VALUES
(1, 'emilos206', 'emilos206@o2.pl', '$2y$10$C0CJUpJQSToQScF.e0tGDuOjWLr7qsNrN0lmRT62BG5yX3PBL.32m', 1, '2026-06-06 12:23:52', 0),
(2, 'test123', 'test123@onet.pl', '$2y$10$bA0bSne8hHc7PD4bT6OTlO80jiVlpRI6bD9QkamrCJJegtC0mz8gu', 0, '2026-06-06 13:06:36', 0),
(3, 'emilos2065', 'emil123@onet.pl', '$2y$10$Zim0wmtANDo8p0i0R990T.K4JnjHerpMjr2KrrVXGtm/jstNnZPwi', 0, '2026-06-06 13:17:34', 0),
(4, 'jankowalski', 'jankowalski@gmail.com', '$2y$10$0pNxZ7ko5hCU4vSJWco5EOh4.HTqb1vKLy94Y8BAUtLz5igjZd/mK', 0, '2026-06-07 19:50:33', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `game_id` (`game_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_games_genre` (`genre_id`);

--
-- Indeksy dla tabeli `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_games_genre` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

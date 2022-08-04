-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 04 aug 2022 om 06:32
-- Serverversie: 10.4.25-MariaDB
-- PHP-versie: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marck_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`) VALUES
(1, 1, '2022-08-03 06:40:04'),
(2, 1, '2022-08-03 06:45:43'),
(3, 1, '2022-08-03 06:45:52'),
(4, 1, '2022-08-03 06:46:50'),
(5, 1, '2022-08-03 09:49:16'),
(6, 1, '2022-08-03 13:45:03'),
(7, 1, '2022-08-03 13:51:12'),
(8, 3, '2022-08-03 13:55:02'),
(9, 3, '2022-08-03 14:34:10'),
(10, 2, '2022-08-03 14:43:42');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_details`
--

CREATE TABLE `order_details` (
  `id` int(30) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `amount`) VALUES
(1, 7, 1, 1),
(2, 7, 2, 1),
(3, 8, 1, 1),
(4, 8, 2, 1),
(5, 8, 3, 1),
(6, 9, 2, 2),
(7, 10, 2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `picture`, `details`) VALUES
(1, 'unicorn', '49.99', 10, 'unicorn', 'Mooie tekening van eenhoorn met regenboog'),
(2, 'draak', '29.99', 47, 'draak', 'prachtige tekening van een draak'),
(3, 'family', '39.99', 50, 'family', 'schitterende tekening van de familie');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `naam` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wachtwoord` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `naam`, `email`, `wachtwoord`) VALUES
(1, 'marck', 'mdeleuw@hotmail.com', 'test'),
(2, 'katja', 'katja@hotmail.com', 'test'),
(3, 'ella', 'ella@hotmail.com', 'test'),
(4, 'tieme', 'tiem@hotmail.com', 'test'),
(5, 'marck', 'mwdeleuw@gmail.com', 'test2'),
(6, 'John', 'john@example.com', 'test2'),
(8, 'piet', 'piet@gmail.com', 'test3'),
(9, 'klaas', 'klaas@hotmail.com', 'test4'),
(10, 'piet', 'piet@gmail.com', 'test3'),
(11, 'griet', 'griet@gmail.com', 'tester'),
(12, 'piet', 'piet@gmail.com', 'test3'),
(13, 'piet', 'piet@gmail.com', 'test3'),
(14, 'piet', 'piet@gmail.com', 'test3'),
(15, 'John', 'john@example.com', 'test2'),
(16, 'John', 'john@example.com', 'test2'),
(17, 'John', 'john@example.com', 'test2'),
(18, 'John', 'john@example.com', 'test2'),
(19, 'piet', 'piet@gmail.com', 'test3'),
(20, 'piet', 'piet@gmail.com', 'test3'),
(21, 'tieme', 'tieme@hotmail.com', 'ella');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

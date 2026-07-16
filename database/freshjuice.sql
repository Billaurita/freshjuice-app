-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2026 pada 09.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freshjuice`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_service` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('order_placed','accepted','in_progress','on_the_way','delivered') DEFAULT 'order_placed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `shipping_city`, `shipping_service`, `payment_method`, `status`, `created_at`, `address`) VALUES
(1, 3, 69000.00, 'Jakarta', 'cod', 'qris', '', '2026-07-01 01:16:49', 'Jl.Manggis'),
(2, 3, 69000.00, 'Jakarta', 'cod', 'qris', '', '2026-07-01 01:17:49', 'Jl.Manggis'),
(3, 3, 69000.00, 'Jakarta', 'cod', 'qris', '', '2026-07-01 01:19:44', 'Jl.Manggis'),
(4, 4, 50000.00, 'Jakarta', 'cod', 'qris', '', '2026-07-01 06:06:23', 'Jl. Eric My Bubub'),
(5, 5, 52000.00, 'Jakarta', 'diantar_penjual', 'cash', '', '2026-07-01 13:55:45', 'Jl.Bantu (kantor Lt.31)'),
(6, 5, 24000.00, 'Jakarta', 'cod', 'qris', 'delivered', '2026-07-12 11:16:45', 'Jl. Sayang Sean'),
(7, 5, 75000.00, 'Jakarta', 'diantar_penjual', 'qris', '', '2026-07-12 15:31:40', 'Jl nanas\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 'Green Detox', 2, 22000.00),
(2, 1, 'Berry Power', 1, 25000.00),
(3, 2, 'Green Detox', 2, 22000.00),
(4, 2, 'Berry Power', 1, 25000.00),
(5, 3, 'Green Detox', 2, 22000.00),
(6, 3, 'Berry Power', 1, 25000.00),
(7, 4, 'Berry Power', 2, 25000.00),
(8, 5, 'Green Detox', 1, 22000.00),
(9, 5, 'Berry Power', 1, 25000.00),
(10, 6, 'Tropical Sunrise', 1, 24000.00),
(11, 7, 'Berry Juice ', 2, 35000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `created_at`) VALUES
(1, 'Green Detox', 22000, 'Jus segar perpaduan bayam, apel hijau, dan mentimun. Sangat cocok untuk mendetoks tubuh dari racun dan menyegarkan harimu.', 'green-detox.png', '2026-06-29 04:21:52'),
(2, 'Tropical Sunrise', 24000, 'Perpaduan segar dari mangga, nanas, dan jeruk yang kaya vitamin untuk meningkatkan energi tubuh. 100% Buah Segar dan Tanpa Pengawet.', 'tropical-sunrise.png', '2026-06-29 04:21:52'),
(3, 'Berry Power', 25000, 'Campuran strawberry, blueberry, dan pisang. Teksturnya kental dan kaya antioksidan untuk menjaga daya tahan tubuh sepanjang hari.', 'berry-power.png', '2026-06-29 04:21:52'),
(4, 'Berry Juice ', 35000, 'Perpaduan segar antara berry dan beberapa buah lainnya', '1783869556_Berry.png', '2026-07-12 15:19:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'Admin FreshJuice', 'admin@freshjuice.com', 'admin001', '0812000000', 'Jl. Admin', 'admin', '2026-06-29 03:13:52'),
(2, 'Billa Ramadhani', 'billa@gmail.com', 'password123', '0812111111', 'Jl. User', 'user', '2026-06-29 03:13:52'),
(3, 'Kwon Ohyul', 'ohyulkwon@gmail.com', 'ohyul2115', '0876541980', 'Jl. Manggis No.16', 'user', '2026-06-29 03:31:47'),
(4, 'Kalisa Andam', 'kalisa@gmail.com', 'kalisa123', '0987263091', 'Jl. Eric My bubub', 'user', '2026-07-01 06:05:54'),
(5, 'Sean', 'sean@gmail.com', 'Sean12', '0876512890', 'Jl. Batu', 'user', '2026-07-01 13:55:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

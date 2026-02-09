-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09 Feb 2026 pada 03.32
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sobatbranding`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertDummyServices` ()  BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE cat_val VARCHAR(50);
    DECLARE title_val VARCHAR(255);
    DECLARE price_val INT;
    DECLARE img_val VARCHAR(255);
    
    WHILE i <= 300 DO
                SET cat_val = ELT(FLOOR(1 + (RAND() * 6)), 
            'Desain Grafis', 'Digital Marketing', 'Website & IT', 
            'Video & Animasi', 'Penulisan & Terjemahan', 'Gaya Hidup');
            
                IF cat_val = 'Desain Grafis' THEN
            SET title_val = CONCAT(ELT(FLOOR(1 + (RAND() * 3)), 'Desain Logo Professional ', 'Branding Identitas ', 'Banner Sosmed Kece '), i);
            SET img_val = 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=1000';
        ELSEIF cat_val = 'Website & IT' THEN
            SET title_val = CONCAT(ELT(FLOOR(1 + (RAND() * 3)), 'Web Undangan Digital ', 'Landing Page Bisnis ', 'Website Company Profile '), i);
            SET img_val = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1000';
        ELSEIF cat_val = 'Digital Marketing' THEN
            SET title_val = CONCAT(ELT(FLOOR(1 + (RAND() * 3)), 'Jasa Iklan FB & IG ', 'Optimasi SEO Website ', 'Kelola Admin Sosmed '), i);
            SET img_val = 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?q=80&w=1000';
        ELSE
            SET title_val = CONCAT('Layanan Kreatif Professional ', i);
            SET img_val = 'https://images.unsplash.com/photo-1454165833767-129674992767?q=80&w=1000';
        END IF;

                SET price_val = FLOOR(50000 + (RAND() * 1950000));

                INSERT INTO services (title, description, price, category, image, rating, user_id) 
        VALUES (title_val, 'Dapatkan hasil pengerjaan terbaik untuk brand Anda. Proses cepat, revisi sepuasnya, dan kualitas dijamin premium.', price_val, cat_val, img_val, 4.9, 1);
        
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jasa`
--

CREATE TABLE `jasa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_jasa` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `note` text,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('pending','process','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `service_id`, `note`, `bukti_pembayaran`, `payment_method`, `status`, `created_at`) VALUES
(1, 1, 1, 'Tolong buatkan logo yang elegan ya bos', NULL, 'BCA', 'pending', '2026-02-09 00:09:01'),
(2, 1, 3, 'gdeteywsge', 'bukti_1770596095.png', NULL, 'pending', '2026-02-09 00:14:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id` int(11) NOT NULL,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) NOT NULL,
  `isi_pesan` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pengirim` varchar(100) DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('pending','proses','selesai','ditolak') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `nama_pengirim`, `metode`, `nominal`, `bukti_transfer`, `status`, `created_at`) VALUES
(1, 1, 'afsf', 'BCA', 510000, '3203_1770600074.png', 'pending', '2026-02-09 01:21:14'),
(2, 1, 'arheefz', 'BCA', 510000, '4654_1770600087.png', 'pending', '2026-02-09 01:21:27'),
(3, 1, 'joko Nwar', 'BCA', 510000, '3441_1770600334.png', 'pending', '2026-02-09 01:25:34'),
(4, 1, 'gesrge', 'BCA', 510000, '8882_1770600355.jpeg', 'pending', '2026-02-09 01:25:55'),
(5, 1, 'joko Nwar', 'BCA', 510000, '7470_1770602431.png', 'pending', '2026-02-09 02:00:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `price` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT '5.0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `price`, `image`, `category`, `rating`) VALUES
(1, 'Jasa Desain Logo Minimalis UMKM', NULL, 150000, 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&q=80&w=600', 'Desain', '5.0'),
(2, 'Social Media Management Premium', NULL, 750000, 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&q=80&w=600', 'Marketing', '4.9'),
(3, 'Website Landing Page Responsive', NULL, 1200000, 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600', 'Website', '5.0'),
(4, 'Video Promosi Produk Cinematic', NULL, 500000, 'https://images.unsplash.com/photo-1492724441997-5dc865305da7?auto=format&fit=crop&q=80&w=600', 'Video', '4.8'),
(5, 'Legalitas PT Perorangan Lengkap', NULL, 2500000, 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=600', 'Legalitas', '5.0'),
(6, 'Copywriting Caption Instagram 30 Hari', NULL, 300000, 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&q=80&w=600', 'Marketing', '4.7');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Arheefz', 'primeclipstudio.22@gmail.com', '$2y$10$3nuT754RAapr7Z6foLjeP.oJx2hb1EnREkD6F/bOixfzEElU2cnSW', 'client', '2026-02-09 01:00:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jasa`
--
ALTER TABLE `jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jasa`
--
ALTER TABLE `jasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2025 pada 07.32
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
-- Database: `mesketch`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog`
--

CREATE TABLE `blog` (
  `id_blog` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `excerpt` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `blog`
--

INSERT INTO `blog` (`id_blog`, `author`, `judul`, `isi`, `excerpt`, `gambar`, `tanggal`) VALUES
(1, 'Fein', 'Pentingnya Memilih Material Yang bagus', 'Terdapat istilah \"Rumahku Istanaku\" istilah ini memilki makna yang sangat penting bahwa rumah adalah barang mewah yang harus di design dengan baik dan nyaman. Itulah mengapa ketika membangun rumah, material sangat penting untuk diperhatikan agar dapat membuat penghuninya dapat nyaman dan merasa aman.', 'Terdapat istilah Rumahku Istanaku istilah ini memilki makna yang sangat penting bahwa rumah adalah barang mewah yang...', '693d2966451e8_1765615974.jpg', '2025-12-13'),
(28, 'caca', 'Rumah Yang Nyaman Untuk Segala Usia', 'Rumah merupakan sesuatu yang mewah dan bagi sebagian besar penduduk indonesia hanya memilki 1 rumah dalam seumur hidupnya. Oleh karena itu, membangun rumah yang ramah segala usia sanngatlah penting. Diperlukan perencanaan yang baik sedari awal agar tidak salah membangun. Rumah yang ramah untuk segala usia adalah rumah yang memiliki standar keamanan yang baik.', 'Rumah merupakan sesuatu yang mewah dan bagi sebagian besar penduduk indonesia hanya memilki rumah dalam seumur hidupnya...', '693d2ab4cb09a_1765616308.jpg', '2025-12-13'),
(31, 'mirantirhy', 'Pentingnya Pencahayaan di Dalam Rumah', 'Pencahayaan merupakan salah satu elemen penting dalam desain interior rumah yang sering kali dianggap sepele. Padahal, pencahayaan yang baik dapat memengaruhi kenyamanan, kesehatan, dan suasana di dalam rumah. Dengan pencahayaan yang tepat, aktivitas sehari-hari dapat dilakukan dengan lebih nyaman dan aman.\r\n\r\nSelain berfungsi sebagai sumber cahaya, pencahayaan juga berperan dalam membentuk suasana ruangan. Cahaya yang terang dan merata cocok untuk ruang kerja atau dapur, sementara pencahayaan yang lembut lebih sesuai untuk kamar tidur dan ruang keluarga karena memberikan kesan hangat dan menenangkan. Pemilihan jenis lampu dan intensitas cahaya yang tepat sangat menentukan atmosfer ruangan.\r\n\r\nPencahayaan alami dari sinar matahari juga memiliki manfaat besar. Selain menghemat energi listrik, cahaya alami dapat membuat ruangan terasa lebih luas, segar, dan sehat. Oleh karena itu, penataan jendela dan bukaan cahaya perlu diperhatikan agar sinar matahari dapat masuk secara optimal ke dalam rumah.\r\n\r\nDengan perencanaan pencahayaan yang baik, keindahan interior rumah dapat lebih menonjol dan kenyamanan penghuni pun meningkat. Pencahayaan bukan hanya pelengkap, tetapi bagian penting dari desain rumah yang mendukung kualitas hidup sehari-hari.', 'Pencahayaan merupakan salah satu elemen penting dalam desain interior rumah yang sering kali dianggap sepele Padahal pencahayaan...', '693da7c8359d5_1765648328.jpg', '2025-12-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `testi`
--

CREATE TABLE `testi` (
  `idTesti` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `isi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `testi`
--

INSERT INTO `testi` (`idTesti`, `nama`, `isi`) VALUES
(1, 'Rayhan Rangga Yudha', 'Pelayanannya sudah sangat baik, namun ke depannya akan lebih bagus jika tersedia lebih banyak contoh referensi desain agar klien memiliki gambaran yang lebih luas'),
(2, 'Fina Ramadhani', 'Puas banget pakai jasa konsultasi desain interior di sini. Desainnya keren, komunikasinya enak, dan hasilnya sesuai ekspektasi'),
(5, 'Unknown', 'Saya puas dengan layanan konsul desain interior ini. Timnya ramah, responsif, dan mampu menerjemahkan keinginan saya menjadi konsep desain yang rapi dan modern'),
(6, 'anvy', 'Konsultasi desain interiornya sangat membantu. Penjelasannya jelas, detail, dan sesuai dengan kebutuhan ruangan saya. Desain yang diberikan tidak hanya estetik tapi juga fungsional. Sangat recommended!');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `telepon` varchar(20) NOT NULL DEFAULT '',
  `jenis_kelamin` varchar(20) NOT NULL DEFAULT '',
  `gambar` text NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `gambar`, `role`) VALUES
(2, 'Fein', '202cb962ac59075b964b07152d234b70', 'Finaaaaaa', '693d36048e40e_1765619204.png', 'Admin'),
(3, 'mirantirhy', '202cb962ac59075b964b07152d234b70', 'Miranti', '693d36a603286_1765619366.jpg', 'Writer'),
(7, 'caca', '202cb962ac59075b964b07152d234b70', 'caca', '693d135605e0b_1765610326.jpg', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id_blog`);

--
-- Indeks untuk tabel `testi`
--
ALTER TABLE `testi`
  ADD PRIMARY KEY (`idTesti`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Struktur dari tabel `booking`
--
CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `address` text NOT NULL,
  `notes` text,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_booking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `blog`
--
ALTER TABLE `blog`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `testi`
--
ALTER TABLE `testi`
  MODIFY `idTesti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

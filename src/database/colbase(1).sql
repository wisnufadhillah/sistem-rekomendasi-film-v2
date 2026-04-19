-- phpMyAdmin SQL Dump
-- Tema: Sistem Rekomendasi K-Drama
-- Database: colbase

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `colbase`;
USE `colbase`;

-- ------------------------------
-- TABEL: user
-- ------------------------------
CREATE TABLE `user` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_user` VARCHAR(255) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`) VALUES
(1, 'Danar', 'danar', 'danar123'),
(2, 'Fabian', 'fabian', 'fabian123'),
(3, 'Ilham', 'ilham', 'ilham123'),
(4, 'Keysha', 'keysha', 'keysha123'),
(5, 'Shindu', 'shindu', 'shindu123');

-- ------------------------------
-- TABEL: item (judul K-Drama)
-- ------------------------------
CREATE TABLE `item` (
  `id_item` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_item` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `item` (`id_item`, `nama_item`) VALUES
(1, 'Crash Landing on You'),
(2, 'Itaewon Class'),
(3, 'Goblin'),
(4, 'Descendants of the Sun'),
(5, 'Vincenzo'),
(6, 'Start-Up');

-- ------------------------------
-- TABEL: nilai (rating user terhadap drama)
-- ------------------------------
CREATE TABLE `nilai` (
  `id_nilai` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user` INT(11) NOT NULL,
  `id_item` INT(11) NOT NULL,
  `isi_nilai` INT(11) NOT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nilai` (`id_nilai`, `id_user`, `id_item`, `isi_nilai`) VALUES
(1, 1, 1, 5),  -- Danar suka Crash Landing on You
(2, 1, 2, 4),
(3, 1, 3, 0),
(4, 1, 4, 3),
(5, 1, 5, 4),
(6, 1, 6, 0),

(7, 2, 1, 4),
(8, 2, 2, 5),
(9, 2, 3, 3),
(10, 2, 4, 0),
(11, 2, 5, 5),
(12, 2, 6, 2),

(13, 3, 1, 0),
(14, 3, 2, 4),
(15, 3, 3, 5),
(16, 3, 4, 3),
(17, 3, 5, 0),
(18, 3, 6, 5),

(19, 4, 1, 3),
(20, 4, 2, 5),
(21, 4, 3, 4),
(22, 4, 4, 5),
(23, 4, 5, 3),
(24, 4, 6, 4),

(25, 5, 1, 5),
(26, 5, 2, 4),
(27, 5, 3, 4),
(28, 5, 4, 3),
(29, 5, 5, 0),
(30, 5, 6, 2);

COMMIT;
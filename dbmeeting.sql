-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Nis 2023, 00:26:41
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dbmeeting`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `meeting`
--

CREATE TABLE `meeting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `adddate` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `meeting`
--

INSERT INTO `meeting` (`id`, `title`, `startdate`, `enddate`, `description`, `location`, `adddate`, `active`) VALUES
(9, 'Birthday', 1682182800, 1682211600, 'Bring your own snacks and drinks', '1.Bezirk', 1682119496, 1),
(10, 'Vienna Run-Marathon', 1682593800, 1682611200, 'We have to run 10km', '2.Bezirk', 1682338794, 1),
(11, 'Sprechstunde', 1682744460, 1682780400, 'Besprechung von Problemen mit dem Studiegangsleiter', 'Fh Technikum A1.03', 1682454311, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `meetuser`
--

CREATE TABLE `meetuser` (
  `id` int(11) NOT NULL,
  `meetid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `meettime` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `meetuser`
--

INSERT INTO `meetuser` (`id`, `meetid`, `username`, `description`, `meettime`, `active`) VALUES
(16, 9, 'Direncan Sahin', 'I am exciting', 1682197200, 1),
(17, 10, 'Diren Sahin', 'I wanna win', 1682597400, 0),
(19, 10, 'Direncan ', 'whoorayy', 1682597400, 1),
(20, 11, 'Zübeyr Sahin', 'Yes pleasee', 1682766060, 1),
(21, 11, 'Zübeyr Sahin', 'Yes pleasee', 1682769660, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `meetuser`
--
ALTER TABLE `meetuser`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `meetuser`
--
ALTER TABLE `meetuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

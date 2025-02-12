-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 12. úno 2025, 23:27
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `card_template`
--

CREATE TABLE `card_template` (
  `idcard_template` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `card_template`
--

INSERT INTO `card_template` (`idcard_template`, `name`, `description`, `price`, `picture`) VALUES
(1, 'Yeezus', 'Obrázek Yeezus', 0.50, 'img/yeezuz.png'),
(2, 'Vizitka 1', 'Náhled šablony vizitky', 0.50, 'img/vizitka.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `clanky`
--

CREATE TABLE `clanky` (
  `clanky_id` int(11) NOT NULL,
  `titulek` varchar(255) DEFAULT NULL,
  `obsah` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `popisek` varchar(255) DEFAULT NULL,
  `klicova_slova` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `clanky`
--

INSERT INTO `clanky` (`clanky_id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova`) VALUES
(1, 'Úvod', '<p>Vítejte na našem webu!</p>\r\n<p>Tento web je postaven na <strong>jednoduchém MVC frameworku v PHP</strong>. Toto je úvodní článek, načtený z databáze.</p>', 'uvod', 'Úvodní článek na webu v MVC v PHP', 'úvod, mvc, web'),
(3, 'Obchodní podmínky', '<p>Obchodní podmínky</p>', 'obchodnipodminky', 'Obchodní podmínky ', 'obchodnipodminky Obchodní podmínky '),
(4, 'Služby našeho webu', '<p>Supr</p>', 'sluzby', '', 'služby web náš web');

-- --------------------------------------------------------

--
-- Struktura tabulky `measurement`
--

CREATE TABLE `measurement` (
  `idmeasurement` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `measurement`
--

INSERT INTO `measurement` (`idmeasurement`, `name`, `price`) VALUES
(1, '90 x 50 mm', 0.50),
(2, '85 x 55 mm', 0.60),
(3, '90 x 60 mm', 0.70);

-- --------------------------------------------------------

--
-- Struktura tabulky `order`
--

CREATE TABLE `order` (
  `idorder` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `idcard_template` int(11) NOT NULL,
  `idpaper_type` int(11) NOT NULL,
  `idprint` int(11) NOT NULL,
  `idmeasurement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `paper_type`
--

CREATE TABLE `paper_type` (
  `idpaper_type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `paper_type`
--

INSERT INTO `paper_type` (`idpaper_type`, `name`, `price`) VALUES
(1, 'Matný', 0.30),
(2, 'Lesklý', 0.50);

-- --------------------------------------------------------

--
-- Struktura tabulky `print`
--

CREATE TABLE `print` (
  `idprint` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `print`
--

INSERT INTO `print` (`idprint`, `name`, `price`) VALUES
(1, 'Jednostranný tisk', 0.50),
(2, 'Oboustranný tisk', 1.00);

-- --------------------------------------------------------

--
-- Struktura tabulky `review`
--

CREATE TABLE `review` (
  `idreview` int(11) NOT NULL,
  `text` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `author` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`iduser`, `name`, `email`, `password`, `admin`) VALUES
(9, 'Gigi', 'gigi@gmail.com', '$2y$10$nylXHpyWttjcN8FSgkgkTuWccZ1fzyzZigopYRpUuVVQbcZefiNvW', 0),
(10, 'Michal Čálek', 'michalcalekadc@gmail.com', '$2y$10$I8VSxoCXH8Dq1k29dKwGXuSMistzeS5IUOdtQLIhTLbKfDgK/LR6e', 1);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `card_template`
--
ALTER TABLE `card_template`
  ADD PRIMARY KEY (`idcard_template`);

--
-- Indexy pro tabulku `clanky`
--
ALTER TABLE `clanky`
  ADD PRIMARY KEY (`clanky_id`);

--
-- Indexy pro tabulku `measurement`
--
ALTER TABLE `measurement`
  ADD PRIMARY KEY (`idmeasurement`);

--
-- Indexy pro tabulku `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idorder`),
  ADD KEY `fk_order_card_template` (`idcard_template`),
  ADD KEY `fk_order_paper_type` (`idpaper_type`),
  ADD KEY `fk_order_print` (`idprint`),
  ADD KEY `fk_order_measurement` (`idmeasurement`);

--
-- Indexy pro tabulku `paper_type`
--
ALTER TABLE `paper_type`
  ADD PRIMARY KEY (`idpaper_type`);

--
-- Indexy pro tabulku `print`
--
ALTER TABLE `print`
  ADD PRIMARY KEY (`idprint`);

--
-- Indexy pro tabulku `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`idreview`);

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `card_template`
--
ALTER TABLE `card_template`
  MODIFY `idcard_template` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `clanky`
--
ALTER TABLE `clanky`
  MODIFY `clanky_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `measurement`
--
ALTER TABLE `measurement`
  MODIFY `idmeasurement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `order`
--
ALTER TABLE `order`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `paper_type`
--
ALTER TABLE `paper_type`
  MODIFY `idpaper_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `print`
--
ALTER TABLE `print`
  MODIFY `idprint` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `review`
--
ALTER TABLE `review`
  MODIFY `idreview` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_card_template` FOREIGN KEY (`idcard_template`) REFERENCES `card_template` (`idcard_template`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_measurement` FOREIGN KEY (`idmeasurement`) REFERENCES `measurement` (`idmeasurement`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_paper_type` FOREIGN KEY (`idpaper_type`) REFERENCES `paper_type` (`idpaper_type`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_print` FOREIGN KEY (`idprint`) REFERENCES `print` (`idprint`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

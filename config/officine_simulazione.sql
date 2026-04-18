-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2026 at 11:22 AM
-- Server version: 12.2.2-MariaDB
-- PHP Version: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `officine_simulazione`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessori`
--

CREATE TABLE `accessori` (
  `codice_accessorio` int(11) NOT NULL,
  `costo_unitario` decimal(10,0) NOT NULL,
  `nome_accessorio` varchar(20) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clienti`
--

CREATE TABLE `clienti` (
  `email` varchar(32) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clienti`
--

INSERT INTO `clienti` (`email`, `password_hash`, `nome`, `cognome`, `telefono`, `uuid`, `email_verified`) VALUES
('davidericcobeneproton@proton.me', '$2y$12$cdvDbeaBqpjRw1tWpjk4N.TiqjPl3yLbIZfbKIY1aftWX1kQQW4ei', 'Davide', 'Riccobene', '28928', '12ae3b3f-6ebb-5cbb-b297-8cf58a9f20a3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dipendenti`
--

CREATE TABLE `dipendenti` (
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `ruolo` enum('admin','tecnico','magazziniere') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dipendenti`
--

INSERT INTO `dipendenti` (`username`, `password_hash`, `ruolo`) VALUES
('Kynda', '$2y$12$9TETzrt3tWINq6nHAxRQmuyrIkhVIJ3Fr1Hc6HlHqzilJHeG9cbGS', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `officine`
--

CREATE TABLE `officine` (
  `codice_officina` int(11) NOT NULL,
  `denominazione` varchar(15) NOT NULL,
  `indirizzo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officine`
--

INSERT INTO `officine` (`codice_officina`, `denominazione`, `indirizzo`) VALUES
(1, 'Officina dei si', 'VIa dei sigma, 42');

-- --------------------------------------------------------

--
-- Table structure for table `officine_accessori`
--

CREATE TABLE `officine_accessori` (
  `codice_officina` int(11) NOT NULL,
  `codice_accessorio` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `officine_pezzi`
--

CREATE TABLE `officine_pezzi` (
  `codice_officina` int(11) NOT NULL,
  `codice_pezzo` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `officine_servizi`
--

CREATE TABLE `officine_servizi` (
  `codice_officina` int(11) NOT NULL,
  `codice_servizio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officine_servizi`
--

INSERT INTO `officine_servizi` (`codice_officina`, `codice_servizio`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pezzi_ricambio`
--

CREATE TABLE `pezzi_ricambio` (
  `codice_pezzo` int(11) NOT NULL,
  `costo_unitario` decimal(10,0) NOT NULL,
  `nome_pezzo` varchar(20) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servizi`
--

CREATE TABLE `servizi` (
  `codice_servizio` int(11) NOT NULL,
  `nome_servizio` varchar(20) NOT NULL,
  `costo_orario` decimal(10,0) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servizi`
--

INSERT INTO `servizi` (`codice_servizio`, `nome_servizio`, `costo_orario`, `descrizione`) VALUES
(1, 'cambio gomme', 20, 'Cambio delle gomme dell\'automobile'),
(2, 'sigma_servizio', 10, 'questo servizio e\' sigma');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessori`
--
ALTER TABLE `accessori`
  ADD PRIMARY KEY (`codice_accessorio`);

--
-- Indexes for table `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `dipendenti`
--
ALTER TABLE `dipendenti`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `officine`
--
ALTER TABLE `officine`
  ADD PRIMARY KEY (`codice_officina`);

--
-- Indexes for table `officine_accessori`
--
ALTER TABLE `officine_accessori`
  ADD KEY `fk_codice_officina` (`codice_officina`),
  ADD KEY `fk_codice_accessorio` (`codice_accessorio`);

--
-- Indexes for table `officine_pezzi`
--
ALTER TABLE `officine_pezzi`
  ADD KEY `fk_codice_officina_pezzi` (`codice_officina`),
  ADD KEY `fk_codice_pezzo_pezzi` (`codice_pezzo`);

--
-- Indexes for table `officine_servizi`
--
ALTER TABLE `officine_servizi`
  ADD KEY `fk_codice_officina_servizi` (`codice_officina`),
  ADD KEY `fk_codice_servizio_servizi` (`codice_servizio`);

--
-- Indexes for table `pezzi_ricambio`
--
ALTER TABLE `pezzi_ricambio`
  ADD PRIMARY KEY (`codice_pezzo`);

--
-- Indexes for table `servizi`
--
ALTER TABLE `servizi`
  ADD PRIMARY KEY (`codice_servizio`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessori`
--
ALTER TABLE `accessori`
  MODIFY `codice_accessorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officine`
--
ALTER TABLE `officine`
  MODIFY `codice_officina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pezzi_ricambio`
--
ALTER TABLE `pezzi_ricambio`
  MODIFY `codice_pezzo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servizi`
--
ALTER TABLE `servizi`
  MODIFY `codice_servizio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `officine_accessori`
--
ALTER TABLE `officine_accessori`
  ADD CONSTRAINT `fk_codice_accessorio` FOREIGN KEY (`codice_accessorio`) REFERENCES `accessori` (`codice_accessorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codice_officina` FOREIGN KEY (`codice_officina`) REFERENCES `officine` (`codice_officina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `officine_pezzi`
--
ALTER TABLE `officine_pezzi`
  ADD CONSTRAINT `fk_codice_officina_pezzi` FOREIGN KEY (`codice_officina`) REFERENCES `officine` (`codice_officina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codice_pezzo_pezzi` FOREIGN KEY (`codice_pezzo`) REFERENCES `pezzi_ricambio` (`codice_pezzo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `officine_servizi`
--
ALTER TABLE `officine_servizi`
  ADD CONSTRAINT `fk_codice_officina_servizi` FOREIGN KEY (`codice_officina`) REFERENCES `officine` (`codice_officina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codice_servizio_servizi` FOREIGN KEY (`codice_servizio`) REFERENCES `servizi` (`codice_servizio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

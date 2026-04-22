-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 22, 2026 alle 09:39
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
-- Database: `officine_simulazione`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accessori`
--

CREATE TABLE `accessori` (
  `codice_accessorio` int(11) NOT NULL,
  `costo_unitario` decimal(10,0) NOT NULL,
  `nome_accessorio` varchar(20) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `accessori`
--

INSERT INTO `accessori` (`codice_accessorio`, `costo_unitario`, `nome_accessorio`, `descrizione`) VALUES
(1, 10, 'profumatore', 'profumatore per auto sigma'),
(2, 123, 'sigmaAccessorio', 'wiaodia');

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
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

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendenti`
--

CREATE TABLE `dipendenti` (
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `ruolo` enum('admin','tecnico','magazziniere') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `dipendenti`
--

INSERT INTO `dipendenti` (`username`, `password_hash`, `ruolo`) VALUES
('Kynda', '$2y$12$jzgtIUwz40ejBy1JsF8NVuNSEfE9EbBqtT0KI.s4RUyIGr9EKAYTW', 'admin');

-- --------------------------------------------------------

--
-- Struttura della tabella `officine`
--

CREATE TABLE `officine` (
  `codice_officina` int(11) NOT NULL,
  `denominazione` varchar(15) NOT NULL,
  `indirizzo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `officine`
--

INSERT INTO `officine` (`codice_officina`, `denominazione`, `indirizzo`) VALUES
(1, 'Officina dei si', 'VIa dei sigma, 42');

-- --------------------------------------------------------

--
-- Struttura della tabella `officine_accessori`
--

CREATE TABLE `officine_accessori` (
  `codice_officina` int(11) NOT NULL,
  `codice_accessorio` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `officine_pezzi`
--

CREATE TABLE `officine_pezzi` (
  `codice_officina` int(11) NOT NULL,
  `codice_pezzo` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `officine_servizi`
--

CREATE TABLE `officine_servizi` (
  `codice_officina` int(11) NOT NULL,
  `codice_servizio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `officine_servizi`
--

INSERT INTO `officine_servizi` (`codice_officina`, `codice_servizio`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `pezzi_ricambio`
--

CREATE TABLE `pezzi_ricambio` (
  `codice_pezzo` int(11) NOT NULL,
  `costo_unitario` decimal(10,0) NOT NULL,
  `nome_pezzo` varchar(20) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `pezzi_ricambio`
--

INSERT INTO `pezzi_ricambio` (`codice_pezzo`, `costo_unitario`, `nome_pezzo`, `descrizione`) VALUES
(1, 123, 'sigma', 'adwadsada');

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi`
--

CREATE TABLE `servizi` (
  `codice_servizio` int(11) NOT NULL,
  `nome_servizio` varchar(20) NOT NULL,
  `costo_orario` decimal(10,0) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `servizi`
--

INSERT INTO `servizi` (`codice_servizio`, `nome_servizio`, `costo_orario`, `descrizione`) VALUES
(1, 'cambio gomme', 20, 'Cambio delle gomme dell\'automobile'),
(2, 'sigma_servizio', 10, 'questo servizio e\' sigma'),
(3, 'wads', 32, 'dadsa');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accessori`
--
ALTER TABLE `accessori`
  ADD PRIMARY KEY (`codice_accessorio`);

--
-- Indici per le tabelle `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `dipendenti`
--
ALTER TABLE `dipendenti`
  ADD PRIMARY KEY (`username`);

--
-- Indici per le tabelle `officine`
--
ALTER TABLE `officine`
  ADD PRIMARY KEY (`codice_officina`);

--
-- Indici per le tabelle `officine_accessori`
--
ALTER TABLE `officine_accessori`
  ADD KEY `fk_codice_officina` (`codice_officina`),
  ADD KEY `fk_codice_accessorio` (`codice_accessorio`);

--
-- Indici per le tabelle `officine_pezzi`
--
ALTER TABLE `officine_pezzi`
  ADD KEY `fk_codice_officina_pezzi` (`codice_officina`),
  ADD KEY `fk_codice_pezzo_pezzi` (`codice_pezzo`);

--
-- Indici per le tabelle `officine_servizi`
--
ALTER TABLE `officine_servizi`
  ADD KEY `fk_codice_officina_servizi` (`codice_officina`),
  ADD KEY `fk_codice_servizio_servizi` (`codice_servizio`);

--
-- Indici per le tabelle `pezzi_ricambio`
--
ALTER TABLE `pezzi_ricambio`
  ADD PRIMARY KEY (`codice_pezzo`);

--
-- Indici per le tabelle `servizi`
--
ALTER TABLE `servizi`
  ADD PRIMARY KEY (`codice_servizio`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accessori`
--
ALTER TABLE `accessori`
  MODIFY `codice_accessorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `officine`
--
ALTER TABLE `officine`
  MODIFY `codice_officina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `pezzi_ricambio`
--
ALTER TABLE `pezzi_ricambio`
  MODIFY `codice_pezzo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `servizi`
--
ALTER TABLE `servizi`
  MODIFY `codice_servizio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `officine_accessori`
--
ALTER TABLE `officine_accessori`
  ADD CONSTRAINT `fk_codice_accessorio` FOREIGN KEY (`codice_accessorio`) REFERENCES `accessori` (`codice_accessorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codice_officina` FOREIGN KEY (`codice_officina`) REFERENCES `officine` (`codice_officina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `officine_pezzi`
--
ALTER TABLE `officine_pezzi`
  ADD CONSTRAINT `fk_codice_officina_pezzi` FOREIGN KEY (`codice_officina`) REFERENCES `officine` (`codice_officina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codice_pezzo_pezzi` FOREIGN KEY (`codice_pezzo`) REFERENCES `pezzi_ricambio` (`codice_pezzo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `officine_servizi`
--
ALTER TABLE `officine_servizi`
  ADD CONSTRAINT `fk_codice_officina_servizi` FOREIGN KEY (`codice_officina`) REFERENCES `officine` (`codice_officina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_codice_servizio_servizi` FOREIGN KEY (`codice_servizio`) REFERENCES `servizi` (`codice_servizio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

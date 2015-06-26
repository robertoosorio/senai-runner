-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2015 at 02:39 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `runners_runners`
--

-- --------------------------------------------------------

--
-- Table structure for table `corredor`
--

DROP TABLE IF EXISTS `corredor`;
CREATE TABLE `corredor` (
`id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `corridas`
--

DROP TABLE IF EXISTS `corridas`;
CREATE TABLE `corridas` (
`id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `valor_inscricao` float NOT NULL,
  `status` enum('agendada','cancelada') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inscricao`
--

DROP TABLE IF EXISTS `inscricao`;
CREATE TABLE `inscricao` (
`id` int(11) NOT NULL,
  `id_corrida` int(11) NOT NULL,
  `id_corredor` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `corredor`
--
ALTER TABLE `corredor`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `corridas`
--
ALTER TABLE `corridas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inscricao`
--
ALTER TABLE `inscricao`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `corredor`
--
ALTER TABLE `corredor`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `corridas`
--
ALTER TABLE `corridas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inscricao`
--
ALTER TABLE `inscricao`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

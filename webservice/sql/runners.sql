-- --------------------------------------------------------
-- Servidor:                     192.168.0.86
-- Versão do servidor:           5.1.58-1ubuntu1 - (Ubuntu)
-- OS do Servidor:               debian-linux-gnu
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para runners_runners
CREATE DATABASE IF NOT EXISTS `runners_runners` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `runners_runners`;


-- Copiando estrutura para tabela runners_runners.corredor
DROP TABLE IF EXISTS `corredor`;
CREATE TABLE IF NOT EXISTS `corredor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela runners_runners.corredor: 0 rows
/*!40000 ALTER TABLE `corredor` DISABLE KEYS */;
/*!40000 ALTER TABLE `corredor` ENABLE KEYS */;


-- Copiando estrutura para tabela runners_runners.corridas
DROP TABLE IF EXISTS `corridas`;
CREATE TABLE IF NOT EXISTS `corridas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `valor_inscricao` float NOT NULL,
  `status` enum('agendada','cancelada') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela runners_runners.corridas: 0 rows
/*!40000 ALTER TABLE `corridas` DISABLE KEYS */;
/*!40000 ALTER TABLE `corridas` ENABLE KEYS */;


-- Copiando estrutura para tabela runners_runners.inscricao
DROP TABLE IF EXISTS `inscricao`;
CREATE TABLE IF NOT EXISTS `inscricao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_corrida` int(11) NOT NULL,
  `id_corredor` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela runners_runners.inscricao: 0 rows
/*!40000 ALTER TABLE `inscricao` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscricao` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.2.3-MariaDB-log - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para crud
DROP DATABASE IF EXISTS `crud`;
CREATE DATABASE IF NOT EXISTS `crud` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `crud`;

-- Copiando estrutura para tabela crud.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `data_nascimento` varchar(20) NOT NULL DEFAULT '0',
  `cpf` varchar(20) NOT NULL DEFAULT '0',
  `telefone` varchar(20) NOT NULL DEFAULT '0',
  `cep` varchar(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela crud.user: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `nome`, `email`, `data_nascimento`, `cpf`, `telefone`, `cep`, `created_at`, `updated_at`) VALUES
	(6, 'Ronaldo', 'ronaldo@mutari.com', '05-03-1983', '01391139674', '31991914342', '33600000', '2022-05-09 17:36:01', NULL),
	(7, 'Ronaldo', 'ronaldo@mutari.com', '05-03-1983', '01391139674', '31991914342', '33600000', '2022-05-09 17:36:09', NULL),
	(8, 'Ronaldo', 'ronaldo@mutari.com', '05-03-1983', '01391139674', '31991914342', '33600000', '2022-05-09 17:36:31', NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

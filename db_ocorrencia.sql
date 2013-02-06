-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.24-log
-- Versão do PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `db_ocorrencia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_cidade`
--

CREATE TABLE IF NOT EXISTS `tab_cidade` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cidade` varchar(250) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_falta`
--

CREATE TABLE IF NOT EXISTS `tab_falta` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `colaborador` varchar(250) NOT NULL,
  `motivo` varchar(250) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_final` date DEFAULT NULL,
  `cod_cidade` int(11) NOT NULL,
  `cod_supervisor` int(11) NOT NULL,
  `obs` longtext NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=711 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_ft`
--

CREATE TABLE IF NOT EXISTS `tab_ft` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `colaborador` varchar(250) NOT NULL,
  `data` date NOT NULL,
  `horario` varchar(250) NOT NULL,
  `cod_cidade` int(11) NOT NULL,
  `cod_supervisor` int(11) NOT NULL,
  `obs` longtext NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2237 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_supervisor`
--

CREATE TABLE IF NOT EXISTS `tab_supervisor` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `supervisor` varchar(250) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

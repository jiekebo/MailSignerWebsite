-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2010 at 09:26 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mailsigner`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

USE mailsigner

CREATE TABLE IF NOT EXISTS `countries` (
  `isoName` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`isoName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`isoName`, `name`) VALUES
('DK', 'Denmark'),
('SE', 'Sweden');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `idOrder` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `expires` datetime DEFAULT NULL,
  `dueDate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idOrder`,`idUser`),
  KEY `fk_Order_User` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`idOrder`, `idUser`, `address`, `city`, `postcode`, `date`, `expires`, `dueDate`, `active`) VALUES
(1, 7, '', '', 1234, '2010-10-28 20:37:36', '2011-10-28 20:37:36', '2010-11-27 19:37:36', 1),
(2, 8, '', '', 1234, '2010-10-28 20:37:54', '2011-10-28 20:37:54', '2010-11-27 19:37:54', 1),
(3, 9, '', '', 1234, '2010-10-28 20:38:07', '2011-10-28 20:38:07', '2010-11-27 19:38:07', 1),
(4, 10, '', '', 1234, '2010-10-28 20:38:41', '2011-10-28 20:38:41', '2010-11-27 19:38:41', 1),
(5, 11, '', '', 1234, '2010-10-28 20:39:33', '2011-10-28 20:39:33', '2010-11-27 19:39:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE IF NOT EXISTS `orderitem` (
  `idOrderItems` int(11) NOT NULL AUTO_INCREMENT,
  `idOrder` int(11) NOT NULL,
  `productNumber` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceDKK` float NOT NULL,
  PRIMARY KEY (`idOrderItems`,`idOrder`),
  KEY `fk_OrderItem_Order1` (`idOrder`),
  KEY `fk_OrderItem_Product1` (`productNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`idOrderItems`, `idOrder`, `productNumber`, `quantity`, `priceDKK`) VALUES
(1, 1, 10003, 140, 11200),
(2, 2, 10003, 140, 11200),
(3, 3, 10003, 140, 11200),
(4, 4, 10003, 140, 11200),
(5, 5, 10003, 114, 9120);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productNumber` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `imageLocation` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `productType` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `productState` int(11) NOT NULL,
  `validity` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `priceDKK` float NOT NULL,
  PRIMARY KEY (`productNumber`),
  KEY `fk_Product_ProductType` (`productType`),
  KEY `fk_Product_ProductState1` (`productState`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10007 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productNumber`, `productName`, `description`, `imageLocation`, `productType`, `productState`, `validity`, `quantity`, `priceDKK`) VALUES
(10000, 'MailSigner-10', NULL, NULL, 'MailSigner', 1, 1, 10, 200),
(10001, 'MailSigner-50', NULL, 'img/mailplace.png', 'MailSigner', 1, 1, 50, 150),
(10002, 'MailSigner-100', NULL, NULL, 'MailSigner', 1, 1, 100, 100),
(10003, 'MailSigner-200', NULL, NULL, 'MailSigner', 1, 1, 200, 80),
(10004, 'MailSigner-unlim', NULL, NULL, 'MailSigner', 1, 1, 10000000, 80),
(10005, 'Test Signature', 'Fancy pantsy signature', 'img/sigplace.png', 'Signature', 1, NULL, NULL, 50),
(10006, 'Another test', 'blablabla', 'img/sigplace.png', 'Signature', 1, NULL, NULL, 250);

-- --------------------------------------------------------

--
-- Table structure for table `productstate`
--

CREATE TABLE IF NOT EXISTS `productstate` (
  `productState` int(11) NOT NULL,
  `description` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`productState`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `productstate`
--

INSERT INTO `productstate` (`productState`, `description`) VALUES
(0, 'Deactivated'),
(1, 'Activated');

-- --------------------------------------------------------

--
-- Table structure for table `producttype`
--

CREATE TABLE IF NOT EXISTS `producttype` (
  `productType` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`productType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `producttype`
--

INSERT INTO `producttype` (`productType`) VALUES
('MailSigner'),
('Signature');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `companyName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(34) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `postCode` int(11) NOT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `userType` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`),
  KEY `fk_User_Countries1` (`country`),
  KEY `fk_User_UserType1` (`userType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `companyName`, `firstName`, `lastName`, `mail`, `password`, `address`, `city`, `postCode`, `country`, `userType`, `activated`) VALUES
(7, '', '', '', 'asdfg@asdfg.dk', '$1$bc..IH4.$B84UFiW0oQryktTMIe9WG/', '', '', 1234, 'DK', 'cst', 0),
(8, '', '', '', 'asdfg@asdfg.dk', '$1$Q21.Z20.$q0Gk5FfvGHA4VBQX8LHIT.', '', '', 1234, 'DK', 'cst', 0),
(9, '', '', '', 'asdfg@asdfg.dk', '$1$eT5.Pf..$ikw97CuFrXIOd.CoHqwfm.', '', '', 1234, 'DK', 'cst', 0),
(10, '', '', '', 'asdfg@asdfg.dk', '$1$/G4.aY2.$za2WL47kKS0rknpNGKE3j1', '', '', 1234, 'DK', 'cst', 0),
(11, '', '', '', 'asdfg@asdfg.dk', '$1$SX4.ze5.$5EfCa7CfXcP8fBAU0i0HH/', '', '', 1234, 'DK', 'cst', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `userType` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`userType`) VALUES
('adm'),
('cst');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_Order_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `fk_OrderItem_Order1` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_OrderItem_Product1` FOREIGN KEY (`productNumber`) REFERENCES `product` (`productNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_Product_ProductState1` FOREIGN KEY (`productState`) REFERENCES `productstate` (`productState`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Product_ProductType` FOREIGN KEY (`productType`) REFERENCES `producttype` (`productType`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_Countries1` FOREIGN KEY (`country`) REFERENCES `countries` (`isoName`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_UserType1` FOREIGN KEY (`userType`) REFERENCES `usertype` (`userType`) ON DELETE NO ACTION ON UPDATE NO ACTION;

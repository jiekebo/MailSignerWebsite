-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 09, 2010 at 11:13 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10012 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`idOrder`, `idUser`, `address`, `city`, `postcode`, `date`, `expires`, `dueDate`, `active`) VALUES
(10000, 10000, 'Kronetorpsgatan 70D', 'Malmoe', 21227, '2010-07-08 14:09:26', '2011-07-08 14:09:26', '2010-08-07 14:09:26', 1),
(10001, 10000, 'Kronetorpsgatan 70D', 'Malmoe', 21227, '2010-07-09 13:19:21', NULL, '2010-08-08 13:19:21', 1),
(10002, 10000, 'Kronetorpsgatan 70D', 'Malmoe', 21227, '2010-07-09 13:20:28', NULL, '2010-08-08 13:20:28', 1),
(10003, 10001, 'Kronetorpsgatan 70d', 'Malmö', 21227, '2010-07-09 16:52:24', '2011-07-09 16:52:24', '2010-08-08 16:52:24', 1),
(10007, 10001, 'Kronetorpsgatan 70d', 'Malmö', 21227, '2010-07-09 19:57:34', NULL, '2010-08-08 19:57:34', 1),
(10008, 10002, 'test', 'test', 123, '2010-07-09 19:59:04', '2011-07-09 19:59:04', '2010-08-08 19:59:04', 1),
(10009, 10003, 'asdf', 'asdf', 123, '2010-07-09 22:35:47', '2011-07-09 22:35:47', '2010-08-08 22:35:47', 1),
(10010, 10003, 'asdf', 'asdf', 123, '2010-07-09 22:54:06', '2011-07-09 22:54:06', '2010-08-08 22:54:06', 1),
(10011, 10005, 'test', 'test', 123, '2010-07-09 23:06:31', '2011-07-09 23:06:31', '2010-08-08 23:06:31', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`idOrderItems`, `idOrder`, `productNumber`, `quantity`, `priceDKK`) VALUES
(1, 10000, 10004, 250, 20000),
(2, 10001, 10005, 0, 50),
(3, 10001, 10008, 0, 250000),
(4, 10002, 10006, 1, 250),
(5, 10003, 10003, 150, 12000),
(9, 10007, 10005, 1, 50),
(10, 10007, 10008, 1, 250000),
(11, 10008, 10004, 250, 20000),
(12, 10009, 10003, 123, 9840),
(13, 10010, 10003, 123, 9840),
(14, 10011, 10001, 45, 6750);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10009 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productNumber`, `productName`, `description`, `imageLocation`, `productType`, `productState`, `validity`, `quantity`, `priceDKK`) VALUES
(10000, 'MailSigner-10', NULL, NULL, 'MailSigner', 1, 1, 10, 200),
(10001, 'MailSigner-50', NULL, NULL, 'MailSigner', 1, 1, 50, 150),
(10002, 'MailSigner-100', NULL, NULL, 'MailSigner', 1, 1, 100, 100),
(10003, 'MailSigner-200', NULL, NULL, 'MailSigner', 1, 1, 200, 80),
(10004, 'MailSigner-unlim', NULL, NULL, 'MailSigner', 1, 1, 10000000, 80),
(10005, 'Test Signature', 'Fancy pantsy signature', '/img/signatures/test.jpg', 'Signature', 1, NULL, NULL, 50),
(10006, 'Another test', 'blabla', '/img/signatures/alsotest.png', 'Signature', 1, NULL, NULL, 250),
(10007, 'Deactivated signature', 'Just testing', '//', 'Signature', 0, NULL, NULL, 2500),
(10008, 'Test3', 'blabla', '6asdf', 'Signature', 1, NULL, NULL, 250000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10006 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `companyName`, `firstName`, `lastName`, `mail`, `password`, `address`, `city`, `postCode`, `country`, `userType`, `activated`) VALUES
(10000, 'Mailsigner Inc.', 'Jacob', 'Salomonsen', 'jiekebo@gmail.com', '$1$hP1.WY2.$FKqZKLlxCQnPB/MD16bkT1', 'Kronetorpsgatan 70D', 'Malmoe', 21227, 'SE', 'cst', 1),
(10001, 'Test', 'Haiyan', 'Wang', 'examinition@gmail.com', '$1$NB..Sg1.$D3sSl0R7fCoUZPPF..9QF0', 'Kronetorpsgatan 70d', 'Malmö', 21227, 'SE', 'cst', 0),
(10002, 'Test', 'test', 'test', 'test@test.com', '$1$bg2.I5/.$lhDksWTkO3337p6i2Oqb.0', 'test', 'test', 123, 'DK', 'cst', 0),
(10003, 'asdf', 'asdf', 'asdf', 'asdf@as.com', '$1$Tj0.g.3.$wFBck4oOJHvIt9LIVDwGE.', 'asdf', 'asdf', 123, 'SE', 'cst', 0),
(10004, 'asdf', 'asdf', 'asdf', 'asdf@as.com', '$1$pf1.805.$QJEqzXSWWapU8BtMj9n.J.', 'asdf', 'asdf', 123, 'SE', 'cst', 0),
(10005, 'tset', 'test', 'test', 'test@ts.com', '$1$.4/.tC0.$mKbLk/1tEv6sTrlwIMXqe0', 'test', 'test', 123, 'SE', 'cst', 0);

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

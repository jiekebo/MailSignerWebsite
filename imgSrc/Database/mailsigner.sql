-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Vært: custsql-ipg16.eigbox.net
-- Genereringstid: 14/05 2013 kl. 14:43:23
-- Serverversion: 5.0.91
-- PHP version: 4.4.9
-- 
-- Database: `mailsigner`
-- 

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `Countries`
-- 

CREATE TABLE `Countries` (
  `isoName` varchar(2) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`isoName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `Countries`
-- 

INSERT INTO `Countries` VALUES ('DK', 'Denmark');
INSERT INTO `Countries` VALUES ('SE', 'Sweden');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `Order`
-- 

CREATE TABLE `Order` (
  `idOrder` int(11) NOT NULL auto_increment,
  `idUser` int(11) NOT NULL,
  `address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `postcode` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `expires` datetime default NULL,
  `dueDate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`idOrder`,`idUser`),
  KEY `fk_Order_User` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=10066 DEFAULT CHARSET=latin1 AUTO_INCREMENT=10066 ;

-- 
-- Data dump for tabellen `Order`
-- 

INSERT INTO `Order` VALUES (10065, 10058, '', '', 0, '2010-12-07 14:03:43', '2011-01-06 14:03:43', '2011-01-06 14:03:43', 1);
INSERT INTO `Order` VALUES (10064, 10057, '', '', 0, '2010-12-07 13:53:24', '2011-01-06 13:53:24', '2011-01-06 13:53:24', 1);
INSERT INTO `Order` VALUES (10063, 10056, '', '', 0, '2010-12-07 12:27:46', '2011-01-06 12:27:46', '2011-01-06 12:27:46', 1);
INSERT INTO `Order` VALUES (10062, 10055, 'Kronetorpsgatan 70D', 'MalmÃ¶', 21227, '2010-12-03 17:37:16', '2011-12-03 17:37:16', '2011-01-02 17:37:16', 1);
INSERT INTO `Order` VALUES (10061, 10054, 'asdfg', 'asdfg', 1234, '2010-11-08 16:29:16', '2011-11-08 16:29:16', '2010-12-08 16:29:16', 1);
INSERT INTO `Order` VALUES (10060, 10053, 'asdfg', 'asdfg', 1234, '2010-11-08 16:28:34', '2011-11-08 16:28:34', '2010-12-08 16:28:34', 1);
INSERT INTO `Order` VALUES (10059, 10052, '', '', 0, '2010-11-08 13:09:12', '2010-12-08 13:09:12', '2010-12-08 13:09:12', 1);
INSERT INTO `Order` VALUES (10058, 10051, '', '', 0, '2010-11-08 13:04:38', '2010-12-08 13:04:38', '2010-12-08 13:04:38', 1);
INSERT INTO `Order` VALUES (10049, 10042, 'Staktoften 16', 'Vedbæk', 2950, '2010-08-12 03:44:21', '2012-08-12 03:44:21', '2010-09-11 03:44:21', 1);
INSERT INTO `Order` VALUES (10057, 10050, '', '', 0, '2010-11-08 13:04:05', '2010-12-08 13:04:05', '2010-12-08 13:04:05', 1);
INSERT INTO `Order` VALUES (10056, 10049, '', '', 0, '2010-11-08 13:01:19', '2010-12-08 13:01:19', '2010-12-08 13:01:19', 1);
INSERT INTO `Order` VALUES (10052, 10045, 'Kronetorpsgatan 70D', 'Malmoe', 21227, '2010-10-29 04:59:23', '2011-10-29 04:59:23', '2010-11-28 03:59:23', 1);
INSERT INTO `Order` VALUES (10053, 10046, 'Kronetorpsgatan 70D', 'MalmÃ¶', 21227, '2010-10-30 15:39:26', '2011-10-30 15:39:26', '2010-11-29 14:39:26', 1);
INSERT INTO `Order` VALUES (10054, 10047, 'asdfg', 'asdfg', 0, '2010-11-07 14:48:53', '2010-12-07 14:48:53', '2010-12-07 14:48:53', 1);
INSERT INTO `Order` VALUES (10055, 10048, '', '', 0, '2010-11-08 12:59:58', '2010-12-08 12:59:58', '2010-12-08 12:59:58', 1);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `OrderItem`
-- 

CREATE TABLE `OrderItem` (
  `idOrderItems` int(11) NOT NULL auto_increment,
  `idOrder` int(11) NOT NULL,
  `productNumber` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceDKK` float NOT NULL,
  PRIMARY KEY  (`idOrderItems`,`idOrder`),
  KEY `fk_OrderItem_Order1` (`idOrder`),
  KEY `fk_OrderItem_Product1` (`productNumber`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- 
-- Data dump for tabellen `OrderItem`
-- 

INSERT INTO `OrderItem` VALUES (65, 10065, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (64, 10064, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (63, 10063, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (62, 10062, 10005, 250, 12500);
INSERT INTO `OrderItem` VALUES (61, 10061, 10003, 196, 15680);
INSERT INTO `OrderItem` VALUES (60, 10060, 10002, 81, 8100);
INSERT INTO `OrderItem` VALUES (59, 10059, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (58, 10058, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (57, 10057, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (56, 10056, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (55, 10055, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (54, 10054, 10000, 10, 2000);
INSERT INTO `OrderItem` VALUES (53, 10053, 10003, 154, 12320);
INSERT INTO `OrderItem` VALUES (52, 10052, 10004, 200, 16000);
INSERT INTO `OrderItem` VALUES (49, 10049, 10004, 350, 28000);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `Product`
-- 

CREATE TABLE `Product` (
  `productNumber` int(11) NOT NULL auto_increment,
  `productName` varchar(45) NOT NULL,
  `description` longtext,
  `imageLocation` varchar(45) default NULL,
  `productType` varchar(45) NOT NULL,
  `productState` int(11) NOT NULL,
  `validity` int(11) default NULL,
  `quantity` int(11) default NULL,
  `priceDKK` float NOT NULL,
  PRIMARY KEY  (`productNumber`),
  KEY `fk_Product_ProductType` (`productType`),
  KEY `fk_Product_ProductState1` (`productState`)
) ENGINE=MyISAM AUTO_INCREMENT=10021 DEFAULT CHARSET=latin1 AUTO_INCREMENT=10021 ;

-- 
-- Data dump for tabellen `Product`
-- 

INSERT INTO `Product` VALUES (10000, 'MailSigner-10', NULL, '/img/mailplace.png', 'MailSigner', 1, 1, 10, 200);
INSERT INTO `Product` VALUES (10001, 'MailSigner-50', NULL, '/img/mailplace.png', 'MailSigner', 1, 1, 50, 150);
INSERT INTO `Product` VALUES (10002, 'MailSigner-100', NULL, '/img/mailplace.png', 'MailSigner', 1, 1, 100, 100);
INSERT INTO `Product` VALUES (10003, 'MailSigner-200', NULL, '/img/mailplace.png', 'MailSigner', 1, 1, 200, 80);
INSERT INTO `Product` VALUES (10005, 'MailSigner-unlim', NULL, '/img/mailplace.png', 'MailSigner', 1, 1, 10000000, 50);
INSERT INTO `Product` VALUES (10020, 'Test Signature', 'Fancy pantsy signature', '/img/sigplace.png', 'Signature', 1, NULL, NULL, 50);
INSERT INTO `Product` VALUES (10004, 'MailSigner-500', NULL, '/img/mailplace.png', 'MailSigner', 1, 1, 500, 55);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `ProductState`
-- 

CREATE TABLE `ProductState` (
  `productState` int(11) NOT NULL,
  `description` varchar(45) default NULL,
  PRIMARY KEY  (`productState`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `ProductState`
-- 

INSERT INTO `ProductState` VALUES (0, 'Deactivated');
INSERT INTO `ProductState` VALUES (1, 'Activated');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `ProductType`
-- 

CREATE TABLE `ProductType` (
  `productType` varchar(45) NOT NULL,
  PRIMARY KEY  (`productType`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `ProductType`
-- 

INSERT INTO `ProductType` VALUES ('MailSigner');
INSERT INTO `ProductType` VALUES ('Signature');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `User`
-- 

CREATE TABLE `User` (
  `idUser` int(11) NOT NULL auto_increment,
  `companyName` varchar(45) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `password` varchar(34) NOT NULL,
  `address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `postCode` int(11) NOT NULL,
  `country` varchar(2) NOT NULL,
  `userType` varchar(3) NOT NULL,
  `activated` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`idUser`),
  KEY `fk_User_Countries1` (`country`),
  KEY `fk_User_UserType1` (`userType`)
) ENGINE=MyISAM AUTO_INCREMENT=10059 DEFAULT CHARSET=latin1 AUTO_INCREMENT=10059 ;

-- 
-- Data dump for tabellen `User`
-- 

INSERT INTO `User` VALUES (10057, 'demo', 'demo', 'demo', 'info@mailsigner.com', '$1$Ipk204ni$t6DDEhm2xAtt2h/h.UnS40', 'demo', 'demo', 0, 'DK', 'dmo', 0);
INSERT INTO `User` VALUES (10058, 'demo', 'demo', 'demo', 'info@mailsigner.com', '$1$4ShIvUQM$0pPq5vR1.xFpR95OLcrLQ1', 'demo', 'demo', 0, 'DK', 'dmo', 1);
INSERT INTO `User` VALUES (10056, 'demo', 'demo', 'demo', 'info@mailsigner.com', '$1$KPWVaRx7$oICQyatWjVrOwwSsqhb0Q0', 'demo', 'demo', 0, 'DK', 'dmo', 0);
INSERT INTO `User` VALUES (10055, 'MailSigner', 'info', 'mailsigner', 'info@mailsigner.com', '$1$cJ3uxIT2$2Ph/ohNlcRmee7hiHTh2U/', 'Kronetorpsgatan 70D', 'MalmÃ¶', 21227, 'SE', 'cst', 0);
INSERT INTO `User` VALUES (10050, 'demo', 'demo', 'demo', 'examinition@gmail.com', '$1$UDy6GpRt$MqUtajZ/.lO41zb/Kg0Th0', 'demo', 'demo', 0, 'DK', 'dmo', 1);
INSERT INTO `User` VALUES (10054, 'asdfg', 'adsfg', 'asdfg', 'examinition@gmail.com', '$1$hz5.FsWQ$mWJlfyXyxjb8IJryMMh04.', 'asdfg', 'asdfg', 1234, 'DK', 'cst', 1);
INSERT INTO `User` VALUES (10042, 'Multi-Wing', 'Thomas', 'Hansen', 'thh@multi-wing.com', '$1$7rck2uPf$pJPic8KxFzUdn1TUDeMlw.', 'Staktoften 16', 'Vedbæk', 2950, 'DK', 'cst', 1);
INSERT INTO `User` VALUES (10045, 'MailSigner', 'Jacob', 'Salomonsen', 'jiekebo@gmail.com', '$1$F3tLmvC7$/68JYjHcwJfoXTBwYdl0H1', 'Kronetorpsgatan 70D', 'Malmoe', 21227, 'DK', 'cst', 1);
INSERT INTO `User` VALUES (10053, 'asdfg', 'adsfg', 'asdfg', 'examinition@gmail.com', '$1$DnH5JmHC$t8MeoC4mY5MSx/l8IPLx60', 'asdfg', 'asdfg', 1234, 'DK', 'cst', 0);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `UserType`
-- 

CREATE TABLE `UserType` (
  `userType` varchar(3) NOT NULL,
  PRIMARY KEY  (`userType`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `UserType`
-- 

INSERT INTO `UserType` VALUES ('adm');
INSERT INTO `UserType` VALUES ('cst');
INSERT INTO `UserType` VALUES ('dmo');

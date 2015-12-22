/*
Navicat MySQL Data Transfer

Source Server         : wampo
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : mysearch

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-11-16 15:59:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dictionary`
-- ----------------------------
DROP TABLE IF EXISTS `dictionary`;
CREATE TABLE `dictionary` (
  `word` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  PRIMARY KEY (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dictionary
-- ----------------------------
INSERT INTO `dictionary` VALUES ('1947', '1');
INSERT INTO `dictionary` VALUES ('as', '1');
INSERT INTO `dictionary` VALUES ('been', '1');
INSERT INTO `dictionary` VALUES ('before', '1');
INSERT INTO `dictionary` VALUES ('belongs', '1');
INSERT INTO `dictionary` VALUES ('but', '1');
INSERT INTO `dictionary` VALUES ('decided', '1');
INSERT INTO `dictionary` VALUES ('england', '2');
INSERT INTO `dictionary` VALUES ('friendship', '1');
INSERT INTO `dictionary` VALUES ('georgia', '1');
INSERT INTO `dictionary` VALUES ('had', '1');
INSERT INTO `dictionary` VALUES ('he', '2');
INSERT INTO `dictionary` VALUES ('her', '3');
INSERT INTO `dictionary` VALUES ('hi', '1');
INSERT INTO `dictionary` VALUES ('in', '1');
INSERT INTO `dictionary` VALUES ('india', '2');
INSERT INTO `dictionary` VALUES ('is', '1');
INSERT INTO `dictionary` VALUES ('lives', '1');
INSERT INTO `dictionary` VALUES ('loved', '1');
INSERT INTO `dictionary` VALUES ('might', '1');
INSERT INTO `dictionary` VALUES ('much,', '1');
INSERT INTO `dictionary` VALUES ('my', '1');
INSERT INTO `dictionary` VALUES ('name', '2');
INSERT INTO `dictionary` VALUES ('not', '2');
INSERT INTO `dictionary` VALUES ('over', '1');
INSERT INTO `dictionary` VALUES ('queen', '1');
INSERT INTO `dictionary` VALUES ('rajat', '2');
INSERT INTO `dictionary` VALUES ('ruined', '1');
INSERT INTO `dictionary` VALUES ('ruled', '1');
INSERT INTO `dictionary` VALUES ('she', '1');
INSERT INTO `dictionary` VALUES ('tell', '2');
INSERT INTO `dictionary` VALUES ('their', '1');
INSERT INTO `dictionary` VALUES ('to', '3');
INSERT INTO `dictionary` VALUES ('tried', '1');
INSERT INTO `dictionary` VALUES ('very', '1');
INSERT INTO `dictionary` VALUES ('was', '1');

-- ----------------------------
-- Table structure for `documents`
-- ----------------------------
DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `doc_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`doc_id`,`word`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of documents
-- ----------------------------
INSERT INTO `documents` VALUES ('1', 'hi');
INSERT INTO `documents` VALUES ('1', 'is');
INSERT INTO `documents` VALUES ('1', 'my');
INSERT INTO `documents` VALUES ('1', 'name');
INSERT INTO `documents` VALUES ('1', 'rajat');
INSERT INTO `documents` VALUES ('2', '1947');
INSERT INTO `documents` VALUES ('2', 'before');
INSERT INTO `documents` VALUES ('2', 'england');
INSERT INTO `documents` VALUES ('2', 'india');
INSERT INTO `documents` VALUES ('2', 'over');
INSERT INTO `documents` VALUES ('2', 'ruled');
INSERT INTO `documents` VALUES ('3', 'as');
INSERT INTO `documents` VALUES ('3', 'been');
INSERT INTO `documents` VALUES ('3', 'but');
INSERT INTO `documents` VALUES ('3', 'friendship');
INSERT INTO `documents` VALUES ('3', 'had');
INSERT INTO `documents` VALUES ('3', 'he');
INSERT INTO `documents` VALUES ('3', 'her');
INSERT INTO `documents` VALUES ('3', 'loved');
INSERT INTO `documents` VALUES ('3', 'might');
INSERT INTO `documents` VALUES ('3', 'much,');
INSERT INTO `documents` VALUES ('3', 'not');
INSERT INTO `documents` VALUES ('3', 'ruined');
INSERT INTO `documents` VALUES ('3', 'tell');
INSERT INTO `documents` VALUES ('3', 'their');
INSERT INTO `documents` VALUES ('3', 'to');
INSERT INTO `documents` VALUES ('3', 'tried');
INSERT INTO `documents` VALUES ('3', 'very');
INSERT INTO `documents` VALUES ('4', 'in');
INSERT INTO `documents` VALUES ('4', 'india');
INSERT INTO `documents` VALUES ('4', 'lives');
INSERT INTO `documents` VALUES ('4', 'rajat');
INSERT INTO `documents` VALUES ('5', 'belongs');
INSERT INTO `documents` VALUES ('5', 'england');
INSERT INTO `documents` VALUES ('5', 'he');
INSERT INTO `documents` VALUES ('5', 'to');
INSERT INTO `documents` VALUES ('6', 'decided');
INSERT INTO `documents` VALUES ('6', 'georgia');
INSERT INTO `documents` VALUES ('6', 'her');
INSERT INTO `documents` VALUES ('6', 'name');
INSERT INTO `documents` VALUES ('6', 'not');
INSERT INTO `documents` VALUES ('6', 'queen');
INSERT INTO `documents` VALUES ('6', 'she');
INSERT INTO `documents` VALUES ('6', 'tell');
INSERT INTO `documents` VALUES ('6', 'to');
INSERT INTO `documents` VALUES ('6', 'was');

-- ----------------------------
-- Table structure for `inverted_index`
-- ----------------------------
DROP TABLE IF EXISTS `inverted_index`;
CREATE TABLE `inverted_index` (
  `word` varchar(255) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`word`,`doc_id`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of inverted_index
-- ----------------------------
INSERT INTO `inverted_index` VALUES ('1947', '2', '5');
INSERT INTO `inverted_index` VALUES ('as', '3', '11');
INSERT INTO `inverted_index` VALUES ('been', '3', '16');
INSERT INTO `inverted_index` VALUES ('before', '2', '4');
INSERT INTO `inverted_index` VALUES ('belongs', '5', '1');
INSERT INTO `inverted_index` VALUES ('but', '3', '5');
INSERT INTO `inverted_index` VALUES ('decided', '6', '1');
INSERT INTO `inverted_index` VALUES ('england', '2', '0');
INSERT INTO `inverted_index` VALUES ('england', '5', '3');
INSERT INTO `inverted_index` VALUES ('friendship', '3', '13');
INSERT INTO `inverted_index` VALUES ('georgia', '6', '9');
INSERT INTO `inverted_index` VALUES ('had', '3', '15');
INSERT INTO `inverted_index` VALUES ('he', '3', '0');
INSERT INTO `inverted_index` VALUES ('he', '5', '0');
INSERT INTO `inverted_index` VALUES ('her', '3', '2');
INSERT INTO `inverted_index` VALUES ('her', '3', '10');
INSERT INTO `inverted_index` VALUES ('her', '6', '5');
INSERT INTO `inverted_index` VALUES ('hi', '1', '0');
INSERT INTO `inverted_index` VALUES ('in', '4', '2');
INSERT INTO `inverted_index` VALUES ('india', '2', '3');
INSERT INTO `inverted_index` VALUES ('india', '4', '3');
INSERT INTO `inverted_index` VALUES ('is', '1', '3');
INSERT INTO `inverted_index` VALUES ('lives', '4', '1');
INSERT INTO `inverted_index` VALUES ('loved', '3', '1');
INSERT INTO `inverted_index` VALUES ('might', '3', '14');
INSERT INTO `inverted_index` VALUES ('much,', '3', '4');
INSERT INTO `inverted_index` VALUES ('my', '1', '1');
INSERT INTO `inverted_index` VALUES ('name', '1', '2');
INSERT INTO `inverted_index` VALUES ('name', '6', '6');
INSERT INTO `inverted_index` VALUES ('not', '3', '7');
INSERT INTO `inverted_index` VALUES ('not', '6', '2');
INSERT INTO `inverted_index` VALUES ('over', '2', '2');
INSERT INTO `inverted_index` VALUES ('queen', '6', '8');
INSERT INTO `inverted_index` VALUES ('rajat', '1', '4');
INSERT INTO `inverted_index` VALUES ('rajat', '4', '0');
INSERT INTO `inverted_index` VALUES ('ruined', '3', '17');
INSERT INTO `inverted_index` VALUES ('ruled', '2', '1');
INSERT INTO `inverted_index` VALUES ('she', '6', '0');
INSERT INTO `inverted_index` VALUES ('tell', '3', '9');
INSERT INTO `inverted_index` VALUES ('tell', '6', '4');
INSERT INTO `inverted_index` VALUES ('their', '3', '12');
INSERT INTO `inverted_index` VALUES ('to', '3', '8');
INSERT INTO `inverted_index` VALUES ('to', '5', '2');
INSERT INTO `inverted_index` VALUES ('to', '6', '3');
INSERT INTO `inverted_index` VALUES ('tried', '3', '6');
INSERT INTO `inverted_index` VALUES ('very', '3', '3');
INSERT INTO `inverted_index` VALUES ('was', '6', '7');

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'Hi my name is Rajat');
INSERT INTO `pages` VALUES ('2', 'England ruled over India before 1947');
INSERT INTO `pages` VALUES ('3', 'He loved her very much, but tried not to tell her as their friendship might had been ruined');
INSERT INTO `pages` VALUES ('4', 'Rajat lives in India');
INSERT INTO `pages` VALUES ('5', 'He belongs to England');
INSERT INTO `pages` VALUES ('6', 'She decided not to tell her name was Queen Georgia');

/*
Navicat MySQL Data Transfer

Source Server         : con
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-07 13:25:25
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', 'Sport', 'active');
INSERT INTO `category` VALUES ('2', 'Politics', 'active');
INSERT INTO `category` VALUES ('3', 'IT', 'active');

-- ----------------------------
-- Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `content` text,
  `user_id` int(11) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`post_id`),
  KEY `uid` (`user_id`),
  CONSTRAINT `pid` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `uid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('2', '1', 'test comment', '38', '2017-06-30', 'active');
INSERT INTO `comment` VALUES ('6', '1', 'test', '38', '2017-06-30', 'active');
INSERT INTO `comment` VALUES ('7', '1', 'test2', '38', '2017-06-30', 'active');
INSERT INTO `comment` VALUES ('8', '1', 'test2', '38', '2017-06-30', 'active');
INSERT INTO `comment` VALUES ('9', '1', 'test3', '38', '2017-06-30', 'active');
INSERT INTO `comment` VALUES ('22', '1', 'asd', '38', '2017-06-30', 'active');

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `content` text,
  `category_id` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `pub_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat` (`category_id`),
  CONSTRAINT `cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('1', 'News in IT', 'Content', '3', 'active', '2017-06-29');
INSERT INTO `post` VALUES ('2', 'Another News Item', 'test content', '3', 'active', '2017-06-30');

-- ----------------------------
-- Table structure for `postimage`
-- ----------------------------
DROP TABLE IF EXISTS `postimage`;
CREATE TABLE `postimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid1` (`post_id`),
  CONSTRAINT `pid1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of postimage
-- ----------------------------
INSERT INTO `postimage` VALUES ('7', 'it.jpg', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `role` varchar(11) DEFAULT NULL,
  `password` text,
  `password_salt` text,
  `datetime_registration` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('35', 'alex1', 'al@gmail.com', '1', 'user', '1', null, '2017-06-29 12:25:57');
INSERT INTO `user` VALUES ('36', 'a', 'al@gmail.com', '1', 'user', '1', null, '2017-06-29 12:36:47');
INSERT INTO `user` VALUES ('37', 'aa', 'al@gmail.com', '1', 'user', '1', null, '2017-06-29 12:38:04');
INSERT INTO `user` VALUES ('38', 'a1', 'al@gmail.com', '1', 'admin', '1', null, '2017-06-29 12:42:55');

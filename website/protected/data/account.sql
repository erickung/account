/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : account

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-07-14 01:36:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` varchar(64) NOT NULL DEFAULT '' COMMENT '收款账号',
  `account_name` varchar(32) NOT NULL DEFAULT '' COMMENT '收款人名称',
  `bank_name` varchar(64) NOT NULL DEFAULT '' COMMENT '开户支行',
  `account_province` varchar(16) NOT NULL DEFAULT '' COMMENT '收款行所在省',
  `account_city` varchar(32) NOT NULL DEFAULT '' COMMENT '收款行所在市',
  `bank_all_name` varchar(128) NOT NULL DEFAULT '' COMMENT '开户银行',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('1', '32133313131222222223', '孔繁兴', '农行北京中关村支行', '北京', '北京', '农行北京中关村支行');
INSERT INTO `customer` VALUES ('6', '3213331313122222222333', '孔繁兴1', '农行北京中关村支行11', '北京2', '北京3', '农行北京中关村支行3313');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(63) NOT NULL,
  `user_name` varchar(32) NOT NULL COMMENT '用户名称',
  `user_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态（1：有效；0：无效）',
  `last_login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '最后登录时间',
  `token` char(32) NOT NULL COMMENT '登录token',
  `password` char(40) NOT NULL COMMENT '密码',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'eric1@sina.com', 'eric1', '1', '0000-00-00 00:00:00', '1fd06b7d50b11ea26183dc796938a45c', '7c4a8d09ca3762af61e59520943dc26494f8941b');

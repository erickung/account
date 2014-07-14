/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : account

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-07-14 17:46:40
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_no` (`account_no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('1', '32133313131222222223', '孔繁兴', '农行北京中关村支行', '北京', '北京', '农行北京中关村支行');
INSERT INTO `customer` VALUES ('6', '6225603688111111', '于浩', '北京市招商银行万达支行', '北京', '北京', '招商银行');
INSERT INTO `customer` VALUES ('7', '3213331313122222222', '孔繁兴', '农行北京中关村支行', '北京', '北京', '农业银行');

-- ----------------------------
-- Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:提现',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>succ,-1=>false',
  `error_msg` varchar(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES ('1', '1', '1', '');
INSERT INTO `log` VALUES ('2', '1', '1', '');
INSERT INTO `log` VALUES ('3', '1', '1', '');
INSERT INTO `log` VALUES ('4', '1', '1', '');
INSERT INTO `log` VALUES ('5', '1', '-1', '请求报文解析失败');
INSERT INTO `log` VALUES ('6', '1', '1', '');
INSERT INTO `log` VALUES ('7', '1', '1', '');
INSERT INTO `log` VALUES ('8', '1', '1', '');
INSERT INTO `log` VALUES ('9', '1', '1', '');
INSERT INTO `log` VALUES ('10', '1', '-1', '请求失败，请重试');
INSERT INTO `log` VALUES ('11', '1', '-1', '请求失败，请重试');
INSERT INTO `log` VALUES ('12', '1', '1', '');

-- ----------------------------
-- Table structure for `to_account`
-- ----------------------------
DROP TABLE IF EXISTS `to_account`;
CREATE TABLE `to_account` (
  `ta_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL COMMENT '充值金额',
  `fee` int(11) NOT NULL COMMENT '手续费',
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ta_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `to_account_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of to_account
-- ----------------------------
INSERT INTO `to_account` VALUES ('1', '6', '1000', '10', '2014-07-14 13:50:25');

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
INSERT INTO `user` VALUES ('1', 'eric1@sina.com', 'eric1', '1', '2014-07-14 15:02:44', '277659b549348d6bb7b3527349d2d6a2', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- ----------------------------
-- Table structure for `withdrawals_log`
-- ----------------------------
DROP TABLE IF EXISTS `withdrawals_log`;
CREATE TABLE `withdrawals_log` (
  `wd_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wd_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `withdrawals_log_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of withdrawals_log
-- ----------------------------
INSERT INTO `withdrawals_log` VALUES ('1', '101', '6', '0');
INSERT INTO `withdrawals_log` VALUES ('3', '101', '6', '0');
INSERT INTO `withdrawals_log` VALUES ('4', '101', '6', '0');
INSERT INTO `withdrawals_log` VALUES ('5', '101', '6', '0');
INSERT INTO `withdrawals_log` VALUES ('6', '101', '7', '0');
INSERT INTO `withdrawals_log` VALUES ('7', '101', '6', '0');

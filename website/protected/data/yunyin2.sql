/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : yunyin

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-04-12 18:06:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `modules`
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(31) NOT NULL DEFAULT '' COMMENT '模块名称',
  `parent_module_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父节点ID',
  `is_action` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是操作节点（叶子节点）',
  `controller` varchar(31) NOT NULL COMMENT 'controller的ID',
  `action` varchar(255) NOT NULL COMMENT 'action的ID',
  `modify_username` varchar(31) NOT NULL,
  `modify_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `ordering` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES ('1', '系统管理', '0', '0', '', '', '', '2014-04-07 00:48:39', '0');
INSERT INTO `modules` VALUES ('2', '用户管理', '1', '0', 'admin.user', 'list', '', '2014-04-07 19:41:52', '0');
INSERT INTO `modules` VALUES ('3', '用户列表', '2', '1', 'admin.user', 'list', '', '2014-04-07 19:42:10', '0');
INSERT INTO `modules` VALUES ('4', '权限管理', '1', '0', 'admin.modules', 'list', '', '2014-04-07 19:42:46', '0');
INSERT INTO `modules` VALUES ('5', '模块列表', '4', '1', 'admin.modules', 'list', '', '2014-04-07 19:42:59', '0');
INSERT INTO `modules` VALUES ('6', '模块增改', '4', '1', 'admin.modules', 'CModuleAdd,Edit,CEdit,ModuleInfo', '', '2014-04-07 19:43:12', '0');
INSERT INTO `modules` VALUES ('7', '用户增改', '2', '1', 'admin.user', 'Userinfo,UserEdit', '', '2014-04-07 19:42:29', '0');
INSERT INTO `modules` VALUES ('8', '角色管理', '1', '0', 'admin.role', 'list', '', '2014-04-07 19:43:25', '0');
INSERT INTO `modules` VALUES ('9', '角色列表', '8', '1', 'admin.role', 'list', '', '2014-04-07 19:43:41', '0');
INSERT INTO `modules` VALUES ('10', '角色增改', '8', '1', 'admin.role', 'Roleinfo,Edit', 'eric1', '2014-04-09 23:08:44', '0');
INSERT INTO `modules` VALUES ('11', '产品管理', '0', '0', '', '', '', '2014-04-07 19:36:34', '80');
INSERT INTO `modules` VALUES ('12', '产品管理', '11', '0', 'product.manage', 'list', 'eric1', '2014-04-09 21:50:37', '80');
INSERT INTO `modules` VALUES ('13', '产品列表', '12', '1', 'product.manage', 'list', '', '2014-04-07 19:41:04', '0');
INSERT INTO `modules` VALUES ('14', '销售管理', '0', '0', '', '', '', '2014-04-07 19:44:35', '70');
INSERT INTO `modules` VALUES ('15', '客户管理', '14', '0', 'sales.customer', 'list', '', '2014-04-07 19:46:59', '20');
INSERT INTO `modules` VALUES ('16', '产品预约', '14', '0', 'sales.product', 'list', '', '2014-04-07 19:47:53', '18');
INSERT INTO `modules` VALUES ('17', '销售跟踪', '14', '0', 'sales.track', 'list', '', '2014-04-07 19:48:38', '14');
INSERT INTO `modules` VALUES ('18', '产品设置', '11', '0', 'product.manage', 'setting', 'eric1', '2014-04-09 22:07:53', '70');

-- ----------------------------
-- Table structure for `process`
-- ----------------------------
DROP TABLE IF EXISTS `process`;
CREATE TABLE `process` (
  `process_id` int(11) NOT NULL,
  `process_name` varchar(64) NOT NULL,
  `role_ids` varchar(255) NOT NULL,
  PRIMARY KEY (`process_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of process
-- ----------------------------

-- ----------------------------
-- Table structure for `product_account_information`
-- ----------------------------
DROP TABLE IF EXISTS `product_account_information`;
CREATE TABLE `product_account_information` (
  `product_id` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_bank` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`),
  CONSTRAINT `product_account_information_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_account_information
-- ----------------------------

-- ----------------------------
-- Table structure for `product_info`
-- ----------------------------
DROP TABLE IF EXISTS `product_info`;
CREATE TABLE `product_info` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `fund_size` int(11) NOT NULL COMMENT '单位为万元',
  `publish_start_date` int(11) NOT NULL,
  `publish_end_date` int(11) NOT NULL,
  `build_date` int(11) NOT NULL,
  `funds_source` varchar(255) NOT NULL,
  `income_distribution_cycle` tinyint(1) NOT NULL,
  `note` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_info
-- ----------------------------
INSERT INTO `product_info` VALUES ('1', '测试1', '2', '1000000', '1396540800', '1398700800', '1398787200', '大家的1', '0', '111', '0');

-- ----------------------------
-- Table structure for `product_publish_rate`
-- ----------------------------
DROP TABLE IF EXISTS `product_publish_rate`;
CREATE TABLE `product_publish_rate` (
  `publish_rate_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `money` int(11) NOT NULL COMMENT '金额(万)',
  `min_rate` double(11,4) NOT NULL,
  `max_rate` double(11,4) NOT NULL,
  PRIMARY KEY (`publish_rate_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_publish_rate_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_publish_rate
-- ----------------------------

-- ----------------------------
-- Table structure for `product_return_rate`
-- ----------------------------
DROP TABLE IF EXISTS `product_return_rate`;
CREATE TABLE `product_return_rate` (
  `return_rate_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `min_rate` double(11,4) NOT NULL,
  `max_rate` double(11,4) NOT NULL,
  PRIMARY KEY (`return_rate_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_return_rate_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_return_rate
-- ----------------------------

-- ----------------------------
-- Table structure for `product_role`
-- ----------------------------
DROP TABLE IF EXISTS `product_role`;
CREATE TABLE `product_role` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_name` varchar(64) NOT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_role
-- ----------------------------
INSERT INTO `product_role` VALUES ('1', '产品经理');
INSERT INTO `product_role` VALUES ('2', '产品总监');
INSERT INTO `product_role` VALUES ('3', '副总裁');
INSERT INTO `product_role` VALUES ('4', '总裁');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(31) NOT NULL COMMENT '角色名称',
  `modify_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `modify_username` varchar(31) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '系统管理员', '2014-04-09 21:52:21', 'eric1');
INSERT INTO `roles` VALUES ('2', '产品管理', '2014-04-09 21:52:15', 'eric1');

-- ----------------------------
-- Table structure for `role_module`
-- ----------------------------
DROP TABLE IF EXISTS `role_module`;
CREATE TABLE `role_module` (
  `role_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`module_id`),
  KEY `role_id` (`role_id`),
  KEY `crm_module_id` (`module_id`),
  CONSTRAINT `crm_module_id` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE,
  CONSTRAINT `crm_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_module
-- ----------------------------
INSERT INTO `role_module` VALUES ('1', '1');
INSERT INTO `role_module` VALUES ('1', '2');
INSERT INTO `role_module` VALUES ('1', '3');
INSERT INTO `role_module` VALUES ('1', '4');
INSERT INTO `role_module` VALUES ('1', '5');
INSERT INTO `role_module` VALUES ('1', '6');
INSERT INTO `role_module` VALUES ('1', '7');
INSERT INTO `role_module` VALUES ('1', '8');
INSERT INTO `role_module` VALUES ('1', '9');
INSERT INTO `role_module` VALUES ('1', '10');
INSERT INTO `role_module` VALUES ('1', '11');
INSERT INTO `role_module` VALUES ('1', '12');
INSERT INTO `role_module` VALUES ('1', '13');
INSERT INTO `role_module` VALUES ('1', '14');
INSERT INTO `role_module` VALUES ('1', '15');
INSERT INTO `role_module` VALUES ('1', '16');
INSERT INTO `role_module` VALUES ('1', '17');
INSERT INTO `role_module` VALUES ('1', '18');
INSERT INTO `role_module` VALUES ('2', '11');
INSERT INTO `role_module` VALUES ('2', '12');
INSERT INTO `role_module` VALUES ('2', '13');
INSERT INTO `role_module` VALUES ('2', '18');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'erickung@sina.com', 'eric', '1', '0000-00-00 00:00:00', '', '123456');
INSERT INTO `user` VALUES ('2', 'eric1@sina.com', 'eric1', '1', '2014-04-12 16:02:29', 'db9fe98dbe8200f6a2f823fdaea2386c', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('3', 'tina@sina.com', 'tina', '1', '2014-04-07 22:15:35', '47b3eac82323da08db78f8b8d7596108', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('4', 'tina1@sina.com', 'tina1', '1', '2014-04-07 22:30:32', 'b89ab392e59e9f37551b010d3a42acff', '20eabe5d64b0e216796e834f52d61fd0b70332fc');

-- ----------------------------
-- Table structure for `user_product_role`
-- ----------------------------
DROP TABLE IF EXISTS `user_product_role`;
CREATE TABLE `user_product_role` (
  `user_id` int(10) unsigned NOT NULL,
  `pr_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`pr_id`),
  KEY `pr_id` (`pr_id`),
  CONSTRAINT `user_product_role_ibfk_2` FOREIGN KEY (`pr_id`) REFERENCES `product_role` (`pr_id`) ON DELETE CASCADE,
  CONSTRAINT `user_product_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_product_role
-- ----------------------------
INSERT INTO `user_product_role` VALUES ('2', '1');

-- ----------------------------
-- Table structure for `user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `cur_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
  CONSTRAINT `cur_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES ('1', '1');
INSERT INTO `user_roles` VALUES ('2', '1');
INSERT INTO `user_roles` VALUES ('1', '2');
INSERT INTO `user_roles` VALUES ('3', '2');
INSERT INTO `user_roles` VALUES ('4', '2');

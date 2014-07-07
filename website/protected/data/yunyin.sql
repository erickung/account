/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : yunyin

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-04-07 23:00:53
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

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
INSERT INTO `modules` VALUES ('10', '角色增改', '8', '1', 'admin.modules', 'Roleinfo,Edit', '', '2014-04-07 19:44:10', '0');
INSERT INTO `modules` VALUES ('11', '产品管理', '0', '0', '', '', '', '2014-04-07 19:36:34', '80');
INSERT INTO `modules` VALUES ('12', '产品管理', '11', '0', 'product.manage', 'list', '', '2014-04-07 19:40:30', '0');
INSERT INTO `modules` VALUES ('13', '产品列表', '12', '1', 'product.manage', 'list', '', '2014-04-07 19:41:04', '0');
INSERT INTO `modules` VALUES ('14', '销售管理', '0', '0', '', '', '', '2014-04-07 19:44:35', '70');
INSERT INTO `modules` VALUES ('15', '客户管理', '14', '0', 'sales.customer', 'list', '', '2014-04-07 19:46:59', '20');
INSERT INTO `modules` VALUES ('16', '产品预约', '14', '0', 'sales.product', 'list', '', '2014-04-07 19:47:53', '18');
INSERT INTO `modules` VALUES ('17', '销售跟踪', '14', '0', 'sales.track', 'list', '', '2014-04-07 19:48:38', '14');

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
INSERT INTO `roles` VALUES ('1', '系统管理员', '2014-04-07 19:49:50', '');
INSERT INTO `roles` VALUES ('2', '产品管理', '2014-04-07 19:50:11', '');

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
INSERT INTO `role_module` VALUES ('2', '11');
INSERT INTO `role_module` VALUES ('2', '12');
INSERT INTO `role_module` VALUES ('2', '13');

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
INSERT INTO `user` VALUES ('2', 'eric1@sina.com', 'eric1', '1', '2014-04-07 20:18:08', 'fa1929c33a67945735e82b742ca269e4', '20eabe5d64b0e216796e834f52d61fd0b70332fc');
INSERT INTO `user` VALUES ('3', 'tina@sina.com', 'tina', '1', '2014-04-07 22:15:35', '47b3eac82323da08db78f8b8d7596108', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('4', 'tina1@sina.com', 'tina1', '1', '2014-04-07 22:30:32', 'b89ab392e59e9f37551b010d3a42acff', '20eabe5d64b0e216796e834f52d61fd0b70332fc');

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

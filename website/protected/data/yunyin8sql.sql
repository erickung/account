/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : yunyin

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-05-06 01:25:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '销售',
  `mobile_num` varchar(255) NOT NULL COMMENT '电话号码',
  `name` varchar(64) NOT NULL COMMENT '客户名',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '客户类型',
  `status` tinyint(1) NOT NULL COMMENT '客户状态',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别',
  `birthday` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '生日',
  PRIMARY KEY (`customer_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('3', '5', '15201251668', 'eric', '1', '0', '', '1', '2014-04-25 00:39:17');
INSERT INTO `customer` VALUES ('4', '5', '15201251668', 'eric1', '1', '0', '', '2', '2014-04-25 00:39:20');
INSERT INTO `customer` VALUES ('5', '5', '15201251668', 'eric', '1', '0', '', '1', '2014-04-25 00:39:23');
INSERT INTO `customer` VALUES ('6', '5', '13800138000', 'tina', '1', '0', '', '2', '2014-04-25 00:39:26');
INSERT INTO `customer` VALUES ('7', '5', '1398013818313', '张三', '1', '0', '', '1', '2014-04-25 00:38:54');
INSERT INTO `customer` VALUES ('8', '5', '13131313', 'tt', '1', '0', '', '2', '2014-04-25 00:39:29');
INSERT INTO `customer` VALUES ('9', '5', '15201251668', 'dd', '1', '0', '', '1', '2014-04-25 00:39:33');
INSERT INTO `customer` VALUES ('10', '5', '15201251668', 'cc', '1', '0', '', '2', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('11', '5', '13800138000', 'fff', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('12', '5', '13131313', 'ttad', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('13', '5', '15201251668', 'erad', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('14', '5', '15201251668', 'd231', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('15', '5', '13800138000', '测试1', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('16', '5', '15201251668', '测试2', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('17', '5', '13800138000', 'd231', '1', '0', '', '1', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('18', '5', '13800138000', '大黄', '1', '0', '', '2', '2014-04-25 00:39:51');
INSERT INTO `customer` VALUES ('19', '2', '', '111', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('20', '2', '', '111', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('21', '2', '15201251668', '小王', '1', '0', '', '1', '2014-04-01 00:00:00');
INSERT INTO `customer` VALUES ('22', '6', '222', '111', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('23', '3', '1398013818313', '上海优刻得信息科技有限公司', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('24', '3', '1398013818313', 'chencheng', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('25', '3', '1398013818313', '张三', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('26', '3', '13800138000', '31333', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('27', '3', '13800138000', '31333', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('28', '3', '15201251668', '测试2', '1', '0', '', '1', '0000-00-00 00:00:00');
INSERT INTO `customer` VALUES ('29', '6', '1398013818313', '张三', '1', '0', '', '1', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `customer_purchase`
-- ----------------------------
DROP TABLE IF EXISTS `customer_purchase`;
CREATE TABLE `customer_purchase` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `appoint_account` int(11) NOT NULL COMMENT '购买金额',
  `real_account` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `note` text,
  `account_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打款状态',
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ps_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_purchase_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`),
  CONSTRAINT `customer_purchase_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_purchase
-- ----------------------------
INSERT INTO `customer_purchase` VALUES ('1', '17', '3', '111', '111', '99', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('2', '17', '5', '111', '0', '99', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('3', '17', '3', '40', '40', '4', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('4', '16', '7', '200', '200', '99', null, '0', '5');
INSERT INTO `customer_purchase` VALUES ('5', '16', '5', '10', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('6', '16', '5', '100', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('7', '17', '7', '300', '0', '2', null, '0', '5');
INSERT INTO `customer_purchase` VALUES ('8', '17', '8', '40', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('9', '16', '8', '20', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('10', '17', '9', '100', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('11', '17', '10', '100', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('12', '17', '11', '100', '0', '2', null, '0', '5');
INSERT INTO `customer_purchase` VALUES ('13', '16', '12', '111', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('14', '16', '13', '200', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('15', '16', '14', '100', '100', '4', null, '0', '5');
INSERT INTO `customer_purchase` VALUES ('16', '16', '15', '50', '0', '2', null, '0', '5');
INSERT INTO `customer_purchase` VALUES ('17', '17', '16', '100', '0', '2', null, '0', '5');
INSERT INTO `customer_purchase` VALUES ('18', '16', '17', '100', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('19', '17', '12', '10', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('20', '16', '20', '0', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('21', '16', '21', '0', '0', '2', null, '0', '2');
INSERT INTO `customer_purchase` VALUES ('22', '17', '22', '222', '222', '3', null, '0', '6');
INSERT INTO `customer_purchase` VALUES ('23', '18', '23', '2000', '2000', '99', null, '0', '3');
INSERT INTO `customer_purchase` VALUES ('24', '18', '24', '300', '300', '99', null, '0', '3');
INSERT INTO `customer_purchase` VALUES ('25', '18', '25', '200', '200', '99', null, '0', '3');
INSERT INTO `customer_purchase` VALUES ('26', '18', '26', '111', '111', '99', null, '0', '3');
INSERT INTO `customer_purchase` VALUES ('27', '18', '27', '200', '200', '99', null, '0', '3');
INSERT INTO `customer_purchase` VALUES ('28', '9', '28', '200', '0', '2', null, '0', '3');
INSERT INTO `customer_purchase` VALUES ('29', '21', '29', '200', '200', '99', null, '0', '6');
INSERT INTO `customer_purchase` VALUES ('30', '19', '29', '1000', '1000', '3', null, '0', '6');

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
  `class` char(16) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES ('1', '系统管理', '0', '0', '', '', '', '2014-04-29 22:55:59', '0', 'icon-fire');
INSERT INTO `modules` VALUES ('2', '用户管理', '1', '0', 'admin.user', 'list', '', '2014-04-07 19:41:52', '0', '');
INSERT INTO `modules` VALUES ('3', '用户列表', '2', '1', 'admin.user', 'list', '', '2014-04-07 19:42:10', '0', '');
INSERT INTO `modules` VALUES ('4', '权限管理', '1', '0', 'admin.modules', 'list', '', '2014-04-07 19:42:46', '0', '');
INSERT INTO `modules` VALUES ('5', '模块列表', '4', '1', 'admin.modules', 'list', '', '2014-04-07 19:42:59', '0', '');
INSERT INTO `modules` VALUES ('6', '模块增改', '4', '1', 'admin.modules', 'CModuleAdd,Edit,CEdit,ModuleInfo', '', '2014-04-07 19:43:12', '0', '');
INSERT INTO `modules` VALUES ('7', '用户增改', '2', '1', 'admin.user', 'Userinfo,UserEdit', '', '2014-04-07 19:42:29', '0', '');
INSERT INTO `modules` VALUES ('8', '角色管理', '1', '0', 'admin.role', 'list', '', '2014-04-07 19:43:25', '0', '');
INSERT INTO `modules` VALUES ('9', '角色列表', '8', '1', 'admin.role', 'list', '', '2014-04-07 19:43:41', '0', '');
INSERT INTO `modules` VALUES ('10', '角色增改', '8', '1', 'admin.role', 'Roleinfo,Edit', '', '2014-04-13 12:27:32', '0', '');
INSERT INTO `modules` VALUES ('11', '产品管理', '0', '0', '', '', 'eric1', '2014-04-29 22:53:30', '80', 'icon-book');
INSERT INTO `modules` VALUES ('12', '产品管理', '11', '0', 'product.manage', 'list', 'eric1', '2014-04-13 12:48:51', '10', '');
INSERT INTO `modules` VALUES ('13', '产品列表', '12', '1', 'product.manage', 'list,static,downFile', 'eric1', '2014-04-19 00:25:20', '0', '');
INSERT INTO `modules` VALUES ('14', '销售管理', '0', '0', '', '', '', '2014-04-29 22:50:53', '70', 'icon-user');
INSERT INTO `modules` VALUES ('15', '客户管理', '14', '0', 'sales.customer', 'list', '', '2014-04-07 19:46:59', '20', '');
INSERT INTO `modules` VALUES ('16', '产品预约', '14', '0', 'sales.cproduct', 'list', 'eric1', '2014-04-19 13:36:38', '18', '');
INSERT INTO `modules` VALUES ('17', '销售跟踪', '14', '0', 'sales.track', 'list', '', '2014-04-07 19:48:38', '14', '');
INSERT INTO `modules` VALUES ('18', '产品设置', '11', '0', 'product.setting', 'ProcessList', 'eric1', '2014-04-30 02:04:36', '1', '');
INSERT INTO `modules` VALUES ('19', '产品增改', '12', '1', 'product.manage', 'info,edit,pause,ProductFiles,deleteFile', 'eric1', '2014-04-18 22:24:06', '0', '');
INSERT INTO `modules` VALUES ('20', '流程列表', '18', '1', 'product.setting', 'ProcessList', 'eric1', '2014-04-13 11:34:55', '0', '');
INSERT INTO `modules` VALUES ('21', '流程增改', '18', '1', 'product.setting', 'ProcessInfo', 'eric1', '2014-04-13 11:34:42', '0', '');
INSERT INTO `modules` VALUES ('22', '客户列表', '15', '1', 'sales.customer', 'list', 'eric1', '2014-04-13 12:22:35', '0', '');
INSERT INTO `modules` VALUES ('23', '产品审批', '12', '1', 'product.manage', 'approval', 'eric1', '2014-04-13 22:11:42', '0', '');
INSERT INTO `modules` VALUES ('24', '客户增改', '15', '1', 'sales.customer', 'info,edit', 'eric1', '2014-04-19 11:13:15', '0', '');
INSERT INTO `modules` VALUES ('25', '产品列表', '16', '1', 'sales.cproduct', 'list', 'eric1', '2014-04-19 13:36:57', '0', '');
INSERT INTO `modules` VALUES ('26', '产品预约', '16', '1', 'sales.cproduct', 'appoint,AddAppointInfo', 'eric1', '2014-04-19 16:33:49', '0', '');
INSERT INTO `modules` VALUES ('27', '购买历史', '15', '1', 'sales.customer', 'CustomerPurchase', 'eric1', '2014-04-19 15:33:50', '0', '');
INSERT INTO `modules` VALUES ('28', '销售确认', '16', '1', 'sales.cproduct', 'CheckSale', 'eric1', '2014-04-19 16:00:35', '0', '');
INSERT INTO `modules` VALUES ('29', '预约确认', '12', '1', 'product.manage', 'ProductDetail,CheckSale', 'eric1', '2014-04-30 02:04:17', '0', '');
INSERT INTO `modules` VALUES ('30', '产品资料', '12', '1', 'product.manage', 'CustomerStatic', 'eric1', '2014-04-21 00:05:25', '0', '');
INSERT INTO `modules` VALUES ('31', '产品销售', '11', '0', 'product.salestrack', 'list', 'eric1', '2014-04-30 02:04:58', '9', '');
INSERT INTO `modules` VALUES ('32', '销售列表', '31', '1', 'product.salestrack', 'list', 'eric1', '2014-04-21 22:38:51', '0', '');

-- ----------------------------
-- Table structure for `process`
-- ----------------------------
DROP TABLE IF EXISTS `process`;
CREATE TABLE `process` (
  `process_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_name` varchar(64) NOT NULL,
  PRIMARY KEY (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of process
-- ----------------------------
INSERT INTO `process` VALUES ('1', '标准流程');

-- ----------------------------
-- Table structure for `process_roles`
-- ----------------------------
DROP TABLE IF EXISTS `process_roles`;
CREATE TABLE `process_roles` (
  `process_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`process_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `process_roles_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `process` (`process_id`) ON DELETE CASCADE,
  CONSTRAINT `process_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `product_role` (`pr_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of process_roles
-- ----------------------------
INSERT INTO `process_roles` VALUES ('1', '1');
INSERT INTO `process_roles` VALUES ('1', '2');
INSERT INTO `process_roles` VALUES ('1', '3');

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
-- Table structure for `product_approval_item`
-- ----------------------------
DROP TABLE IF EXISTS `product_approval_item`;
CREATE TABLE `product_approval_item` (
  `pai_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `after_status` tinyint(1) NOT NULL,
  `origin_status` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '通过/驳回',
  `note` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pai_id`),
  KEY `pr_id` (`origin_status`),
  KEY `user_id` (`user_id`),
  KEY `product_approval_item_ibfk_1` (`product_id`),
  CONSTRAINT `product_approval_item_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`),
  CONSTRAINT `product_approval_item_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_approval_item
-- ----------------------------
INSERT INTO `product_approval_item` VALUES ('4', '9', '0', '2', '1', '11111', '2');
INSERT INTO `product_approval_item` VALUES ('5', '9', '0', '1', '0', '2222', '2');
INSERT INTO `product_approval_item` VALUES ('11', '9', '0', '1', '0', '121231313', '2');
INSERT INTO `product_approval_item` VALUES ('12', '9', '2', '1', '1', '通过', '2');
INSERT INTO `product_approval_item` VALUES ('13', '9', '3', '2', '1', '打打22222222222222222', '2');
INSERT INTO `product_approval_item` VALUES ('14', '9', '4', '3', '1', 'dadad22', '2');
INSERT INTO `product_approval_item` VALUES ('15', '9', '3', '4', '0', '', '2');
INSERT INTO `product_approval_item` VALUES ('16', '9', '2', '3', '0', '', '2');
INSERT INTO `product_approval_item` VALUES ('17', '9', '1', '2', '0', '1111', '2');
INSERT INTO `product_approval_item` VALUES ('18', '9', '0', '1', '0', '', '2');
INSERT INTO `product_approval_item` VALUES ('19', '9', '0', '1', '0', '31313', '2');
INSERT INTO `product_approval_item` VALUES ('20', '9', '0', '1', '0', '附件', '2');
INSERT INTO `product_approval_item` VALUES ('21', '16', '2', '1', '1', '1111', '2');
INSERT INTO `product_approval_item` VALUES ('22', '16', '3', '2', '1', '2222', '2');
INSERT INTO `product_approval_item` VALUES ('23', '16', '4', '3', '1', '3333', '2');
INSERT INTO `product_approval_item` VALUES ('24', '16', '0', '4', '1', '444', '2');
INSERT INTO `product_approval_item` VALUES ('25', '18', '2', '1', '1', '通过！', '5');
INSERT INTO `product_approval_item` VALUES ('26', '9', '2', '1', '1', '3333', '5');
INSERT INTO `product_approval_item` VALUES ('27', '19', '2', '1', '1', '222', '6');
INSERT INTO `product_approval_item` VALUES ('28', '9', '3', '2', '1', '111', '7');
INSERT INTO `product_approval_item` VALUES ('29', '18', '3', '2', '1', '333', '7');
INSERT INTO `product_approval_item` VALUES ('30', '19', '1', '2', '0', '1111', '7');
INSERT INTO `product_approval_item` VALUES ('31', '9', '0', '3', '1', '111', '8');
INSERT INTO `product_approval_item` VALUES ('32', '18', '0', '3', '1', '333', '8');
INSERT INTO `product_approval_item` VALUES ('33', '19', '2', '1', '1', '222', '5');
INSERT INTO `product_approval_item` VALUES ('34', '20', '2', '1', '1', '333', '5');
INSERT INTO `product_approval_item` VALUES ('35', '19', '3', '2', '1', 'aa', '7');
INSERT INTO `product_approval_item` VALUES ('36', '20', '3', '2', '1', 'bb', '7');
INSERT INTO `product_approval_item` VALUES ('37', '19', '0', '3', '1', '222', '8');
INSERT INTO `product_approval_item` VALUES ('38', '20', '0', '3', '1', '3333', '8');
INSERT INTO `product_approval_item` VALUES ('39', '21', '2', '1', '1', '1111', '5');
INSERT INTO `product_approval_item` VALUES ('40', '21', '3', '2', '1', '2222', '7');
INSERT INTO `product_approval_item` VALUES ('41', '21', '0', '3', '1', '333', '8');

-- ----------------------------
-- Table structure for `product_extra`
-- ----------------------------
DROP TABLE IF EXISTS `product_extra`;
CREATE TABLE `product_extra` (
  `product_id` int(11) NOT NULL,
  `finance_companies_info` text NOT NULL COMMENT '融资公司介绍',
  `project_advantage` text NOT NULL COMMENT '项目优势',
  `risk_disclosure_statement` text NOT NULL COMMENT '风险声明及控制',
  PRIMARY KEY (`product_id`),
  CONSTRAINT `product_extra_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_extra
-- ----------------------------
INSERT INTO `product_extra` VALUES ('9', '介绍1', '优势1', '风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n风险声明及控制\r\n');
INSERT INTO `product_extra` VALUES ('16', '中融-琨晟矿业集合资金信托计划', '大项目大品牌', '中融');
INSERT INTO `product_extra` VALUES ('17', '', '', '');
INSERT INTO `product_extra` VALUES ('18', '', '', '');
INSERT INTO `product_extra` VALUES ('19', '', '', '');
INSERT INTO `product_extra` VALUES ('20', '', '', '');
INSERT INTO `product_extra` VALUES ('21', '开户行1', '开户行1', '开户行1');

-- ----------------------------
-- Table structure for `product_files`
-- ----------------------------
DROP TABLE IF EXISTS `product_files`;
CREATE TABLE `product_files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `file_name` char(36) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`file_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_files_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_files
-- ----------------------------
INSERT INTO `product_files` VALUES ('36', '16', '[中文版] MongoDB权威指南.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\16\\\\p18lqqvfj3fkr4tf6h3inqhrt4.pdf');
INSERT INTO `product_files` VALUES ('37', '16', 'C 学习笔记.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\16\\\\p18lqrl2aq1hlp1lkp1t6e14r03csf.pdf');
INSERT INTO `product_files` VALUES ('38', '9', '团队的法则.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\9\\\\p18lrvaq3dt1u178911i5nt91rq74.pdf');
INSERT INTO `product_files` VALUES ('39', '9', '王二的经济学故事.txt', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\9\\\\p18lrvb23q1chp1i9q4r5bt41s115.txt');
INSERT INTO `product_files` VALUES ('40', '18', 'Hive 优化以及执行原理.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\18\\\\p18mlu4o5r1p741bqt1v8g8qr1cs04.pdf');
INSERT INTO `product_files` VALUES ('41', '18', 'Zend_API中文文档.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\18\\\\p18mlu59dn1uo53adoub11r9q836.pdf');
INSERT INTO `product_files` VALUES ('42', '19', '分布式系统设计模式.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\19\\\\p18mn0tvbv151a5ta49g3qjvo54.pdf');
INSERT INTO `product_files` VALUES ('44', '19', '团队的法则.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\19\\\\p18mn0um4s1v0s12hp1ooe17j71hkke.pdf');
INSERT INTO `product_files` VALUES ('45', '19', 'TCP-IP详解卷1：协议.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\19\\\\p18mn0uv8cn84otrebb3bg4u4f.pdf');
INSERT INTO `product_files` VALUES ('46', '20', '团队的法则.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\20\\\\p18mnel9252731p00aci1ecpjcf5.pdf');
INSERT INTO `product_files` VALUES ('47', '20', '分布式系统设计模式.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\20\\\\p18mneldji1vvht412q213mcpvq6.pdf');
INSERT INTO `product_files` VALUES ('48', '20', '[中文版] MongoDB权威指南.pdf', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\20\\\\p18mneli7tnh1mu7j991pitusq7.pdf');
INSERT INTO `product_files` VALUES ('49', '20', 'PHP扩展开发-基础篇.pptx', 'G:\\wamp\\www\\framework\\website\\..\\website\\runtime\\tmp\\product\\20\\\\p18mnem21818tqg5u1alt3gj1b2aq.pptx');

-- ----------------------------
-- Table structure for `product_info`
-- ----------------------------
DROP TABLE IF EXISTS `product_info`;
CREATE TABLE `product_info` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '项目名称',
  `type` tinyint(1) NOT NULL COMMENT '信托类型',
  `fund_size` int(11) NOT NULL COMMENT '发行规模',
  `build_date` int(11) NOT NULL COMMENT '成立日期',
  `funds_source` varchar(255) NOT NULL COMMENT '资金来源',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `process_id` int(11) NOT NULL DEFAULT '1' COMMENT '流程id',
  `duration` tinyint(1) NOT NULL COMMENT '项目期限',
  `investment_way` tinyint(1) NOT NULL COMMENT '投资方式',
  `min_rate` double(11,2) NOT NULL,
  `max_rate` double(11,2) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `product_info_ibfk_1` FOREIGN KEY (`process_id`) REFERENCES `process` (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_info
-- ----------------------------
INSERT INTO `product_info` VALUES ('9', '测试1', '2', '1000000', '1396540800', '1212121111111111', '99', '1', '18', '1', '7.26', '9.32');
INSERT INTO `product_info` VALUES ('16', 'FOT-上海长汇富恒投资管理中心（有限合伙）', '1', '3000', '1397491200', '财富中心直销', '99', '1', '12', '1', '7.00', '9.50');
INSERT INTO `product_info` VALUES ('17', 'FOT-上海长汇富恒投资管理中心（有限合伙）测试2', '1', '1000000', '1396281600', '大家的', '99', '1', '11', '1', '7.26', '9.32');
INSERT INTO `product_info` VALUES ('18', '北京长富汇银一期', '1', '10000', '1396281600', '其他', '99', '1', '12', '1', '7.30', '9.10');
INSERT INTO `product_info` VALUES ('19', '北京长富汇银二期', '1', '10000', '1396281600', '其他', '99', '1', '12', '1', '7.30', '9.10');
INSERT INTO `product_info` VALUES ('20', '北京长富汇银三期', '1', '50000', '1396281600', '其他', '99', '1', '12', '1', '7.30', '9.10');
INSERT INTO `product_info` VALUES ('21', '北京长富汇银四期', '1', '10000', '1398787200', '其他', '99', '1', '18', '1', '7.26', '9.32');

-- ----------------------------
-- Table structure for `product_publish`
-- ----------------------------
DROP TABLE IF EXISTS `product_publish`;
CREATE TABLE `product_publish` (
  `product_id` int(11) NOT NULL,
  `personal_threshold` int(11) NOT NULL COMMENT '个人投资起点',
  `origin_threshold` int(11) NOT NULL COMMENT '机构投资起点',
  `start_date` int(11) NOT NULL COMMENT '发行开始时间',
  `end_date` int(11) NOT NULL COMMENT '发行结束时间',
  `bank_account` varchar(255) NOT NULL COMMENT '开户行账号',
  `bank_name` varchar(255) NOT NULL COMMENT '开户行户名',
  `bank_address` varchar(255) NOT NULL COMMENT '开户行',
  PRIMARY KEY (`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_publish_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_publish
-- ----------------------------
INSERT INTO `product_publish` VALUES ('9', '100', '500', '1396886400', '1398787200', 'dadada', '31313', 'dadadadad');
INSERT INTO `product_publish` VALUES ('16', '10', '10', '1397491200', '1400083200', '35220188000000000', '上海长汇富恒投资管理中心（有限合伙）', '交通银行股份有限公司上海陆家嘴支行');
INSERT INTO `product_publish` VALUES ('17', '0', '0', '1396281600', '1398787200', '', '', '');
INSERT INTO `product_publish` VALUES ('18', '100', '500', '1396281600', '1414684800', '', '', '');
INSERT INTO `product_publish` VALUES ('19', '100', '500', '1398787200', '1409414400', '开户行账号', '开户行户名', '开户行');
INSERT INTO `product_publish` VALUES ('20', '100', '500', '1396281600', '1398787200', '开户行账号', '开户行户名', '开户行');
INSERT INTO `product_publish` VALUES ('21', '100', '500', '1396281600', '1412006400', '开户行1', '开户行1', '开户行1');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_role
-- ----------------------------
INSERT INTO `product_role` VALUES ('1', '产品总监');
INSERT INTO `product_role` VALUES ('2', '副总裁');
INSERT INTO `product_role` VALUES ('3', '总裁');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '系统管理员', '2014-04-21 22:50:07', 'eric1');
INSERT INTO `roles` VALUES ('2', '产品经理', '2014-04-30 02:05:28', 'eric1');
INSERT INTO `roles` VALUES ('3', '销售经理', '2014-04-21 00:25:39', 'eric1');
INSERT INTO `roles` VALUES ('6', '产品管理', '2014-04-30 02:05:39', 'eric1');

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
INSERT INTO `role_module` VALUES ('1', '19');
INSERT INTO `role_module` VALUES ('1', '20');
INSERT INTO `role_module` VALUES ('1', '21');
INSERT INTO `role_module` VALUES ('1', '22');
INSERT INTO `role_module` VALUES ('1', '23');
INSERT INTO `role_module` VALUES ('1', '24');
INSERT INTO `role_module` VALUES ('1', '25');
INSERT INTO `role_module` VALUES ('1', '26');
INSERT INTO `role_module` VALUES ('1', '27');
INSERT INTO `role_module` VALUES ('1', '28');
INSERT INTO `role_module` VALUES ('1', '29');
INSERT INTO `role_module` VALUES ('1', '30');
INSERT INTO `role_module` VALUES ('1', '31');
INSERT INTO `role_module` VALUES ('1', '32');
INSERT INTO `role_module` VALUES ('2', '11');
INSERT INTO `role_module` VALUES ('2', '12');
INSERT INTO `role_module` VALUES ('2', '13');
INSERT INTO `role_module` VALUES ('2', '19');
INSERT INTO `role_module` VALUES ('2', '29');
INSERT INTO `role_module` VALUES ('2', '30');
INSERT INTO `role_module` VALUES ('2', '31');
INSERT INTO `role_module` VALUES ('2', '32');
INSERT INTO `role_module` VALUES ('3', '14');
INSERT INTO `role_module` VALUES ('3', '15');
INSERT INTO `role_module` VALUES ('3', '16');
INSERT INTO `role_module` VALUES ('3', '22');
INSERT INTO `role_module` VALUES ('3', '24');
INSERT INTO `role_module` VALUES ('3', '25');
INSERT INTO `role_module` VALUES ('3', '26');
INSERT INTO `role_module` VALUES ('3', '27');
INSERT INTO `role_module` VALUES ('3', '28');
INSERT INTO `role_module` VALUES ('3', '30');
INSERT INTO `role_module` VALUES ('6', '11');
INSERT INTO `role_module` VALUES ('6', '12');
INSERT INTO `role_module` VALUES ('6', '13');
INSERT INTO `role_module` VALUES ('6', '18');
INSERT INTO `role_module` VALUES ('6', '19');
INSERT INTO `role_module` VALUES ('6', '20');
INSERT INTO `role_module` VALUES ('6', '21');
INSERT INTO `role_module` VALUES ('6', '23');
INSERT INTO `role_module` VALUES ('6', '29');
INSERT INTO `role_module` VALUES ('6', '30');
INSERT INTO `role_module` VALUES ('6', '31');
INSERT INTO `role_module` VALUES ('6', '32');

-- ----------------------------
-- Table structure for `trust_type`
-- ----------------------------
DROP TABLE IF EXISTS `trust_type`;
CREATE TABLE `trust_type` (
  `tt_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`tt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trust_type
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'erickung@sina.com', 'eric', '1', '2014-04-22 08:16:59', '', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('2', 'eric1@sina.com', 'eric1', '1', '2014-04-30 14:00:41', 'c387b1d6e14ff2962043d3ab5e8e2f2e', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('3', 'tina@sina.com', 'tina', '1', '2014-04-30 03:28:59', 'b7ada1c3f4c90b75884987d2b3a5f749', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('4', 'tina1@sina.com', 'tina1', '1', '2014-04-30 13:56:15', '6c0cf49884e892b648bf04e45462cf48', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('5', 'tina2@mai.com', 'tina2', '1', '2014-04-30 13:49:10', '4e989da93bba2a7bc7d12bd7b338c9ce', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('6', 'tina3', 'tina3', '1', '2014-04-30 13:56:49', '6749fd07825f16f723daa11641265c7f', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('7', 'tina4', 'tina4', '1', '2014-04-30 13:49:58', '6c0a55a8a2b869466808c64f05531267', '7c4a8d09ca3762af61e59520943dc26494f8941b');
INSERT INTO `user` VALUES ('8', 'tina5', 'tina5', '1', '2014-04-30 13:50:54', '6de22c4601083f1b5459d08750ef4ba2', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- ----------------------------
-- Table structure for `user_product_role`
-- ----------------------------
DROP TABLE IF EXISTS `user_product_role`;
CREATE TABLE `user_product_role` (
  `user_id` int(10) unsigned NOT NULL,
  `pr_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`pr_id`),
  KEY `pr_id` (`pr_id`),
  CONSTRAINT `user_product_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_product_role
-- ----------------------------
INSERT INTO `user_product_role` VALUES ('2', '1');
INSERT INTO `user_product_role` VALUES ('5', '1');
INSERT INTO `user_product_role` VALUES ('6', '1');
INSERT INTO `user_product_role` VALUES ('2', '2');
INSERT INTO `user_product_role` VALUES ('7', '2');
INSERT INTO `user_product_role` VALUES ('2', '3');
INSERT INTO `user_product_role` VALUES ('8', '3');

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
INSERT INTO `user_roles` VALUES ('4', '2');
INSERT INTO `user_roles` VALUES ('7', '2');
INSERT INTO `user_roles` VALUES ('8', '2');
INSERT INTO `user_roles` VALUES ('3', '3');
INSERT INTO `user_roles` VALUES ('6', '3');
INSERT INTO `user_roles` VALUES ('7', '3');
INSERT INTO `user_roles` VALUES ('8', '3');
INSERT INTO `user_roles` VALUES ('5', '6');
INSERT INTO `user_roles` VALUES ('7', '6');
INSERT INTO `user_roles` VALUES ('8', '6');

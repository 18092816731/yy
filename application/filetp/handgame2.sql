/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50537
Source Host           : localhost:3306
Source Database       : handgame

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2018-07-30 14:39:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hand_agent
-- ----------------------------
DROP TABLE IF EXISTS `hand_agent`;
CREATE TABLE `hand_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '代理商id',
  `account` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '代理商账号',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id\n多级分类 0为平台-平台下级为游戏--游戏下级为代理',
  `password` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '代理账号密码',
  `card_num` int(11) NOT NULL DEFAULT '0' COMMENT '代理房卡 0为无限张',
  `created_at` varchar(225) CHARACTER SET utf8 DEFAULT '' COMMENT '代理创建时间',
  `update_at` varchar(225) CHARACTER SET utf8 DEFAULT '' COMMENT '代理信息更新时间',
  `token` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT '123456789',
  `status` smallint(1) DEFAULT '4' COMMENT '状态 1为启用 2为禁用 3为未审核 4为审核未通过',
  `wx_name` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '微信名称',
  `rname` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '真实姓名',
  `phone` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '手机号',
  `reject_cause` varchar(1000) CHARACTER SET utf8 DEFAULT '' COMMENT '拒绝原因',
  `child_num` int(100) DEFAULT '0' COMMENT '子代理总数',
  `rebate` int(100) DEFAULT '0' COMMENT '返利金额',
  `openid` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `access_token` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '威信私钥',
  `return_fee` decimal(11,2) DEFAULT '0.00',
  `img_url` varchar(500) CHARACTER SET utf8 DEFAULT '' COMMENT '头像',
  `code_url` varchar(500) CHARACTER SET utf8 DEFAULT '' COMMENT '二维马地址',
  `return_num` decimal(11,2) DEFAULT '0.00' COMMENT '返利总额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100059 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='代理级别表 0为平台   0的子集为游戏  游戏下面是代理';

-- ----------------------------
-- Records of hand_agent
-- ----------------------------
INSERT INTO `hand_agent` VALUES ('100000', '666666', '0', 'e10adc3949ba59abbe56e057f20f883e', '0', '', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '0.00', '', '', '0.00');

-- ----------------------------
-- Table structure for hand_agent_card
-- ----------------------------
DROP TABLE IF EXISTS `hand_agent_card`;
CREATE TABLE `hand_agent_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '房卡信息id',
  `agent_id` int(11) NOT NULL COMMENT '代理id',
  `card_num` int(11) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '1为加卡记录 2为减卡 记录',
  `created_at` varchar(225) NOT NULL DEFAULT '' COMMENT '房卡信息变更时间',
  `user_account` varchar(225) DEFAULT '' COMMENT '购买房卡账号   （代理)',
  `wx_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '微信',
  `rname` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `phone` varchar(255) DEFAULT NULL COMMENT '代理电话',
  `fee_num` decimal(50,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4642 DEFAULT CHARSET=utf8 COMMENT='代理房卡信息';

-- ----------------------------
-- Records of hand_agent_card
-- ----------------------------

-- ----------------------------
-- Table structure for hand_agent_log
-- ----------------------------
DROP TABLE IF EXISTS `hand_agent_log`;
CREATE TABLE `hand_agent_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户日志',
  `agent_id` int(11) NOT NULL COMMENT '用户id',
  `login_time` varchar(225) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '使用',
  `update_time` varchar(225) CHARACTER SET utf8 DEFAULT '' COMMENT '更新时间',
  `operation` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '完成的操作',
  `wx_name` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '微信名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4938 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户日志表';

-- ----------------------------
-- Records of hand_agent_log
-- ----------------------------

-- ----------------------------
-- Table structure for hand_buy_card_set
-- ----------------------------
DROP TABLE IF EXISTS `hand_buy_card_set`;
CREATE TABLE `hand_buy_card_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_num` int(100) DEFAULT '0' COMMENT '购买金额',
  `card_num` int(100) DEFAULT '0' COMMENT '够卡数量',
  `created_at` int(15) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='发卡设置\r\n';

-- ----------------------------
-- Records of hand_buy_card_set
-- ----------------------------
INSERT INTO `hand_buy_card_set` VALUES ('4', '1', '10', '1531147233');
INSERT INTO `hand_buy_card_set` VALUES ('5', '10', '100', '1531190248');
INSERT INTO `hand_buy_card_set` VALUES ('6', '100', '500', '1532337063');

-- ----------------------------
-- Table structure for hand_month_log
-- ----------------------------
DROP TABLE IF EXISTS `hand_month_log`;
CREATE TABLE `hand_month_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `card_send_num` int(150) DEFAULT '0' COMMENT '0',
  `agent_num` int(150) DEFAULT '0',
  `agent_return_fee` decimal(50,2) DEFAULT '0.00',
  `agent_put_fee` decimal(50,2) DEFAULT '0.00',
  `created_at` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT '0',
  `card_buy_num` int(150) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_month_log
-- ----------------------------

-- ----------------------------
-- Table structure for hand_order
-- ----------------------------
DROP TABLE IF EXISTS `hand_order`;
CREATE TABLE `hand_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_cn` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(3) DEFAULT '0',
  `out_trade_no` varchar(255) DEFAULT NULL,
  `total_fee` decimal(11,2) DEFAULT '0.00',
  `order_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_order
-- ----------------------------
INSERT INTO `hand_order` VALUES ('1', null, null, null, null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('2', null, null, '1532615028', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('3', null, null, '1532615055', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('4', null, null, '1532615065', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('5', null, null, '1532615436', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('6', null, null, '1532615440', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('7', null, null, '1532615996', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('8', null, null, '1532616042', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('9', null, null, '1532616323', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('10', null, null, '1532616325', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('11', null, null, '1532616327', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('12', null, null, '1532616386', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('13', null, null, '1532616425', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('14', null, null, '1532616507', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('15', null, null, '1532616529', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('16', null, null, '1532616541', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('17', null, null, '1532619446', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('18', null, null, '1532619538', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('19', null, null, '1532619539', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('20', null, null, '1532619686', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('21', null, null, '1532620030', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('22', null, null, '1532620214', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('23', null, null, '1532620236', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('24', null, null, '1532620261', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('25', null, null, '1532620420', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('26', null, null, '1532620433', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('27', null, null, '1532620497', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('28', null, null, '1532620548', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('29', null, null, '1532620644', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('30', null, null, '1532620769', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('31', null, null, '1532621094', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('32', null, null, '1532621115', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('33', null, null, '1532621232', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('34', null, null, '1532621235', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('35', null, null, '1532621261', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('36', null, null, '1532621263', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('37', null, null, '1532621318', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('38', null, null, '1532621468', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('39', null, null, '1532621513', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('40', null, null, '1532621535', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('41', null, null, '1532621540', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('42', null, null, '1532621586', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('43', null, null, '1532621880', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('44', null, null, '1532621891', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('45', null, null, '1532621907', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('46', null, null, '1532621910', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('47', null, null, '1532621924', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('48', null, null, '1532621926', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('49', null, null, '1532621947', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('50', null, null, '1532621948', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('51', null, null, '1532621951', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('52', null, null, '1532621965', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('53', null, null, '1532621984', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('54', null, null, '1532622088', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('55', null, null, '1532622102', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('56', null, null, '1532622125', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('57', null, null, '1532622761', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('58', null, null, '1532622772', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('59', null, null, '1532622812', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('60', null, null, '1532622889', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('61', null, null, '1532622892', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('62', null, null, '1532623124', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('63', null, null, '1532623136', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('64', null, null, '1532623176', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('65', null, null, '1532623377', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('66', null, null, '1532623393', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('67', null, null, '1532623481', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('68', null, null, '1532624266', null, '0', null, '1.00', null);
INSERT INTO `hand_order` VALUES ('69', null, null, '1532751911', null, '0', null, '1.00', null);

-- ----------------------------
-- Table structure for hand_plat_card
-- ----------------------------
DROP TABLE IF EXISTS `hand_plat_card`;
CREATE TABLE `hand_plat_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '房卡信息id',
  `plat_id` int(11) DEFAULT NULL COMMENT '平台当前操作用户id',
  `card_num` int(11) DEFAULT NULL,
  `status` smallint(1) DEFAULT '1' COMMENT '预留',
  `agent_account` varchar(225) DEFAULT NULL COMMENT '代理账号（平台给房卡账号）',
  `created_at` varchar(225) DEFAULT '' COMMENT '房卡信息变更时间',
  `agent_id` int(11) DEFAULT NULL,
  `fee_num` decimal(50,2) DEFAULT '0.00',
  `cause` varchar(255) DEFAULT '',
  `card_id` int(11) DEFAULT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=423 DEFAULT CHARSET=utf8 COMMENT='代理房卡信息';

-- ----------------------------
-- Records of hand_plat_card
-- ----------------------------

-- ----------------------------
-- Table structure for hand_refeeset
-- ----------------------------
DROP TABLE IF EXISTS `hand_refeeset`;
CREATE TABLE `hand_refeeset` (
  `id` int(11) NOT NULL DEFAULT '1',
  `one_fee` int(11) DEFAULT '0',
  `three_fee` int(11) DEFAULT '0',
  `tow_fee` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_refeeset
-- ----------------------------
INSERT INTO `hand_refeeset` VALUES ('1', '5', '2', '3');

-- ----------------------------
-- Table structure for hand_refeeset_plat
-- ----------------------------
DROP TABLE IF EXISTS `hand_refeeset_plat`;
CREATE TABLE `hand_refeeset_plat` (
  `id` int(11) NOT NULL DEFAULT '1',
  `one_fee` int(11) DEFAULT '0',
  `three_fee` int(11) DEFAULT '0',
  `tow_fee` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_refeeset_plat
-- ----------------------------
INSERT INTO `hand_refeeset_plat` VALUES ('1', '2', '32', '33');

-- ----------------------------
-- Table structure for hand_return_fee
-- ----------------------------
DROP TABLE IF EXISTS `hand_return_fee`;
CREATE TABLE `hand_return_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_num` decimal(11,2) DEFAULT '0.00',
  `status` int(3) DEFAULT '1' COMMENT '1 待审核 2 审核成功3 审核失败',
  `cause` varchar(255) DEFAULT NULL,
  `created_at` int(15) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `plat_id` int(11) DEFAULT NULL,
  `account` varchar(255) DEFAULT '',
  `totel_fee` int(11) DEFAULT '0',
  `pay_type` int(3) DEFAULT '1' COMMENT '1weixn  2 zhifubao 3 yinhangka',
  `get_account` varchar(255) DEFAULT NULL COMMENT '体现帐号 ',
  `rname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_return_fee
-- ----------------------------

-- ----------------------------
-- Table structure for hand_return_fee_log
-- ----------------------------
DROP TABLE IF EXISTS `hand_return_fee_log`;
CREATE TABLE `hand_return_fee_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_num` decimal(11,2) DEFAULT '0.00',
  `status` int(3) DEFAULT '1' COMMENT '1 待审核 2 审核成功3 审核失败',
  `cause` varchar(255) DEFAULT NULL,
  `created_at` int(15) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `palt_id` int(11) DEFAULT NULL,
  `account` varchar(255) DEFAULT '',
  `totel_fee` decimal(11,2) DEFAULT '0.00',
  `pname` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` int(3) DEFAULT '1',
  `save_fee` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=419 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_return_fee_log
-- ----------------------------

-- ----------------------------
-- Table structure for hand_send_card_set
-- ----------------------------
DROP TABLE IF EXISTS `hand_send_card_set`;
CREATE TABLE `hand_send_card_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_num` int(100) DEFAULT '0' COMMENT '购买金额',
  `card_num` int(100) DEFAULT '0' COMMENT '够卡数量',
  `created_at` int(15) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='发卡设置\r\n';

-- ----------------------------
-- Records of hand_send_card_set
-- ----------------------------
INSERT INTO `hand_send_card_set` VALUES ('2', '10', '100', '1531149121');
INSERT INTO `hand_send_card_set` VALUES ('5', '1', '10', '1531190257');
INSERT INTO `hand_send_card_set` VALUES ('6', '100', '500', '1532337077');

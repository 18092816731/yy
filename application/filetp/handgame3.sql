/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50537
Source Host           : localhost:3306
Source Database       : handgame

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2018-08-02 21:28:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hand_agent
-- ----------------------------
DROP TABLE IF EXISTS `hand_agent`;
CREATE TABLE `hand_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '代理商id',
  `account` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '代理商账号',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id\n多级分类 0为平台-平台下级为游戏--游戏下级为代理',
  `password` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '代理账号密码',
  `card_num` int(11) NOT NULL DEFAULT '0' COMMENT '代理房卡 0为无限张',
  `created_at` varchar(225) CHARACTER SET utf8 DEFAULT '' COMMENT '代理创建时间',
  `update_at` varchar(225) CHARACTER SET utf8 DEFAULT '' COMMENT '代理信息更新时间',
  `token` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '123456789',
  `status` smallint(1) DEFAULT '4' COMMENT '状态 1为启用 2为禁用 3为未审核 4为审核未通过',
  `wx_name` varchar(1000) DEFAULT NULL COMMENT '微信名称',
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
  `all_card` int(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100114 DEFAULT CHARSET=utf8mb4 COMMENT='代理级别表 0为平台   0的子集为游戏  游戏下面是代理';

-- ----------------------------
-- Records of hand_agent
-- ----------------------------
INSERT INTO `hand_agent` VALUES ('100000', 'xamsh001', '0', 'd372a5cd90ddb6681c4deb1dac012081', '0', '', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '3.06', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100001', '', '0', '', '0', '', '', '123456789', '5', '', '', '', '', '0', '0', '', '', '150.00', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100002', 'xamsh002', '100000', '00ab4955c8430144694997d9f3b03096', '0', '', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '55.12', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100003', 'xamsh003', '100003', '353c185be062aae49a150614fd9057e3', '0', '', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '0.00', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100092', 'zhanglequn', '0', 'a67341ea0d54a07cd8e0ab82555a05ed', '0', '1533193986', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '0.00', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100093', 'wuyang', '0', 'e10adc3949ba59abbe56e057f20f883e', '0', '1533194104', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '0.00', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100097', 'luwei', '0', 'e10adc3949ba59abbe56e057f20f883e', '0', '1533194651', '', '123456789', '1', '', '', '', '', '0', '0', '', '', '0.00', '', '', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100102', '', '0', '', '0', '1533195400', '', '123456789', '4', '大秦之子', '', '', '', '0', '0', 'oW_EE1vjoSNtVoEMGY6KbXBl7IT4', '12_DuPMGaUTJa_yzm91AgTJyHqRfsuDxkSjIVsoAXHAqqqYLCk-DLtG-Q6_vYh0IZ618NFrEtt5TUN-rB4yd16IQhVA6uDrwbKTKKgfNVA3sdo', '0.00', 'http://thirdwx.qlogo.cn/mmopen/vi_32/hVhGI4W62icO5py6ltIgGzLlcib4qSSiaicianSPSDDY0uQB6aOcXAdr8zREbfNYUJXwibaUEfDG5b1zB1ksLuvu8fPQ/132', 'http://server.daque.com/./upload/qr_code/15331954008570.png', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100104', '', '0', '', '0', '1533195963', '', '123456789', '4', '测试', '', '', '', '0', '0', 'oW_EE1j312qzyyVjubyGnX8lKirE', '12_tLH0xzvDoGpf_P5BgnKss_7cSZT7t0EfEDy3ZFMHg3ubtL-GfnFRX1i2wNtKNNd6fNu8nDftA0X7QIzqmzmVTETvNxpT9lrVgWjyPVneHEA', '0.00', 'http://thirdwx.qlogo.cn/mmopen/vi_32/0noZeLKXRKA0MaHaybtCPM5dm0nHOhL2h2triauu3L5WQfqHrPcxP3Crd19JLiboQqvOT69OS6tyNr8SiaoIdicEgw/132', 'http://server.daque.com/./upload/qr_code/15331959636534.png', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100110', '', '0', '', '0', '1533200512', '1533216420', '123456789', '1', '田鹏', '', '', '', '1', '0', 'oW_EE1m9TymxIyrXpjgL97Dsfu0M', '12_gOm6xHG0btBXvQYg9r5t8VPUzUKj8HM_fYv5IxnoaMByLsmtsEUzxvxnjRcY9SbmVslCOMOMLvIB3UIabQuRtI98XOi03JwhHtBTzk0tBs8', '100.00', 'http://thirdwx.qlogo.cn/mmopen/vi_32/99JYSlpOqL0rruEyHPC8PdzrvGawfKaLm8PWeefFkiaqfTAj423pibEjxesn788B0MMrReKNlspVFy9f7yDSWib6A/132', 'http://server.daque.com/./upload/qr_code/15332005122969.png', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100111', '18092709102', '100112', '', '6566', '1533202207', '1533205954', '123456789', '1', '芦伟', '芦伟', '18092709102', '', '0', '0', 'oW_EE1pntUXfiCMYmJd6lRr0Tm_A', '12_G8EIxEEyvhpKEAKb6QXaf4BZEAcRoAazNzUi9WHypCQdiv0Fu-a7jPuiYEbqxnLAznPtMKHkrfarpk89o2WPtB4EkVigq5JlP-saVtyrtt8', '0.00', 'http://thirdwx.qlogo.cn/mmopen/vi_32/FKAMMRtLUlyxatBqUwTdXd2jOwnxj74sBYDTy7r86TOBSocN1rmNflAbffO6uX3iaOlfwNI74ck7WYrbGiclk1SA/132', 'http://server.daque.com/./upload/qr_code/15332022076377.png', '0.00', '6666');
INSERT INTO `hand_agent` VALUES ('100112', '13991972740', '100001', '', '6666', '1533202415', '1533215395', '123456789', '1', '请叫我吴先森', '吴扬', '13991972740', '', '1', '0', 'oW_EE1svhziTZrb_L-LnLr-t5W9c', '12_wEk3QypnKF9J4a_jkm8fjxcU_POvOEH5YHyysWVnyavEt-ai-Byr36R-6H4Sym9f5FOOdTsqI7Drvl7R2it7XVpPn_s2yircFJUdJpR8DWE', '0.00', 'http://thirdwx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEJwcSBxicr79YTNYrq5xibmWutiblWvF4ibkphsvQ3gNEVzl5vOxib33dL7aeM0BqChTIAFaFMicsItQA6Q/132', 'http://server.daque.com/./upload/qr_code/15332024157607.png', '0.00', '0');
INSERT INTO `hand_agent` VALUES ('100113', '18092816731', '100110', '', '13332', '1533214159', '1533216331', '123456789', '1', '田鹏', 'peng', '18092816731', '', '0', '0', 'oW_EE1m9TymxIyrXpjgL97Dsfu0', '12_PlZZZHAeQ8py09YhjUjxq183aTTibj95PnixadETC-LVLADaBzC6NGYduOr0svLbaCU2JxlAUK0XAf2Rlk63jDG-Mt1cVT-SnWQE3Ss0yGY', '0.00', 'http://thirdwx.qlogo.cn/mmopen/vi_32/99JYSlpOqL0rruEyHPC8PdzrvGawfKaLm8PWeefFkiaqfTAj423pibEjxesn788B0MMrReKNlspVFy9f7yDSWib6A/132', 'http://server.daque.com/./upload/qr_code/15332141592228.png', '0.00', '6666');

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
) ENGINE=InnoDB AUTO_INCREMENT=4652 DEFAULT CHARSET=utf8 COMMENT='代理房卡信息';

-- ----------------------------
-- Records of hand_agent_card
-- ----------------------------
INSERT INTO `hand_agent_card` VALUES ('4646', '100112', '20', '1', '1533205838', '10002442', 'U7653849909', null, null, '0.00');
INSERT INTO `hand_agent_card` VALUES ('4647', '100112', '20', '1', '1533205839', '10002442', 'U7653849909', null, null, '0.00');
INSERT INTO `hand_agent_card` VALUES ('4648', '100111', '100', '1', '1533205954', '10002457', '棋牌游戏定制', null, null, '0.00');
INSERT INTO `hand_agent_card` VALUES ('4649', '100112', '20', '1', '1533205981', '10002442', 'U7653849909', null, null, '0.00');
INSERT INTO `hand_agent_card` VALUES ('4650', '100112', '20', '1', '1533206036', '10002442', 'U7653849909', null, null, '0.00');
INSERT INTO `hand_agent_card` VALUES ('4651', '100112', '20', '1', '1533206036', '10002442', 'U7653849909', null, null, '0.00');

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
) ENGINE=MyISAM AUTO_INCREMENT=5264 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户日志表';

-- ----------------------------
-- Records of hand_agent_log
-- ----------------------------
INSERT INTO `hand_agent_log` VALUES ('5162', '100089', '1533192972', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5163', '100089', '1533192978', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5164', '100089', '1533192980', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5165', '100089', '1533192981', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5166', '100089', '1533192987', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5167', '100090', '1533193483', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5168', '100090', '1533193487', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5169', '100090', '1533193489', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5170', '100089', '1533193661', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5171', '100089', '1533193664', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5172', '100089', '1533193665', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5173', '100089', '1533193674', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5174', '100090', '1533193833', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5175', '100094', '1533194188', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5176', '100089', '1533194319', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5177', '100089', '1533194321', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5178', '100089', '1533194323', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5179', '100095', '1533194323', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5180', '100096', '1533194541', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5181', '100093', '1533194637', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5182', '100090', '1533194683', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5183', '100090', '1533194701', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5184', '100098', '1533194827', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5185', '100098', '1533194839', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5186', '100097', '1533194878', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5187', '100099', '1533194919', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5188', '100100', '1533195005', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5189', '100101', '1533195397', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5190', '100102', '1533195403', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5191', '100102', '1533195405', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5192', '100103', '1533195496', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5193', '100102', '1533195561', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5194', '100104', '1533195966', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5195', '100105', '1533196233', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5196', '100106', '1533196327', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5197', '100106', '1533196329', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5198', '100106', '1533196331', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5199', '100107', '1533196450', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5200', '100102', '1533196517', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5201', '100102', '1533196521', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5202', '100104', '1533197053', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5203', '100108', '1533197810', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5204', '100102', '1533197861', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5205', '100102', '1533197862', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5206', '100102', '1533197863', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5207', '100102', '1533197864', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5208', '100108', '1533197920', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5209', '100108', '1533197920', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5210', '100108', '1533197921', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5211', '100108', '1533197921', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5212', '100108', '1533197921', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5213', '100109', '1533198211', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5214', '100104', '1533198932', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5215', '100104', '1533199174', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5216', '100104', '1533199176', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5217', '100104', '1533199176', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5218', '100104', '1533199177', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5219', '100110', '1533200513', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5220', '100110', '1533200530', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5221', '100097', '1533202155', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5222', '100111', '1533202208', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5223', '100111', '1533202213', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5224', '100104', '1533202382', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5225', '100104', '1533202395', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5226', '100104', '1533202395', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5227', '100112', '1533202416', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5228', '100112', '1533202498', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5229', '100112', '1533202575', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5230', '100112', '1533202709', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5231', '100097', '1533203204', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5232', '100112', '1533203469', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5233', '100112', '1533203501', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5234', '100111', '1533203844', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5235', '100111', '1533203875', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5236', '100111', '1533203942', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5237', '100112', '1533204120', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5238', '100112', '1533204250', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5239', '100111', '1533204472', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5240', '100111', '1533204504', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5241', '100111', '1533204508', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5242', '100112', '1533204815', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5243', '100112', '1533204926', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5244', '100111', '1533205061', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5245', '100112', '1533205072', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5246', '100111', '1533205909', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5247', '100112', '1533213305', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5248', '100110', '1533214105', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5249', '100113', '1533214159', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5250', '100113', '1533214202', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5251', '100113', '1533214217', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5252', '100110', '1533214330', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5253', '100112', '1533215158', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5254', '100112', '1533215330', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5255', '100112', '1533215397', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5256', '100113', '1533215499', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5257', '100110', '1533215524', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5258', '100113', '1533215597', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5259', '100110', '1533215633', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5260', '100110', '1533215652', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5261', '100110', '1533216257', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5262', '100113', '1533216307', '', '用户登录', '');
INSERT INTO `hand_agent_log` VALUES ('5263', '100110', '1533216420', '', '用户登录', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='发卡设置\r\n';

-- ----------------------------
-- Records of hand_buy_card_set
-- ----------------------------
INSERT INTO `hand_buy_card_set` VALUES ('4', '1000', '6666', '1531147233');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_month_log
-- ----------------------------
INSERT INTO `hand_month_log` VALUES ('14', '100112', '100', '0', '0.00', '0.00', '1533206036', '8', '6666');
INSERT INTO `hand_month_log` VALUES ('15', '100111', '100', '0', '0.00', '0.00', '1533205954', '8', '6666');
INSERT INTO `hand_month_log` VALUES ('16', '100113', '0', '0', '0.00', '0.00', '1533216331', '8', '13332');

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
) ENGINE=InnoDB AUTO_INCREMENT=465 DEFAULT CHARSET=utf8 COMMENT='代理房卡信息';

-- ----------------------------
-- Records of hand_plat_card
-- ----------------------------
INSERT INTO `hand_plat_card` VALUES ('455', null, '6666', '2', null, '1533202584', '100112', '1000.00', '', '4', 'H802025843078333');
INSERT INTO `hand_plat_card` VALUES ('456', null, '6666', '2', null, '1533202725', '100112', '1000.00', '', '4', 'H802027258554644');
INSERT INTO `hand_plat_card` VALUES ('457', null, '6666', '1', null, '1533203484', '100112', '1000.00', '', '4', 'H802034840307853');
INSERT INTO `hand_plat_card` VALUES ('458', null, '6666', '1', null, '1533203946', '100111', '1000.00', '', '4', 'H802039465399821');
INSERT INTO `hand_plat_card` VALUES ('459', '100093', '100', '2', '13991972740', '1533205515', '100112', '0.00', '111', null, null);
INSERT INTO `hand_plat_card` VALUES ('460', null, '6666', '1', null, '1533214253', '100113', '1000.00', '', '4', 'H802142536621360');
INSERT INTO `hand_plat_card` VALUES ('461', null, '6666', '2', null, '1533215197', '100112', '1000.00', '', '4', 'H802151970811750');
INSERT INTO `hand_plat_card` VALUES ('462', null, '6666', '2', null, '1533215335', '100112', '1000.00', '', '4', 'H802153358775188');
INSERT INTO `hand_plat_card` VALUES ('463', null, '6666', '2', null, '1533215401', '100112', '1000.00', '', '4', 'H802154017003500');
INSERT INTO `hand_plat_card` VALUES ('464', null, '6666', '1', null, '1533216323', '100113', '1000.00', '', '4', 'H802163233695361');

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_return_fee
-- ----------------------------
INSERT INTO `hand_return_fee` VALUES ('31', '100.00', '2', null, '1533204736', '100112', '100093', '', '0', '1', '13991972740', '吴扬', '13991972740', null);

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
  `wx_name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hand_return_fee_log
-- ----------------------------
INSERT INTO `hand_return_fee_log` VALUES ('446', '100.00', '1', null, '1533203490', '100112', null, '13991972740', '1000.00', '', '100001', '1', '100.00', null);
INSERT INTO `hand_return_fee_log` VALUES ('447', '100.00', '1', null, '1533203963', '100111', null, '18092709102', '1000.00', '请叫我吴先森', '100112', '1', '100.00', '芦伟');
INSERT INTO `hand_return_fee_log` VALUES ('448', '50.00', '1', null, '1533203963', '100111', null, '18092709102', '1000.00', '', '100001', '2', '150.00', null);
INSERT INTO `hand_return_fee_log` VALUES ('449', '50.00', '1', null, '1533214260', '100113', null, '18092816731', '1000.00', '田鹏', '100110', '1', '50.00', null);
INSERT INTO `hand_return_fee_log` VALUES ('450', '50.00', '1', null, '1533216331', '100113', null, '18092816731', '1000.00', '田鹏', '100110', '1', '100.00', '田鹏');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='发卡设置\r\n';

-- ----------------------------
-- Records of hand_send_card_set
-- ----------------------------
INSERT INTO `hand_send_card_set` VALUES ('7', '10', '20', '1533025083');
INSERT INTO `hand_send_card_set` VALUES ('9', '30', '60', '1533025120');
INSERT INTO `hand_send_card_set` VALUES ('10', '50', '100', '1533025137');

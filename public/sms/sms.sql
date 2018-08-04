/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : diaoyu

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-23 23:20:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user_code
-- ----------------------------
DROP TABLE IF EXISTS `user_code`;
CREATE TABLE `user_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) DEFAULT '' COMMENT '用户账号',
  `code` varchar(255) DEFAULT '' COMMENT '验证码',
  `ip` varchar(255) DEFAULT '' COMMENT '用户IP',
  `created_at` varchar(255) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_code
-- ----------------------------
INSERT INTO `user_code` VALUES ('1', '18092816731', '839030', '127.0.0.1', '1527080097');
INSERT INTO `user_code` VALUES ('2', '18092816731', '578852', '127.0.0.1', '1527080345');
INSERT INTO `user_code` VALUES ('3', '18092816731', '706377', '127.0.0.1', '1527080477');
INSERT INTO `user_code` VALUES ('4', '18092816731', '904515', '127.0.0.1', '1527080519');
INSERT INTO `user_code` VALUES ('5', '18092816731', '407024', '127.0.0.1', '1527080520');
INSERT INTO `user_code` VALUES ('6', '18092816731', '692332', '127.0.0.1', '1527080521');
INSERT INTO `user_code` VALUES ('7', '18092816731', '798361', '127.0.0.1', '1527080528');
INSERT INTO `user_code` VALUES ('8', '18092816731', '876180', '127.0.0.1', '1527080550');
INSERT INTO `user_code` VALUES ('9', '18092816731', '448637', '127.0.0.1', '1527080597');
INSERT INTO `user_code` VALUES ('10', '18092816731', '628725', '127.0.0.1', '1527080651');
INSERT INTO `user_code` VALUES ('11', '18092816731', '621550', '127.0.0.1', '1527080674');
INSERT INTO `user_code` VALUES ('12', '18092816731', '870015', '127.0.0.1', '1527080695');
INSERT INTO `user_code` VALUES ('13', '18092816731', '741982', '127.0.0.1', '1527080712');
INSERT INTO `user_code` VALUES ('14', '18092816731', '405490', '127.0.0.1', '1527080750');
INSERT INTO `user_code` VALUES ('15', '18092816731', '394596', '127.0.0.1', '1527080786');
INSERT INTO `user_code` VALUES ('16', '18092816731', '338486', '127.0.0.1', '1527080807');
INSERT INTO `user_code` VALUES ('17', '18092816731', '614031', '127.0.0.1', '1527080827');
INSERT INTO `user_code` VALUES ('18', '18092816731', '846776', '127.0.0.1', '1527080879');
INSERT INTO `user_code` VALUES ('19', '18092816731', '717017', '127.0.0.1', '1527081070');
INSERT INTO `user_code` VALUES ('20', '18092816731', '637811', '127.0.0.1', '1527081099');
INSERT INTO `user_code` VALUES ('21', '18092816731', '336897', '127.0.0.1', '1527081136');
INSERT INTO `user_code` VALUES ('22', '18092816731', '890289', '127.0.0.1', '1527081179');
INSERT INTO `user_code` VALUES ('23', '18092816731', '916954', '127.0.0.1', '1527081195');
INSERT INTO `user_code` VALUES ('24', '18092816731', '810743', '127.0.0.1', '1527081229');
INSERT INTO `user_code` VALUES ('25', '18092816731', '392103', '127.0.0.1', '1527081450');
INSERT INTO `user_code` VALUES ('26', '18092816231', '608345', '127.0.0.1', '1527081626');
INSERT INTO `user_code` VALUES ('27', '18092816731', '337817', '127.0.0.1', '1527081841');
INSERT INTO `user_code` VALUES ('28', '17754662546', '929313', '127.0.0.1', '1527085718');
INSERT INTO `user_code` VALUES ('29', '17731541231', '745122', '127.0.0.1', '1527085820');
INSERT INTO `user_code` VALUES ('30', '17731541231', '571695', '127.0.0.1', '1527085821');
INSERT INTO `user_code` VALUES ('31', '17731541231', '444724', '127.0.0.1', '1527085824');
INSERT INTO `user_code` VALUES ('32', '17765645645', '722730', '127.0.0.1', '1527085878');
INSERT INTO `user_code` VALUES ('33', '13254564545', '982392', '127.0.0.1', '1527085906');
INSERT INTO `user_code` VALUES ('34', '18829518788', '850599', '127.0.0.1', '1527085971');

-- ----------------------------
-- Table structure for user_info
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_info
-- ----------------------------
INSERT INTO `user_info` VALUES ('1', 'jinxing', '84ab51ee50fc5617eeeecd8da8c8c7fb');

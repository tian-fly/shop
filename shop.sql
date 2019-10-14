/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 80012
Source Host           : 127.0.0.1:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2019-10-13 15:45:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `login_ip` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态： 1：启用 2：停用',
  `login_time` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '1' COMMENT '是否可以删除 1：是 0：否',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'tian', '123456', '127.0.0.1', '1', '1570671437', '1', '1', null, '1570581327', null);

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '轮播图位置',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '描述',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('1', '首页顶部', '首页顶部轮播图', null, null, null);

-- ----------------------------
-- Table structure for banner_item
-- ----------------------------
DROP TABLE IF EXISTS `banner_item`;
CREATE TABLE `banner_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '图片',
  `banner_id` int(11) NOT NULL COMMENT '所属轮播图的ID',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of banner_item
-- ----------------------------
INSERT INTO `banner_item` VALUES ('1', '1', '1', null, null, null);
INSERT INTO `banner_item` VALUES ('2', '2', '1', null, null, null);
INSERT INTO `banner_item` VALUES ('3', '3', '1', null, null, null);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '小米', null, null, null);
INSERT INTO `category` VALUES ('2', '华为', null, null, null);
INSERT INTO `category` VALUES ('3', '苹果', null, null, null);
INSERT INTO `category` VALUES ('4', '魅族', null, null, null);
INSERT INTO `category` VALUES ('5', 'vivo', '1570671595', '1570671595', null);

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论类容',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `standard_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('1', '666', '1', '1', '1', '1', '1570804663', '1570804663', null);

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `content` varchar(160) NOT NULL,
  `user_id` int(8) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:可删除',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of feedback
-- ----------------------------
INSERT INTO `feedback` VALUES ('1', '66666', '1', '1', '1570091286', '1570091286', null);

-- ----------------------------
-- Table structure for image
-- ----------------------------
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片地址',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of image
-- ----------------------------
INSERT INTO `image` VALUES ('1', '/images/华为/华为P30 Pro/head/20191011\\d18a11902041f0b38ed39a32b7825db9.PNG', null, '1570796542', null);
INSERT INTO `image` VALUES ('8', '/images/huawei/p30pro/2.png', null, null, null);
INSERT INTO `image` VALUES ('9', '/images/huawei/p30pro/3.png', null, null, null);
INSERT INTO `image` VALUES ('10', '/images/huawei/p30pro/body/1.jpg', null, null, null);
INSERT INTO `image` VALUES ('11', '/images/huawei/p30pro/body/2.jpg', null, null, null);
INSERT INTO `image` VALUES ('13', '/images/xiaomi/9/2.png', null, null, null);
INSERT INTO `image` VALUES ('14', '/images/xiaomi/9/3.png', null, null, null);
INSERT INTO `image` VALUES ('15', '/images/xiaomi/9/body/1.jpg', null, null, null);
INSERT INTO `image` VALUES ('16', '/images/xiaomi/9/body/2.jpg', null, null, null);
INSERT INTO `image` VALUES ('17', '/images/小米/小米9/20191011\\3fbfae6435627bfd5c0cf9a6b4fec820.PNG', '1570766542', '1570782587', null);
INSERT INTO `image` VALUES ('18', '/images/华为/华为P30 Pro/body/20191011\\163316e80e19b447649f2c2d93bd667b.PNG', '1570783142', '1570783142', null);
INSERT INTO `image` VALUES ('19', '/images/华为/华为P30 Pro/body/20191011\\20df0669d991ebc05bf46c6e836b5bca.jpg', '1570783177', '1570783177', null);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ord` int(11) NOT NULL COMMENT '排序',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父菜单ID',
  `controller` varchar(20) NOT NULL COMMENT '控制器',
  `method` varchar(20) NOT NULL COMMENT '方法',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态： 0：不可用 1：可用',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否删除 1：是 0：否',
  `is_hidden` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否影藏  0：否 1：是',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '1', '0', 'admin', 'index', '管理员管理', '1', '1', '0', null, '1569672779', null);
INSERT INTO `menu` VALUES ('5', '1', '1', 'admin', 'admin_list', '管理员列表', '1', '1', '0', '1560824533', '1569672780', null);
INSERT INTO `menu` VALUES ('9', '2', '1', 'admin', 'admin_edit', '添加（编辑）管理员', '1', '1', '1', '1560825304', '1569672780', null);
INSERT INTO `menu` VALUES ('10', '3', '1', ' admin', 'admin_del', '删除管理员', '1', '1', '1', '1560825451', '1569672780', null);
INSERT INTO `menu` VALUES ('11', '4', '1', 'admin', 'no_del', '批量恢复管理员', '1', '1', '1', '1560825675', '1569672780', null);
INSERT INTO `menu` VALUES ('41', '7', '0', 'system', 'index', '系统管理', '1', '1', '0', '1561191270', '1569672781', null);
INSERT INTO `menu` VALUES ('13', '5', '1', 'admin', 'admin_status', '管理员状态', '1', '1', '1', '1560825823', '1569672780', null);
INSERT INTO `menu` VALUES ('14', '2', '0', 'menu', 'index', '菜单管理', '1', '1', '0', '1560932481', '1569672780', null);
INSERT INTO `menu` VALUES ('15', '1', '14', 'menu', 'menu_list', '菜单列表', '1', '1', '0', '1560932764', '1569672780', null);
INSERT INTO `menu` VALUES ('56', '3', '0', 'user', 'index', '用户管理', '1', '1', '0', '1569586189', '1569673069', null);
INSERT INTO `menu` VALUES ('61', '4', '0', 'product', 'index', '商品管理', '1', '1', '0', '1570453335', '1570453335', null);
INSERT INTO `menu` VALUES ('58', '1', '56', 'user', 'user_list', '用户列表', '1', '1', '0', '1569586299', '1569673069', null);
INSERT INTO `menu` VALUES ('62', '1', '61', 'product', 'product_list', '商品列表', '1', '1', '0', '1570453394', '1570453394', null);
INSERT INTO `menu` VALUES ('26', '2', '14', 'menu', 'menu_edit', '添加(编辑)菜单', '1', '1', '1', '1560933419', '1569672781', null);
INSERT INTO `menu` VALUES ('27', '3', '14', 'menu', 'menu_del', '删除菜单', '1', '1', '1', '1560933467', '1569672781', null);
INSERT INTO `menu` VALUES ('28', '4', '14', 'menu', 'menu_delAll', '删除全部菜单', '1', '1', '1', '1560933509', '1569672781', null);
INSERT INTO `menu` VALUES ('29', '5', '14', 'menu', 'no_del', '批量恢复全部菜单', '1', '1', '1', '1560933560', '1569672781', null);
INSERT INTO `menu` VALUES ('30', '6', '14', 'menu', 'menu_status', '菜单状态', '1', '1', '1', '1560933588', '1569672781', null);
INSERT INTO `menu` VALUES ('36', '6', '1', 'role', 'role_list', '角色(权限)管理', '1', '1', '0', '1560934855', '1569672780', null);
INSERT INTO `menu` VALUES ('37', '7', '1', 'role', 'role_edit', '添加（编辑角色）', '1', '1', '1', '1560934921', '1569672780', null);
INSERT INTO `menu` VALUES ('38', '8', '1', 'role', 'role_del', '删除角色', '1', '1', '1', '1560934954', '1569672780', null);
INSERT INTO `menu` VALUES ('39', '9', '1', 'role', 'no_del', '角色恢复', '1', '1', '1', '1560935012', '1569672780', null);
INSERT INTO `menu` VALUES ('40', '10', '1', 'role', 'role_status', '角色状态', '1', '1', '1', '1560935050', '1569672780', null);
INSERT INTO `menu` VALUES ('42', '1', '41', 'system', 'index', '系统信息', '1', '1', '0', '1561191317', '1569672781', null);
INSERT INTO `menu` VALUES ('60', '2', '56', 'feedback', 'feedback_list', '反馈列表', '1', '1', '0', '1570079519', '1570079519', null);
INSERT INTO `menu` VALUES ('63', '2', '61', 'product', 'add', '添加商品', '1', '1', '0', '1570453443', '1570453443', null);
INSERT INTO `menu` VALUES ('64', '5', '0', 'order', 'index', '订单管理', '1', '1', '0', '1570453479', '1570453551', null);
INSERT INTO `menu` VALUES ('67', '2', '64', 'order', 'getMoney', '已支付订单', '1', '1', '0', '1570463120', '1570463140', null);
INSERT INTO `menu` VALUES ('66', '1', '64', 'order', 'noGetMoney', '未支付订单', '1', '1', '0', '1570463057', '1570463057', null);
INSERT INTO `menu` VALUES ('68', '3', '64', 'order', 'getProduct', '已发货订单', '1', '1', '0', '1570463197', '1570463197', null);
INSERT INTO `menu` VALUES ('69', '4', '64', 'order', 'successTrade', '交易成功订单', '1', '1', '0', '1570463239', '1570463239', null);
INSERT INTO `menu` VALUES ('70', '3', '61', 'category', 'category_list', '商品分类', '1', '1', '0', '1570608178', '1570608178', null);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(30) NOT NULL COMMENT '订单编号',
  `user_id` int(11) NOT NULL COMMENT '下单用户ID',
  `total_price` int(6) NOT NULL COMMENT '商品总价',
  `count` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '订单备注',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单状态 0：未支付 1：已支付 2：已发货 3：交易成功',
  `pre_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pre_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pre_phone` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('12', 'A20191006715571570376716', '1', '1', '2', '2333', '1', '广东省东莞市南城区西湖路99号广科', '李一', '12345678911', '1570376707', '1570526466', null);
INSERT INTO `order` VALUES ('25', 'A20191008463681570530270', '1', '5488', '1', '2333', '0', '广东省东莞市南城区西湖路99号广科', '李一', '12345678911', '1570530270', '1570530270', null);

-- ----------------------------
-- Table structure for order_product
-- ----------------------------
DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `count` int(11) NOT NULL COMMENT '购买商品数量',
  `standard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_product
-- ----------------------------
INSERT INTO `order_product` VALUES ('12', '1', '1', '1');
INSERT INTO `order_product` VALUES ('12', '8', '1', '8');
INSERT INTO `order_product` VALUES ('25', '1', '1', '1');

-- ----------------------------
-- Table structure for param
-- ----------------------------
DROP TABLE IF EXISTS `param`;
CREATE TABLE `param` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `model` varchar(100) NOT NULL,
  `color` varchar(255) NOT NULL,
  `ram` varchar(255) NOT NULL,
  `rom` varchar(255) NOT NULL,
  `CPU` varchar(255) NOT NULL,
  `Ka` varchar(50) NOT NULL,
  `product_id` int(8) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of param
-- ----------------------------
INSERT INTO `param` VALUES ('1', 'HUAWEI P30 PRO', '珠光贝母 极光色 天空之境 赤茶橘 墨玉蓝', '8GB 6GB', ' 6+64GB 6+128GB 8+256GB', 'HUAWEI Kirin 980 （麒麟980）', '双卡双待', '1', null, null, null);
INSERT INTO `param` VALUES ('2', '小米9', '全息幻彩蓝 全息幻彩紫 深空灰', '6GB 8GB 12GB', '6+128GB 8+128GB 8+256GB', '骁龙855', '双卡双待', '8', null, null, null);

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
  `introduce` text NOT NULL,
  `sell` int(8) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:在架',
  `centerImg_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL COMMENT '商品所属分类id',
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否为热商品 0：否 1:是',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', '华为', '华为P30 Pro', 'Huawei/华为P30 Pro曲面屏超感光徕卡四摄变焦双景录像980智能手机p30pro', '7', '1', '1', '2', '1', '1570376707', '1570706026', null);
INSERT INTO `product` VALUES ('8', '小米', '小米9', '骁龙855智能游戏学生老人老年手机大屏大字小米官方旗舰店正品xiaomi', '3', '1', '17', '1', '1', '1570376707', null, null);

-- ----------------------------
-- Table structure for product_image
-- ----------------------------
DROP TABLE IF EXISTS `product_image`;
CREATE TABLE `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_image
-- ----------------------------
INSERT INTO `product_image` VALUES ('1', '10', '1', null, null, null);
INSERT INTO `product_image` VALUES ('2', '11', '1', null, null, null);
INSERT INTO `product_image` VALUES ('5', '15', '8', null, null, null);
INSERT INTO `product_image` VALUES ('6', '16', '8', null, null, null);
INSERT INTO `product_image` VALUES ('7', '18', '1', '1570783142', '1570783142', null);
INSERT INTO `product_image` VALUES ('8', '19', '1', '1570783177', '1570783177', null);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '角色名',
  `right` text NOT NULL COMMENT '权限',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_delete` tinyint(2) DEFAULT '1' COMMENT '是否删除 1：是 0：否',
  `status` int(2) DEFAULT '1' COMMENT '状态：0：禁用 1：可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '[\"1\",\"5\",\"9\",\"10\",\"11\",\"13\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"14\",\"15\",\"26\",\"27\",\"28\",\"29\",\"30\",\"56\",\"58\",\"60\",\"61\",\"62\",\"63\",\"70\",\"64\",\"67\",\"66\",\"68\",\"69\"]', null, '1570608214', null, '1', '1');
INSERT INTO `role` VALUES ('5', '普通管理员', '[\"2\",\"6\",\"3\",\"7\"]', '1561019681', '1561036249', null, '1', '0');

-- ----------------------------
-- Table structure for standard
-- ----------------------------
DROP TABLE IF EXISTS `standard`;
CREATE TABLE `standard` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `color` char(10) NOT NULL,
  `memory` char(10) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `stock` int(8) NOT NULL,
  `sell` int(8) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:在架',
  `centerImg_id` int(8) DEFAULT NULL,
  `product_id` int(8) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of standard
-- ----------------------------
INSERT INTO `standard` VALUES ('1', '珠光贝母', '6+64', '5488.00', '14', '1', '1', '8', '1', null, null, null);
INSERT INTO `standard` VALUES ('2', '亮黑色', '6+128', '5800.00', '10', '1', '1', '1', '1', null, null, null);
INSERT INTO `standard` VALUES ('3', '赤色橘', '6+64', '5488.00', '10', '1', '1', '9', '1', null, null, null);
INSERT INTO `standard` VALUES ('4', '珠光贝母', '6+128', '5800.00', '10', '1', '1', '8', '1', null, null, null);
INSERT INTO `standard` VALUES ('5', '赤色橘', '6+128', '5800.00', '10', '1', '1', '9', '1', null, null, null);
INSERT INTO `standard` VALUES ('6', '亮黑色', '6+64', '5488.00', '10', '1', '1', '1', '1', null, null, null);
INSERT INTO `standard` VALUES ('7', '亮黑色', '8+256', '6200.00', '10', '1', '1', '1', '1', null, null, null);
INSERT INTO `standard` VALUES ('8', '全息幻彩蓝', '8+256', '2999.00', '9', '1', '1', '17', '8', null, null, null);
INSERT INTO `standard` VALUES ('9', '全息幻彩紫色', '8+256', '2999.00', '10', '1', '1', '13', '8', null, null, null);
INSERT INTO `standard` VALUES ('10', '深空灰', '8+256', '2999.00', '10', '1', '1', '14', '8', null, null, null);

-- ----------------------------
-- Table structure for theme
-- ----------------------------
DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主题名称',
  `image_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of theme
-- ----------------------------
INSERT INTO `theme` VALUES ('1', '绿色健康', '4', null, null, null);
INSERT INTO `theme` VALUES ('2', '香味迷人', '5', null, null, null);
INSERT INTO `theme` VALUES ('3', '大优惠', '6', null, null, null);
INSERT INTO `theme` VALUES ('4', '其他', '7', null, null, null);

-- ----------------------------
-- Table structure for theme_product
-- ----------------------------
DROP TABLE IF EXISTS `theme_product`;
CREATE TABLE `theme_product` (
  `product_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  PRIMARY KEY (`theme_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of theme_product
-- ----------------------------
INSERT INTO `theme_product` VALUES ('1', '2');
INSERT INTO `theme_product` VALUES ('2', '2');
INSERT INTO `theme_product` VALUES ('1', '3');
INSERT INTO `theme_product` VALUES ('2', '3');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar_url` text COMMENT '头像',
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0：男 1：女  2：外星人',
  `phone` char(11) DEFAULT NULL,
  `qq` varchar(11) DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `birthday` date DEFAULT NULL COMMENT '生日',
  `motto` varchar(255) DEFAULT NULL COMMENT '座右铭',
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '可删除：1：不可 0：可',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '/user_avatar/20190812\\920daf32fe76fa875a19c60ffcfaa2a5.jpg', 'tian', '1234567', '2', '13512345678', '1234567891', '1047918241@qq.com', '2019-08-08', '123dddddddddd', '1', '1', null, '1569641304', null);
INSERT INTO `user` VALUES ('2', '/user_avatar/20190812\\920daf32fe76fa875a19c60ffcfaa2a5.jpg', 'ssssss', 'e10adc3949ba59abbe56e057f20f883e', '0', '13512345678', '1234567891', '123456789@qq.com', '2017-06-20', 'ddsssssssssss', '1', '1', '1564971573', '1564971573', null);
INSERT INTO `user` VALUES ('3', '/user_avatar/20190812\\920daf32fe76fa875a19c60ffcfaa2a5.jpg', 'nunu', 'e10adc3949ba59abbe56e057f20f883e', '0', '13566612345', '1234567891', '1555555@qq.com', '2019-08-12', 'dddddddddd', '1', '1', '1565184206', '1569640734', null);

-- ----------------------------
-- Table structure for user_address
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '收货人姓名',
  `mobile` varchar(50) NOT NULL COMMENT '收货人电话',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `zone` varchar(50) NOT NULL,
  `detail` varchar(255) NOT NULL COMMENT '详细地址',
  `primary` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:默认地址',
  `user_id` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_address
-- ----------------------------
INSERT INTO `user_address` VALUES ('1', '李一', '12345678911', '广东省', '东莞市', '南城区', '西湖路99号广科', '1', '1', null, null, null);
INSERT INTO `user_address` VALUES ('2', '李二', '12345678977', '广东省 ', '广州市', '天河区', 'xxxxx', '0', '1', null, null, null);
INSERT INTO `user_address` VALUES ('3', '小龙', '12345678911', '北京', '北京', '东城区', '啦啦', '0', '1', '1570607643', '1570607643', null);

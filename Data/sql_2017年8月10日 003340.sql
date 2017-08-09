/*
Navicat MySQL Data Transfer

Source Server         : vagrant
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : personal

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-08-10 00:33:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog_article`
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章标题' ,
`content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章内容' ,
`cid`  int(11) NOT NULL COMMENT '所属分类' ,
`type`  tinyint(4) NULL DEFAULT 0 COMMENT '0:草稿,1:发布' ,
`isDel`  tinyint(4) NULL DEFAULT 0 COMMENT '是否删除 0:否,1:是' ,
`insertTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`updateTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='文章表'
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of blog_article
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `blog_category`
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`pid`  int(11) NOT NULL DEFAULT 0 ,
`title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`type`  tinyint(4) NULL DEFAULT NULL COMMENT '分类类型  1:文章' ,
`insertTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`updateTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='类目表'
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of blog_category
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `blog_comment`
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;
CREATE TABLE `blog_comment` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`uid`  int(11) NOT NULL COMMENT '评论者id' ,
`content`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容' ,
`pid`  int(11) NOT NULL DEFAULT 0 COMMENT '父级id' ,
`type`  tinyint(4) NULL DEFAULT NULL COMMENT '所属板块   0:文章' ,
`lid`  int(11) NOT NULL COMMENT '所属板块详情id' ,
`insertTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`updateTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `blog_ext`
-- ----------------------------
DROP TABLE IF EXISTS `blog_ext`;
CREATE TABLE `blog_ext` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`type`  tinyint(4) NOT NULL COMMENT '扩展类型，0:图片,1:视频,2:音频' ,
`path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '扩展路径' ,
`url`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '扩展链接' ,
`sort`  tinyint(4) NULL DEFAULT NULL COMMENT '排序值' ,
`remark`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' ,
`ltype`  tinyint(4) NOT NULL COMMENT '所属板块类型  0:文章' ,
`lid`  int(11) NULL DEFAULT NULL COMMENT '所属板块详情id' ,
`insertTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`updateTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='扩展表'
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of blog_ext
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `blog_user`
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
`uid`  int(11) NOT NULL AUTO_INCREMENT ,
`email`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱' ,
`nickname`  varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '昵称' ,
`username`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名' ,
`password`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码' ,
`role`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '用户角色:1普通用户;2管理员' ,
`avatar`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户头像' ,
`isDel`  tinyint(4) NULL DEFAULT 0 COMMENT '是否停用  0:否   1:是' ,
`insertTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`updateTime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`uid`, `nickname`, `username`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='用户表'
AUTO_INCREMENT=7

;

-- ----------------------------
-- Records of blog_user
-- ----------------------------
BEGIN;
INSERT INTO `blog_user` VALUES ('1', null, 'jason9527', 'jmingyu', '04885d7cad40f8734b8e2e75553e9791', '2', null, '0', '2017-08-02 00:46:52', '2017-08-03 16:54:02'), ('4', null, 'jason95273', 'jmingyu3', '04885d7cad40f8734b8e2e75553e9791', '1', null, '0', '2017-08-02 00:46:52', '2017-08-03 00:36:44'), ('6', null, 'jason9999', 'jmingyu9999', '04885d7cad40f8734b8e2e75553e9791', '1', null, '0', '2017-08-04 00:30:03', '2017-08-04 00:30:03');
COMMIT;

-- ----------------------------
-- Auto increment value for `blog_article`
-- ----------------------------
ALTER TABLE `blog_article` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `blog_category`
-- ----------------------------
ALTER TABLE `blog_category` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `blog_comment`
-- ----------------------------
ALTER TABLE `blog_comment` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `blog_ext`
-- ----------------------------
ALTER TABLE `blog_ext` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `blog_user`
-- ----------------------------
ALTER TABLE `blog_user` AUTO_INCREMENT=7;

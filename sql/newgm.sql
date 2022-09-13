/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.26 : Database - db_newgm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_newgm` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_newgm`;

/*Table structure for table `gm_admin_auth` */

DROP TABLE IF EXISTS `gm_admin_auth`;

CREATE TABLE `gm_admin_auth` (
  `admin_auth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_auth_name` varchar(50) NOT NULL COMMENT '名字',
  `admin_auth_desc` varchar(255) DEFAULT NULL COMMENT '权限描述',
  `admin_auth_path` varchar(100) NOT NULL COMMENT '路径',
  `admin_auth_create_time` datetime NOT NULL COMMENT '创建时间',
  `admin_auth_update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

/*Data for the table `gm_admin_auth` */

insert  into `gm_admin_auth`(`admin_auth_id`,`admin_auth_name`,`admin_auth_desc`,`admin_auth_path`,`admin_auth_create_time`,`admin_auth_update_time`) values (1,'用户管理-查询接口','','admin/AdminUser/userList','2021-01-12 19:08:26','2021-01-16 01:19:48'),(2,'用户管理-添加接口','','admin/AdminUser/userAdd','2021-01-12 19:08:59','2021-01-16 01:21:44'),(3,'用户管理-修改接口','修改','admin/AdminUser/userEdit','2021-01-12 19:09:53','2021-01-16 01:21:40'),(5,'用户管理-删除接口','','admin/AdminUser/userDel','2021-01-13 02:00:16','2021-01-16 01:21:36'),(6,'用户管理-状态修改','','admin/AdminUser/userStatusUpdate','2021-01-15 17:07:10','2021-01-16 01:21:32'),(7,'用户管理-设定超管','','admin/AdminUser/userIsAdmin','2021-01-15 17:08:18','2021-01-16 01:21:26'),(8,'用户管理-分配菜单','','admin/AdminUser/userMenu','2021-01-15 17:08:38','2021-01-16 01:21:22'),(9,'用户管理-分配权限','','admin/AdminUser/userAuth','2021-01-15 17:08:51','2021-01-16 01:21:18'),(10,'用户管理-重置登陆密码','','admin/AdminUser/userNewPwd','2021-01-15 17:09:08','2021-01-16 01:21:13'),(11,'角色管理-查询接口','','admin/AdminRole/roleList','2021-01-15 17:10:42','2021-01-16 01:21:09'),(12,'角色管理-添加接口','','admin/AdminRole/roleAdd','2021-01-15 17:11:02','2021-01-16 01:21:03'),(13,'角色管理-修改接口','','admin/AdminRole/roleEdit','2021-01-15 17:11:14','2021-01-16 01:20:58'),(14,'角色管理-删除接口','','admin/AdminRole/roleDel','2021-01-15 17:11:36','2021-01-16 01:20:47'),(15,'角色管理-状态修改','','admin/AdminRole/roleStatusUpdate','2021-01-15 17:13:30','2021-01-16 01:20:54'),(16,'角色管理-分配菜单','','admin/AdminRole/roleMenu','2021-01-15 17:14:55','2021-01-16 01:20:41'),(17,'角色管理-分配权限','','admin/AdminRole/roleAuth','2021-01-15 17:15:15','2021-01-16 01:20:36'),(18,'菜单管理-查询接口','','admin/AdminMenu/menuList','2021-01-15 17:15:54','2021-01-16 01:20:32'),(19,'菜单管理-获取菜单信息','','admin/AdminMenu/menuInfo','2021-01-15 17:16:21','2021-01-16 01:20:28'),(20,'菜单管理-添加接口','','admin/AdminMenu/menuAdd','2021-01-15 17:16:58','2021-01-16 01:20:23'),(21,'菜单管理-修改接口','','admin/AdminMenu/menuEdit','2021-01-15 17:17:14','2021-01-16 01:20:18'),(22,'菜单管理-删除接口','','admin/AdminMenu/menuDel','2021-01-15 17:17:26','2021-01-16 01:20:14'),(23,'权限管理-查询接口','','admin/AdminAuth/authList','2021-01-15 17:20:09','2021-01-16 01:20:10'),(24,'权限管理-添加接口','','admin/AdminAuth/authAdd','2021-01-15 17:20:46','2021-01-16 01:20:06'),(25,'权限管理-修改接口','','admin/AdminAuth/authEdit','2021-01-15 17:21:01','2021-01-16 01:20:03'),(26,'权限管理-删除接口','','admin/AdminAuth/authDel','2021-01-15 17:21:11','2021-01-16 01:19:59'),(27,'系统日志-查询接口','','admin/AdminLog/logList','2021-01-16 20:01:34','2021-01-16 20:03:10'),(28,'系统日志-详情接口','','admin/AdminLog/logInfo','2021-01-16 20:02:51','2021-01-16 20:02:51'),(29,'CSV导出','','admin/GlobalSetting/exportCsv','2022-07-04 18:52:00','2022-07-04 18:52:00'),(30,'Sercer表刷新','','admin/GlobalSetting/serverRefresh','2022-07-04 18:52:35','2022-07-04 18:52:35'),(31,'玩家信息-角色查询','','admin/Account/list','2022-07-04 18:52:55','2022-07-08 18:56:12'),(32,'游戏运营-任务查询','','admin/Quest/list','2022-07-04 18:54:17','2022-07-04 18:54:17');

/*Table structure for table `gm_admin_log` */

DROP TABLE IF EXISTS `gm_admin_log`;

CREATE TABLE `gm_admin_log` (
  `admin_log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_user_id` int(11) NOT NULL COMMENT '用户id',
  `log_visit_path` varchar(100) NOT NULL COMMENT '访问路径',
  `log_type` tinyint(4) NOT NULL COMMENT '访问类型 1:登陆，2:操作，3退出',
  `request_ip` varchar(100) NOT NULL COMMENT '请求IP',
  `request_method` varchar(50) NOT NULL COMMENT '请求方式',
  `request_param` text COMMENT '请求参数',
  `response_code` int(11) NOT NULL DEFAULT '200' COMMENT '结束状态码',
  `response_msg` varchar(500) DEFAULT NULL COMMENT '结束描述',
  `create_time` datetime NOT NULL COMMENT '请求时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='日志';

/*Data for the table `gm_admin_log` */

/*Table structure for table `gm_admin_menu` */

DROP TABLE IF EXISTS `gm_admin_menu`;

CREATE TABLE `gm_admin_menu` (
  `admin_menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_menu_name` varchar(50) NOT NULL COMMENT '菜单名字',
  `admin_menu_title` varchar(50) NOT NULL COMMENT '菜单标题',
  `admin_menu_icon` varchar(50) NOT NULL COMMENT '图标',
  `admin_menu_path` varchar(100) NOT NULL COMMENT '菜单路径',
  `admin_menu_sort` int(11) NOT NULL DEFAULT '1' COMMENT '菜单排序,值越大排序越靠前',
  `admin_menu_pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级菜单 0:顶级',
  `admin_menu_level_path` varchar(500) NOT NULL DEFAULT '0' COMMENT '等级路径',
  `admin_menu_create_time` datetime NOT NULL COMMENT '创建时间',
  `admin_menu_update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_menu_id`),
  UNIQUE KEY `admin_menu_name` (`admin_menu_name`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

/*Data for the table `gm_admin_menu` */

insert  into `gm_admin_menu`(`admin_menu_id`,`admin_menu_name`,`admin_menu_title`,`admin_menu_icon`,`admin_menu_path`,`admin_menu_sort`,`admin_menu_pid`,`admin_menu_level_path`,`admin_menu_create_time`,`admin_menu_update_time`) values (1,'system','系统管理','md-cog','/system',1,0,'0,1','2021-01-11 19:37:18','2021-01-19 03:55:33'),(2,'AdminUser','用户管理','md-people','AdminUser',3,1,'0,1,2','2021-01-11 19:37:18','2021-01-18 22:53:15'),(12,'AdminRole','角色管理','ios-people','AdminRole',2,1,'0,1,12','2021-01-12 02:54:51','2021-01-18 22:52:54'),(13,'AdminMenu','菜单管理','md-menu','AdminMenu',2,1,'0,1,13','2021-01-12 02:56:07','2021-01-13 01:59:24'),(14,'AdminLog','系统日志','ios-create-outline','adminLog',1,1,'0,1,14','2021-01-12 18:32:06','2021-01-16 19:55:58'),(29,'AdminAuth','权限管理','ios-ribbon','AdminAuth',2,1,'0,1,29','2021-01-13 01:59:07','2021-01-13 01:59:12'),(31,'game','玩家信息','logo-reddit','/game',1,0,'0,31','2022-07-01 16:18:17','2022-07-08 10:41:22'),(33,'Account','角色查询','ios-contact','account',10,31,'0,31,33','2022-07-01 16:21:52','2022-07-06 17:03:27'),(39,'HeroInfo','英雄信息','logo-octocat','HeroInfo',5,31,'0,31,39','2022-07-05 11:02:17','2022-07-05 11:04:06'),(40,'PlayLog','玩家日志','ios-paper','PlayLog',6,31,'0,31,40','2022-07-05 11:03:32','2022-07-05 11:04:02'),(41,'BagInfo','背包信息','ios-basket','BagInfo',9,31,'0,31,41','2022-07-05 11:08:01','2022-07-06 17:03:39'),(43,'Resources','资源管理','ios-basket','/Resources',1,0,'0,43','2022-07-06 16:56:55','2022-07-06 16:57:01'),(44,'Resource','资源查询','ios-basket','Resource',1,43,'0,43,44','2022-07-06 16:58:35','2022-07-06 16:58:35'),(45,'Item','道具查询','logo-dropbox','Item',1,43,'0,43,45','2022-07-06 16:58:55','2022-07-06 16:58:55'),(46,'Shop','商店管理','md-ice-cream','Shop',1,43,'0,43,46','2022-07-06 17:02:38','2022-07-06 17:02:38'),(47,'model','玩法管理','ios-outlet','/model',1,0,'0,47','2022-07-06 19:49:29','2022-07-06 19:49:29'),(48,'Quest','任务查询','md-paper','Quest',1,47,'0,47,48','2022-07-06 19:50:05','2022-07-06 19:50:05'),(49,'copy','副本查询','ios-copy','copy',1,47,'0,47,49','2022-07-06 19:51:12','2022-07-06 19:51:12'),(50,'drawcard','抽卡查询','md-card','drawcard',1,47,'0,47,50','2022-07-06 19:52:28','2022-07-06 19:52:28'),(51,'participate','参与查询','logo-codepen','participate',1,47,'0,47,51','2022-07-06 19:53:54','2022-07-06 19:53:54'),(52,'data','数据管理','logo-buffer','/data',2,0,'0,52','2022-08-18 15:07:26','2022-08-26 17:57:42'),(53,'payData','付费数据','logo-usd','payData',1,52,'0,52,53','2022-08-18 15:08:12','2022-08-18 15:12:20'),(54,'activeData','活跃数据','md-happy','activeData',1,52,'0,52,54','2022-08-26 18:05:11','2022-08-29 16:30:36'),(55,'home','基础数据','logo-freebsd-devil','/home',2,52,'0,52,55','2022-08-26 18:09:42','2022-08-26 18:09:42'),(56,'lostData','流失数据','ios-analytics','lostData',1,52,'0,52,56','2022-08-29 18:24:39','2022-08-29 18:24:50'),(57,'sql','SQL查询','md-color-wand','/sql',1,0,'0,57','2022-08-29 18:30:21','2022-08-29 18:30:21'),(58,'query','SQL查询','md-color-wand','query',1,57,'0,57,58','2022-08-29 18:30:41','2022-08-29 18:30:41');

/*Table structure for table `gm_admin_role` */

DROP TABLE IF EXISTS `gm_admin_role`;

CREATE TABLE `gm_admin_role` (
  `admin_role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_role_code` varchar(50) NOT NULL COMMENT '角色代码',
  `admin_role_name` varchar(50) NOT NULL COMMENT '角色名字',
  `admin_role_desc` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `admin_role_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:启动，2：禁用',
  `admin_auth_id` varchar(500) DEFAULT NULL COMMENT '权限ID集合',
  `admin_menu_id` varchar(500) DEFAULT NULL COMMENT '菜单ID集合',
  `admin_menu_checked_id` varchar(500) DEFAULT NULL COMMENT '菜单ID选中集合',
  `admin_role_create_time` datetime NOT NULL COMMENT '创建时间',
  `admin_role_update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_role_id`),
  UNIQUE KEY `admin_role_code` (`admin_role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

/*Data for the table `gm_admin_role` */

insert  into `gm_admin_role`(`admin_role_id`,`admin_role_code`,`admin_role_name`,`admin_role_desc`,`admin_role_status`,`admin_auth_id`,`admin_menu_id`,`admin_menu_checked_id`,`admin_role_create_time`,`admin_role_update_time`) values (2,'admin','超级管理员','我是超级管理员',1,'24,23,28,27,26,22,14,5,25,21,20,19,18,17,16,15,13,12,11,10,9,8,7,6,3,2,1','1,2,12,13,29,14,3,4,30','1,2,12,13,29,14,3,4,30','2021-01-08 23:06:24','2021-01-18 20:45:18'),(3,'test','测试','',1,'20,17,26,24,21','1,13,29,14','13,29,14','2021-01-09 00:10:40','2022-06-30 23:05:08');

/*Table structure for table `gm_admin_user` */

DROP TABLE IF EXISTS `gm_admin_user`;

CREATE TABLE `gm_admin_user` (
  `admin_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `admin_user_number` varchar(50) NOT NULL COMMENT '账号',
  `admin_user_name` varchar(50) NOT NULL COMMENT '名字',
  `admin_user_area_code` varchar(10) NOT NULL DEFAULT '86' COMMENT '区号',
  `admin_user_phone` varchar(20) NOT NULL COMMENT '电话',
  `admin_user_email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `admin_user_pwd` varchar(50) NOT NULL COMMENT '密码',
  `admin_user_salt` varchar(50) NOT NULL COMMENT '加严',
  `admin_user_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1:启动，2：禁用',
  `admin_user_is_admin` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否超管 1:是，2：否',
  `admin_role_id` int(11) NOT NULL COMMENT '角色ID',
  `admin_auth_id` varchar(500) DEFAULT NULL COMMENT '权限ID集合',
  `admin_menu_id` varchar(500) DEFAULT NULL COMMENT '菜单ID集',
  `admin_menu_checked_id` varchar(500) DEFAULT NULL COMMENT '菜单ID选中集合',
  `admin_user_create_time` datetime NOT NULL COMMENT '创建时间',
  `admin_user_update_time` datetime NOT NULL COMMENT '更新时间',
  `admin_user_remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`admin_user_id`) USING BTREE,
  UNIQUE KEY `admin_user_number` (`admin_user_number`),
  UNIQUE KEY `admin_user_phone` (`admin_user_phone`),
  UNIQUE KEY `admin_user_email` (`admin_user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

/*Data for the table `gm_admin_user` */

insert  into `gm_admin_user`(`admin_user_id`,`admin_user_number`,`admin_user_name`,`admin_user_area_code`,`admin_user_phone`,`admin_user_email`,`admin_user_pwd`,`admin_user_salt`,`admin_user_status`,`admin_user_is_admin`,`admin_role_id`,`admin_auth_id`,`admin_menu_id`,`admin_menu_checked_id`,`admin_user_create_time`,`admin_user_update_time`,`admin_user_remark`) values (1,'admin','超管','86','123132123','12312312@qq.com','68aeba7c2f5ca79b940809853aaf33d4','85b3a144b076230ba6e539933b1b6075',1,1,2,'','1,2,12,13,29,14,3,4,30','1,2,12,13,29,14,3,4,30','2021-01-09 21:34:19','2022-06-30 23:02:30','我是超管'),(9,'test','test2','86','13512351235','13512351235@qq.com','d2756b109e6632eb3a87313e35d8e51c','95fe2dbdf8152d26ff52756c7a8fdc56',1,2,3,'28,27,26,24,23,21,20,18,17,16,15,14,13,12,11,10,9,8,7,6,5,3,2,1','','','2022-06-30 23:04:25','2022-07-04 18:56:04','123');

/*Table structure for table `goods_data` */

DROP TABLE IF EXISTS `goods_data`;

CREATE TABLE `goods_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `playerId` int(10) unsigned NOT NULL,
  `goodsId` int(10) unsigned NOT NULL COMMENT '商品ID',
  `goodsN` int(11) NOT NULL COMMENT '商品n倍数',
  `amount` decimal(13,2) unsigned NOT NULL COMMENT '商品价格',
  `serverId` int(10) unsigned NOT NULL COMMENT '服务器ID',
  `date` datetime NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `goods_data` */

/*Table structure for table `online_player` */

DROP TABLE IF EXISTS `online_player`;

CREATE TABLE `online_player` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `server_id` int(10) unsigned NOT NULL COMMENT '服务器ID',
  `count` int(11) NOT NULL COMMENT '数据统计',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='在线角色统计表';

/*Data for the table `online_player` */

/*Table structure for table `pay_amount` */

DROP TABLE IF EXISTS `pay_amount`;

CREATE TABLE `pay_amount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `server_id` int(10) unsigned NOT NULL COMMENT '服务器ID',
  `total` decimal(13,2) NOT NULL COMMENT '数据统计',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='在线付费统计表';

/*Data for the table `pay_amount` */

/*Table structure for table `player_data` */

DROP TABLE IF EXISTS `player_data`;

CREATE TABLE `player_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `playerId` int(10) unsigned NOT NULL,
  `serverId` int(10) unsigned NOT NULL,
  `firstLevel` int(10) unsigned NOT NULL COMMENT '首冲等级',
  `firstAmount` decimal(13,2) unsigned NOT NULL COMMENT '首冲金额',
  `firstTime` datetime NOT NULL COMMENT '首冲时间',
  `firstBuyAmount` decimal(13,2) unsigned DEFAULT '0.00' COMMENT '首次购买商品金额',
  `firstGoodsId` varchar(255) DEFAULT '0' COMMENT '首冲之后购买的商品',
  `firstGoodsTime` datetime DEFAULT NULL COMMENT '首冲之后购买商品时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `playerId` (`playerId`,`serverId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `player_data` */

/*Table structure for table `player_historical_data` */

DROP TABLE IF EXISTS `player_historical_data`;

CREATE TABLE `player_historical_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL COMMENT '角色ID',
  `duration` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '在线时长 单位S',
  `pay_amount` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '付费金额 USD',
  `server_id` int(10) unsigned NOT NULL COMMENT '游戏服ID',
  `date` date NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `player_id` (`player_id`,`date`,`server_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `player_historical_data` */

/*Table structure for table `player_login_log` */

DROP TABLE IF EXISTS `player_login_log`;

CREATE TABLE `player_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `playerId` int(10) unsigned NOT NULL,
  `serverId` int(10) unsigned NOT NULL,
  `loginTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `player_login_log` */

/*Table structure for table `todaytotal` */

DROP TABLE IF EXISTS `todaytotal`;

CREATE TABLE `todaytotal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active_player` int(10) unsigned NOT NULL COMMENT '当日活跃角色',
  `online_time` int(10) unsigned NOT NULL COMMENT '当日总在线时长',
  `login_num` int(10) unsigned NOT NULL COMMENT '当日总登录次数',
  `server_id` int(10) unsigned NOT NULL COMMENT '游戏服ID',
  `old_player_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老付费角色数量',
  `old_player_amount` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '老付费角色金额',
  `new_player_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '新付费角色数量',
  `new_player_amount` decimal(13,2) unsigned NOT NULL COMMENT '新付费角色金额',
  `add_player_num` int(11) unsigned NOT NULL COMMENT '新增角色数量',
  `old_active_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老玩家活跃人数',
  `new_active_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '新玩家活跃人数',
  `lost` varchar(100) NOT NULL DEFAULT '0,0,0' COMMENT '7/14/30天流失全部用户',
  `payLost` varchar(100) NOT NULL DEFAULT '0,0,0' COMMENT '7/14/30天流失付费用户',
  `reflow` varchar(100) NOT NULL DEFAULT '0,0,0' COMMENT '7/14/30天回流全部用户',
  `payReflow` varchar(100) NOT NULL DEFAULT '0,0,0' COMMENT '7/14/30天回流付费用户',
  `date` date NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`,`server_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `todaytotal` */

/*Table structure for table `vip_pay` */

DROP TABLE IF EXISTS `vip_pay`;

CREATE TABLE `vip_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT '消费金额,订单表无数据暂时取不到',
  `diamond` int(10) unsigned NOT NULL COMMENT '到账钻石',
  `serverId` int(10) unsigned NOT NULL,
  `playerId` int(10) unsigned NOT NULL,
  `createTime` datetime NOT NULL,
  `uid` varchar(65) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `vip_pay` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

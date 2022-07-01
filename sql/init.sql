/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 5.7.26 : Database - db_newgm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `gm_admin_auth`;

CREATE TABLE `gm_admin_auth` (
  `admin_auth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_auth_name` varchar(50) NOT NULL COMMENT '名字',
  `admin_auth_desc` varchar(255) DEFAULT NULL COMMENT '权限描述',
  `admin_auth_path` varchar(100) NOT NULL COMMENT '路径',
  `admin_auth_create_time` datetime NOT NULL COMMENT '创建时间',
  `admin_auth_update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

/*Data for the table `gm_admin_auth` */

insert  into `gm_admin_auth`(`admin_auth_id`,`admin_auth_name`,`admin_auth_desc`,`admin_auth_path`,`admin_auth_create_time`,`admin_auth_update_time`) values 
(1,'用户管理-查询接口','','admin/AdminUser/userList','2021-01-12 19:08:26','2021-01-16 01:19:48'),
(2,'用户管理-添加接口','','admin/AdminUser/userAdd','2021-01-12 19:08:59','2021-01-16 01:21:44'),
(3,'用户管理-修改接口','修改','admin/AdminUser/userEdit','2021-01-12 19:09:53','2021-01-16 01:21:40'),
(5,'用户管理-删除接口','','admin/AdminUser/userDel','2021-01-13 02:00:16','2021-01-16 01:21:36'),
(6,'用户管理-状态修改','','admin/AdminUser/userStatusUpdate','2021-01-15 17:07:10','2021-01-16 01:21:32'),
(7,'用户管理-设定超管','','admin/AdminUser/userIsAdmin','2021-01-15 17:08:18','2021-01-16 01:21:26'),
(8,'用户管理-分配菜单','','admin/AdminUser/userMenu','2021-01-15 17:08:38','2021-01-16 01:21:22'),
(9,'用户管理-分配权限','','admin/AdminUser/userAuth','2021-01-15 17:08:51','2021-01-16 01:21:18'),
(10,'用户管理-重置登陆密码','','admin/AdminUser/userNewPwd','2021-01-15 17:09:08','2021-01-16 01:21:13'),
(11,'角色管理-查询接口','','admin/AdminRole/roleList','2021-01-15 17:10:42','2021-01-16 01:21:09'),
(12,'角色管理-添加接口','','admin/AdminRole/roleAdd','2021-01-15 17:11:02','2021-01-16 01:21:03'),
(13,'角色管理-修改接口','','admin/AdminRole/roleEdit','2021-01-15 17:11:14','2021-01-16 01:20:58'),
(14,'角色管理-删除接口','','admin/AdminRole/roleDel','2021-01-15 17:11:36','2021-01-16 01:20:47'),
(15,'角色管理-状态修改','','admin/AdminRole/roleStatusUpdate','2021-01-15 17:13:30','2021-01-16 01:20:54'),
(16,'角色管理-分配菜单','','admin/AdminRole/roleMenu','2021-01-15 17:14:55','2021-01-16 01:20:41'),
(17,'角色管理-分配权限','','admin/AdminRole/roleAuth','2021-01-15 17:15:15','2021-01-16 01:20:36'),
(18,'菜单管理-查询接口','','admin/AdminMenu/menuList','2021-01-15 17:15:54','2021-01-16 01:20:32'),
(19,'菜单管理-获取菜单信息','','admin/AdminMenu/menuInfo','2021-01-15 17:16:21','2021-01-16 01:20:28'),
(20,'菜单管理-添加接口','','admin/AdminMenu/menuAdd','2021-01-15 17:16:58','2021-01-16 01:20:23'),
(21,'菜单管理-修改接口','','admin/AdminMenu/menuEdit','2021-01-15 17:17:14','2021-01-16 01:20:18'),
(22,'菜单管理-删除接口','','admin/AdminMenu/menuDel','2021-01-15 17:17:26','2021-01-16 01:20:14'),
(23,'权限管理-查询接口','','admin/AdminAuth/authList','2021-01-15 17:20:09','2021-01-16 01:20:10'),
(24,'权限管理-添加接口','','admin/AdminAuth/authAdd','2021-01-15 17:20:46','2021-01-16 01:20:06'),
(25,'权限管理-修改接口','','admin/AdminAuth/authEdit','2021-01-15 17:21:01','2021-01-16 01:20:03'),
(26,'权限管理-删除接口','','admin/AdminAuth/authDel','2021-01-15 17:21:11','2021-01-16 01:19:59'),
(27,'系统日志-查询接口','','admin/AdminLog/logList','2021-01-16 20:01:34','2021-01-16 20:03:10'),
(28,'系统日志-详情接口','','admin/AdminLog/logInfo','2021-01-16 20:02:51','2021-01-16 20:02:51');

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

/*Data for the table `gm_admin_menu` */

insert  into `gm_admin_menu`(`admin_menu_id`,`admin_menu_name`,`admin_menu_title`,`admin_menu_icon`,`admin_menu_path`,`admin_menu_sort`,`admin_menu_pid`,`admin_menu_level_path`,`admin_menu_create_time`,`admin_menu_update_time`) values 
(1,'system','系统管理','md-cog','/system',1,0,'0,1','2021-01-11 19:37:18','2021-01-19 03:55:33'),
(2,'AdminUser','用户管理','md-people','AdminUser',3,1,'0,1,2','2021-01-11 19:37:18','2021-01-18 22:53:15'),
(12,'AdminRole','角色管理','ios-people','AdminRole',2,1,'0,1,12','2021-01-12 02:54:51','2021-01-18 22:52:54'),
(13,'AdminMenu','菜单管理','md-menu','AdminMenu',2,1,'0,1,13','2021-01-12 02:56:07','2021-01-13 01:59:24'),
(14,'AdminLog','系统日志','ios-create-outline','adminLog',1,1,'0,1,14','2021-01-12 18:32:06','2021-01-16 19:55:58'),
(29,'AdminAuth','权限管理','ios-ribbon','AdminAuth',2,1,'0,1,29','2021-01-13 01:59:07','2021-01-13 01:59:12');

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

insert  into `gm_admin_role`(`admin_role_id`,`admin_role_code`,`admin_role_name`,`admin_role_desc`,`admin_role_status`,`admin_auth_id`,`admin_menu_id`,`admin_menu_checked_id`,`admin_role_create_time`,`admin_role_update_time`) values 
(2,'admin','超级管理员','我是超级管理员',1,'24,23,28,27,26,22,14,5,25,21,20,19,18,17,16,15,13,12,11,10,9,8,7,6,3,2,1','1,2,12,13,29,14,3,4,30','1,2,12,13,29,14,3,4,30','2021-01-08 23:06:24','2021-01-18 20:45:18'),
(3,'test','测试','',1,'26,24,21','1,29,14,3,4,30','29,14,3,4,30','2021-01-09 00:10:40','2021-01-18 21:56:41');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

/*Data for the table `gm_admin_user` */

insert  into `gm_admin_user`(`admin_user_id`,`admin_user_number`,`admin_user_name`,`admin_user_area_code`,`admin_user_phone`,`admin_user_email`,`admin_user_pwd`,`admin_user_salt`,`admin_user_status`,`admin_user_is_admin`,`admin_role_id`,`admin_auth_id`,`admin_menu_id`,`admin_menu_checked_id`,`admin_user_create_time`,`admin_user_update_time`,`admin_user_remark`) values 
(1,'admin','超管','86','15116399134','1214096242@qq.com','68aeba7c2f5ca79b940809853aaf33d4','85b3a144b076230ba6e539933b1b6075',1,1,2,'28,27,26,25,24,23,22,21,20,19,18,17,15,13,12,11,10,9,8,7,5,6,3,2,1','1,2,12,13,29,14,3,4,30','1,2,12,13,29,14,3,4,30','2021-01-09 21:34:19','2021-01-18 19:11:48','我是超管'),
(6,'test','测试号s','86','13512351235','','9f346969b20f445cc8015ff9a4e45058','e2dd555b288f7fe57912a1814eed76b4',1,2,3,'18,24,23,21,20','3,4,30','3,4,30','2021-01-16 03:28:45','2021-03-06 15:38:11',''),
(8,'demo','demo','86','13612361237',NULL,'d784493de84b7fe08a71e4afc25e2f81','4b3065b27bc0d09ed3ae865a154d8eb7',1,2,3,'1,23,19,17,24,22,21,18','1,14,3,4,30,42','14,3,4,30,42','2021-01-16 23:05:28','2021-03-06 15:37:42','');
/*
SQLyog Ultimate v11.13 (64 bit)
MySQL - 5.5.5-10.1.8-MariaDB : Database - zuan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zuan` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `zuan`;

/*Table structure for table `taobao` */

DROP TABLE IF EXISTS `taobao`;

CREATE TABLE `taobao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `pwd` varchar(64) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `task` */

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1' COMMENT '1手动 2自动',
  `buyer` int(11) DEFAULT NULL,
  `seller` int(11) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `qq` varchar(20) DEFAULT NULL,
  `search_key` varchar(64) DEFAULT NULL,
  `rank` varchar(64) DEFAULT NULL,
  `comment` varchar(512) DEFAULT NULL,
  `time` varchar(256) DEFAULT NULL,
  `remark` varchar(256) DEFAULT NULL,
  `condition` varchar(256) DEFAULT NULL COMMENT '产品条件',
  `status` tinyint(4) DEFAULT '0' COMMENT '0未开始 1进行中 2完成',
  `step` tinyint(4) DEFAULT '0',
  `other_task_id` int(11) DEFAULT NULL COMMENT '互刷任务id',
  `start_time` datetime DEFAULT NULL COMMENT '互刷开始时间',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Table structure for table `task_invite` */

DROP TABLE IF EXISTS `task_invite`;

CREATE TABLE `task_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `my_task_id` int(11) DEFAULT NULL,
  `other_task_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '-1拒绝邀请 0邀请中 1接受邀请',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Table structure for table `trans` */

DROP TABLE IF EXISTS `trans`;

CREATE TABLE `trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) DEFAULT NULL COMMENT '交易类型',
  `amount` decimal(10,2) DEFAULT NULL,
  `detail` varchar(128) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf32 NOT NULL,
  `pwd` varchar(32) CHARACTER SET utf32 NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `point` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `seller` varchar(256) DEFAULT '',
  `buyer` varchar(256) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

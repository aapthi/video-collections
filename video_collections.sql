/*
SQLyog Community v11.52 (32 bit)
MySQL - 5.6.17 : Database - video_collections
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`video_collections` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `video_collections`;

/*Table structure for table `session` */

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
  `id` char(32) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `session` */

insert  into `session`(`id`,`name`,`modified`,`lifetime`,`data`) values ('5698b0pbnnd1kenmm9ioi5dn31','PHPSESSID',1442838611,1800,'__ZF|a:1:{s:20:\"_REQUEST_ACCESS_TIME\";d:1442838611.896677;}initialized|C:23:\"Zend\\Stdlib\\ArrayObject\":127:{a:4:{s:7:\"storage\";a:1:{s:4:\"init\";i:1;}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}'),('ivnjk0vl1cbetiv34csvb83e06','PHPSESSID',1442844974,1800,'__ZF|a:1:{s:20:\"_REQUEST_ACCESS_TIME\";d:1442844974.6006031;}initialized|C:23:\"Zend\\Stdlib\\ArrayObject\":127:{a:4:{s:7:\"storage\";a:1:{s:4:\"init\";i:1;}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}admin|C:23:\"Zend\\Stdlib\\ArrayObject\":206:{a:4:{s:7:\"storage\";a:3:{s:8:\"username\";s:14:\"Administration\";s:5:\"email\";s:15:\"admin@gmail.com\";s:7:\"user_id\";s:1:\"9\";}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}'),('cg8gn9sebc4sfh6vuvf85d1nu3','PHPSESSID',1442900867,1800,'__ZF|a:1:{s:20:\"_REQUEST_ACCESS_TIME\";d:1442900866.8036771;}initialized|C:23:\"Zend\\Stdlib\\ArrayObject\":127:{a:4:{s:7:\"storage\";a:1:{s:4:\"init\";i:1;}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}');

/*Table structure for table `vc_categories` */

DROP TABLE IF EXISTS `vc_categories`;

CREATE TABLE `vc_categories` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) DEFAULT NULL,
  `status` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vc_categories` */

/*Table structure for table `vc_forget_tokens` */

DROP TABLE IF EXISTS `vc_forget_tokens`;

CREATE TABLE `vc_forget_tokens` (
  `forget_pwd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `token_id` varchar(50) DEFAULT NULL,
  `status` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`forget_pwd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vc_forget_tokens` */

/*Table structure for table `vc_payments` */

DROP TABLE IF EXISTS `vc_payments`;

CREATE TABLE `vc_payments` (
  `payment_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(150) DEFAULT NULL,
  `video_id` int(50) DEFAULT NULL,
  `amount` varchar(150) DEFAULT NULL,
  `txnid` varchar(150) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vc_payments` */

/*Table structure for table `vc_type_of_video` */

DROP TABLE IF EXISTS `vc_type_of_video`;

CREATE TABLE `vc_type_of_video` (
  `typeofvideo_id` int(15) NOT NULL AUTO_INCREMENT,
  `video_type` varchar(50) DEFAULT NULL,
  `state` tinyint(5) DEFAULT NULL,
  PRIMARY KEY (`typeofvideo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `vc_type_of_video` */

insert  into `vc_type_of_video`(`typeofvideo_id`,`video_type`,`state`) values (1,'normal',1),(2,'featured',1);

/*Table structure for table `vc_user_details` */

DROP TABLE IF EXISTS `vc_user_details`;

CREATE TABLE `vc_user_details` (
  `ud_id` int(15) NOT NULL AUTO_INCREMENT,
  `u_id` int(150) DEFAULT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `user_photo` varchar(150) DEFAULT NULL,
  `permanent_address` text,
  `persent_address` text,
  `country` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `alter_number` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vc_user_details` */

/*Table structure for table `vc_users` */

DROP TABLE IF EXISTS `vc_users`;

CREATE TABLE `vc_users` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(150) DEFAULT NULL,
  `email_id` varchar(60) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `status` tinyint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `vc_users` */

insert  into `vc_users`(`user_id`,`user_name`,`email_id`,`password`,`contact_number`,`status`,`created_at`,`updated_at`) values (9,'Administration','admin@gmail.com','928685e214fa387530cc8e14d09a1858','9999999999',1,'2015-09-21 18:33:04','2015-09-21 18:33:06');

/*Table structure for table `vc_videos` */

DROP TABLE IF EXISTS `vc_videos`;

CREATE TABLE `vc_videos` (
  `v_id` int(10) NOT NULL AUTO_INCREMENT,
  `v_cat_id` int(15) DEFAULT NULL,
  `v_title` text,
  `v_link` text,
  `v_thumb_link` text,
  `v_thumb_image` varchar(150) DEFAULT NULL,
  `v_desc` text,
  `type_of_video` smallint(5) DEFAULT NULL,
  `state` tinyint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vc_videos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

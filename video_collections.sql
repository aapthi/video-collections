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

insert  into `session`(`id`,`name`,`modified`,`lifetime`,`data`) values ('02c2a352e980b79d238f7c915ea5cf71','PHPSESSID',1443193080,1440,'__ZF|a:1:{s:20:\"_REQUEST_ACCESS_TIME\";d:1443193080.420692920684814453125;}initialized|C:23:\"Zend\\Stdlib\\ArrayObject\":127:{a:4:{s:7:\"storage\";a:1:{s:4:\"init\";i:1;}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}'),('efe8a45a72d0d14bf5795abd3083afc1','PHPSESSID',1443193882,1440,'__ZF|a:1:{s:20:\"_REQUEST_ACCESS_TIME\";d:1443193882.269216060638427734375;}initialized|C:23:\"Zend\\Stdlib\\ArrayObject\":127:{a:4:{s:7:\"storage\";a:1:{s:4:\"init\";i:1;}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}admin|C:23:\"Zend\\Stdlib\\ArrayObject\":237:{a:4:{s:7:\"storage\";a:4:{s:8:\"username\";s:14:\"Administration\";s:11:\"displayname\";s:5:\"Admin\";s:5:\"email\";s:15:\"admin@gmail.com\";s:7:\"user_id\";s:1:\"9\";}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}'),('2f61178d680176f844260a49ed056129','PHPSESSID',1443193933,1440,'__ZF|a:1:{s:20:\"_REQUEST_ACCESS_TIME\";d:1443193933.836577892303466796875;}initialized|C:23:\"Zend\\Stdlib\\ArrayObject\":127:{a:4:{s:7:\"storage\";a:1:{s:4:\"init\";i:1;}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}HA::CONFIG|a:3:{s:14:\"php_session_id\";s:40:\"s:32:\"2f61178d680176f844260a49ed056129\";\";s:7:\"version\";s:16:\"s:9:\"2.1.1-dev\";\";s:6:\"config\";s:2073:\"a:8:{s:8:\"base_url\";s:57:\"http://mathassess.com/video-blogger/scn-social-auth/hauth\";s:9:\"providers\";a:8:{s:8:\"Facebook\";a:4:{s:7:\"enabled\";b:1;s:4:\"keys\";a:2:{s:2:\"id\";s:15:\"743509642461911\";s:6:\"secret\";s:32:\"87b315515d5ca62f066c7eb9eabda26e\";}s:5:\"scope\";N;s:7:\"display\";s:5:\"popup\";}s:10:\"Foursquare\";a:2:{s:7:\"enabled\";b:0;s:4:\"keys\";a:2:{s:2:\"id\";N;s:6:\"secret\";N;}}s:6:\"GitHub\";a:4:{s:7:\"enabled\";b:0;s:4:\"keys\";a:2:{s:2:\"id\";N;s:6:\"secret\";N;}s:5:\"scope\";N;s:7:\"wrapper\";a:2:{s:5:\"class\";s:23:\"Hybrid_Providers_GitHub\";s:4:\"path\";s:114:\"/home/mathuser1234/public_html/video-blogger/module/ScnSocialAuth/src/ScnSocialAuth/HybridAuth/Provider/GitHub.php\";}}s:6:\"Google\";a:4:{s:7:\"enabled\";b:1;s:4:\"keys\";a:2:{s:2:\"id\";s:72:\"853225795421-miuf13lftpnd3uikfqp5e2cprdrp4gcg.apps.googleusercontent.com\";s:6:\"secret\";s:24:\"JnudpiDquWSJhGaAz9HZjN9U\";}s:5:\"scope\";N;s:2:\"hd\";N;}s:8:\"LinkedIn\";a:2:{s:7:\"enabled\";b:0;s:4:\"keys\";a:2:{s:3:\"key\";N;s:6:\"secret\";N;}}s:7:\"Twitter\";a:2:{s:7:\"enabled\";b:0;s:4:\"keys\";a:2:{s:3:\"key\";s:20:\"HV1MUV4alQtbq9jpsLPQ\";s:6:\"secret\";s:41:\"bJ0nZnzf79H9GC1KkSXkGPESfGi31Uuwgro0ZdVks\";}}s:5:\"Yahoo\";a:2:{s:7:\"enabled\";b:0;s:4:\"keys\";a:2:{s:3:\"key\";N;s:6:\"secret\";N;}}s:6:\"Tumblr\";a:3:{s:7:\"enabled\";b:0;s:4:\"keys\";a:2:{s:3:\"key\";N;s:6:\"secret\";N;}s:7:\"wrapper\";a:2:{s:5:\"class\";s:23:\"Hybrid_Providers_Tumblr\";s:4:\"path\";s:114:\"/home/mathuser1234/public_html/video-blogger/module/ScnSocialAuth/src/ScnSocialAuth/HybridAuth/Provider/Tumblr.php\";}}}s:9:\"path_base\";s:102:\"/home/mathuser1234/public_html/video-blogger/module/ScnSocialAuth/src/ScnSocialAuth/HybridAuth/Hybrid/\";s:14:\"path_libraries\";s:113:\"/home/mathuser1234/public_html/video-blogger/module/ScnSocialAuth/src/ScnSocialAuth/HybridAuth/Hybrid/thirdparty/\";s:14:\"path_resources\";s:112:\"/home/mathuser1234/public_html/video-blogger/module/ScnSocialAuth/src/ScnSocialAuth/HybridAuth/Hybrid/resources/\";s:14:\"path_providers\";s:112:\"/home/mathuser1234/public_html/video-blogger/module/ScnSocialAuth/src/ScnSocialAuth/HybridAuth/Hybrid/Providers/\";s:10:\"debug_mode\";b:0;s:10:\"debug_file\";N;}\";}HA::STORE|a:5:{s:35:\"hauth_session.facebook.is_logged_in\";s:4:\"i:1;\";s:41:\"hauth_session.facebook.token.access_token\";s:204:\"s:195:\"CAAKkN9QgQtcBANJWgeUrbey7tY3MaDBW1sEXBv3EJNUSgaDQTt30ZBy6mOGb9Xs3u6SzvWEqsiAM6ZAk2KUpQYHhtE3ClShC9lNlc7HuPNjFd9LlXRbpB3AAlVmfJ9IfRIojmGWLUqcFnGU69Lx7ZBYZB8HliJamelVSW0V76FQUZAnGuWmnSbUcxzBRdhTAZD\";\";s:36:\"hauth_session.google.hauth_return_to\";s:56:\"s:48:\"/video-blogger/user/authenticate?provider=google\";\";s:35:\"hauth_session.google.hauth_endpoint\";s:83:\"s:75:\"http://mathassess.com/video-blogger/scn-social-auth/hauth?hauth.done=Google\";\";s:39:\"hauth_session.google.id_provider_params\";s:401:\"a:5:{s:15:\"hauth_return_to\";s:48:\"/video-blogger/user/authenticate?provider=google\";s:11:\"hauth_token\";s:32:\"2f61178d680176f844260a49ed056129\";s:10:\"hauth_time\";i:1443190813;s:11:\"login_start\";s:98:\"http://mathassess.com/video-blogger/scn-social-auth/hauth?hauth.start=Google&hauth.time=1443190813\";s:10:\"login_done\";s:75:\"http://mathassess.com/video-blogger/scn-social-auth/hauth?hauth.done=Google\";}\";}ScnSocialAuth\\Authentication\\Adapter\\HybridAuth|C:23:\"Zend\\Stdlib\\ArrayObject\":112:{a:4:{s:7:\"storage\";a:0:{}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}Zend_Auth|C:23:\"Zend\\Stdlib\\ArrayObject\":283:{a:4:{s:7:\"storage\";a:4:{s:7:\"storage\";i:17;s:8:\"photoURL\";s:71:\"https://graph.facebook.com/788432624612360/picture?width=150&height=150\";s:5:\"email\";s:0:\"\";s:11:\"displayName\";s:12:\"Dileep Kumar\";}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}fb_743509642461911_access_token|s:195:\"CAAKkN9QgQtcBANJWgeUrbey7tY3MaDBW1sEXBv3EJNUSgaDQTt30ZBy6mOGb9Xs3u6SzvWEqsiAM6ZAk2KUpQYHhtE3ClShC9lNlc7HuPNjFd9LlXRbpB3AAlVmfJ9IfRIojmGWLUqcFnGU69Lx7ZBYZB8HliJamelVSW0V76FQUZAnGuWmnSbUcxzBRdhTAZD\";fb_743509642461911_user_id|s:15:\"788432624612360\";admin|C:23:\"Zend\\Stdlib\\ArrayObject\":237:{a:4:{s:7:\"storage\";a:4:{s:8:\"username\";s:14:\"Administration\";s:11:\"displayname\";s:5:\"Admin\";s:5:\"email\";s:15:\"admin@gmail.com\";s:7:\"user_id\";s:1:\"9\";}s:4:\"flag\";i:2;s:13:\"iteratorClass\";s:13:\"ArrayIterator\";s:19:\"protectedProperties\";N;}}');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `state` tinyint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`username`,`email`,`password`,`display_name`,`contact_number`,`state`,`created_at`,`updated_at`) values (9,'Administration','admin@gmail.com','b59c67bf196a4758191e42f76670ceba','Admin','9999999999',1,'2015-09-21 18:33:04','2015-09-21 18:33:06'),(15,'Dileep','dkonda@aapthitech.com','ea452f3b31ac158c119a0b295740d63e','Dileep','9701059345',1,'2015-09-24 08:32:00','2015-09-24 13:13:49'),(16,'DileepKumar','dileepkumarkonda@gmail.com','ea452f3b31ac158c119a0b295740d63e','DileepKumar','9701059345',1,'2015-09-25 12:56:59','2015-09-25 12:58:13'),(17,NULL,'','facebookToLocalUser','Dileep Kumar',NULL,1,'2015-09-25 13:54:47',NULL);

/*Table structure for table `user_provider` */

DROP TABLE IF EXISTS `user_provider`;

CREATE TABLE `user_provider` (
  `user_id` int(10) NOT NULL,
  `provider_id` varchar(50) NOT NULL,
  `provider` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`,`provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user_provider` */

insert  into `user_provider`(`user_id`,`provider_id`,`provider`) values (17,'788432624612360','facebook');

/*Table structure for table `vc_categories` */

DROP TABLE IF EXISTS `vc_categories`;

CREATE TABLE `vc_categories` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) DEFAULT NULL,
  `parent_cat_id` bigint(10) DEFAULT NULL,
  `status` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

/*Data for the table `vc_categories` */

insert  into `vc_categories`(`category_id`,`category_name`,`parent_cat_id`,`status`,`created_at`,`modified_at`) values (58,'Popular on YouTube ',NULL,1,'2015-09-25 07:47:56','2015-09-25 13:20:35'),(60,'Music',NULL,1,'2015-09-25 07:48:11',NULL),(62,'Sports',NULL,1,'2015-09-25 07:49:00',NULL),(64,'Gaming',NULL,1,'2015-09-25 07:49:32',NULL),(66,'Movies',NULL,1,'2015-09-25 07:49:43',NULL),(68,'Tv Shows',NULL,1,'2015-09-25 07:50:11',NULL),(70,'News',NULL,1,'2015-09-25 07:50:22',NULL),(72,'Live',NULL,1,'2015-09-25 07:53:56',NULL),(79,'Spotlight',NULL,1,'2015-09-25 08:18:28',NULL),(80,'Live Score',NULL,1,'2015-09-25 13:21:00',NULL),(81,'Spot Event',NULL,1,'2015-09-25 13:21:22',NULL),(82,'Weather',NULL,1,'2015-09-25 14:53:29',NULL);

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
  `s_state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `alter_number` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ud_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `vc_user_details` */

insert  into `vc_user_details`(`ud_id`,`u_id`,`first_name`,`last_name`,`user_photo`,`permanent_address`,`persent_address`,`country`,`s_state`,`city`,`zipcode`,`alter_number`,`created_at`,`updated_at`) values (18,15,'Dileep','KumarRaj',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-09-24 08:56:18','2015-09-24 08:56:18'),(19,16,'DileepKumar','KumarDileep',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-09-25 12:58:13','2015-09-25 12:58:13'),(20,17,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-09-25 13:54:47',NULL);

/*Table structure for table `vc_videos` */

DROP TABLE IF EXISTS `vc_videos`;

CREATE TABLE `vc_videos` (
  `v_id` int(10) NOT NULL AUTO_INCREMENT,
  `v_user_id` int(15) DEFAULT NULL,
  `v_cat_id` int(15) DEFAULT NULL,
  `v_title` text,
  `v_link` text,
  `v_thumb_image` varchar(150) DEFAULT NULL,
  `v_desc` text,
  `type_of_video` varchar(50) DEFAULT NULL,
  `v_state` tinyint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `browsed_video` varchar(50) DEFAULT NULL,
  `browsed_imagecode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Data for the table `vc_videos` */

insert  into `vc_videos`(`v_id`,`v_user_id`,`v_cat_id`,`v_title`,`v_link`,`v_thumb_image`,`v_desc`,`type_of_video`,`v_state`,`created_at`,`updated_at`,`browsed_video`,`browsed_imagecode`) values (14,9,58,'Tamasha | Official Trailer | Deepika Padukone, Ranbir Kapoor | In Cinemas Nov 27 ','https://www.youtube.com/watch?v=VN_qxutU_qc','http://i.ytimg.com/vi/VN_qxutU_qc/default.jpg','Published on Sep 22, 2015\r\n\r\nUTV Motion Pictures & Nadiadwala Grandson Entertainment Pvt. Ltd. present Tamasha starring Ranbir Kapoor and Deepika Padukone. The film is directed by Imtiaz Ali and produced by Sajid Nadiadwala releases on November 27.','featured',1,'2015-09-25 08:27:18','2015-09-25 13:24:14','youtube','VN_qxutU_qc'),(15,9,58,'Puli - Official Trailer 2 | Vijay, Sridevi, Sudeep, Shruti Haasan, Hansika Motwani ','https://www.youtube.com/watch?v=DQdHf1pzGqc','http://i.ytimg.com/vi/DQdHf1pzGqc/default.jpg','Everyone is entitled to their own opinion. But I don\'t understand two things from Tamil people. One why is it so important for people to abuse a popular actor? I understand people have their favourites, but even around the world, for example in Hollywood, I may like Robert Downey Jr., but that doesn\'t mean I won\'t appreciate any other actors work. Even if it isn\'t my favourite actor I still try to be positive and enjoy the film. From where I see this movie, it is a step forward for Tamil cinema. Another thing I don\'t understand is why people are commenting bad about the cgi. ','featured',1,'2015-09-25 08:29:51','2015-09-25 13:24:32','youtube','DQdHf1pzGqc'),(16,9,58,'Akhil Theatrical Trailer || Akhil Akkineni, Sayyeshaa Saigal || VV Vinayak , Nithin','https://www.youtube.com/watch?v=jXXz-Jo9cu8','http://i.ytimg.com/vi/jXXz-Jo9cu8/default.jpg','Watch: Akhil Theatrical Trailer, Starring Akhil Akkineni, Sayyeshaa Saigal in lead roles, Anup Rubens & S. Thaman together composed the music. Written by Veligonda Srinivas and Directed by VV Vinayak, Produced jointly by actor Nithiin and his father Sudhakar Reddy on Sreshth Movies banner. Stay tuned to Sreshth ','normal',1,'2015-09-25 08:31:25','2015-09-25 13:24:57','youtube','jXXz-Jo9cu8'),(17,9,60,'Srimanthudu Full Songs Jukebox || Mahesh Babu, Shruthi Hasan, Devi Sri Prasad ','https://www.youtube.com/watch?v=4kYfcwZCbiw','http://i.ytimg.com/vi/4kYfcwZCbiw/default.jpg','Listen & Enjoy Srimanthudu Songs Jukebox Starring Mahesh Babu, Shruthi Hasan,Music Composed by Devi Sri Prasad,Directed by Koratala Siva,Produced by Y.Naveen, Y.Ravi,C.V. Mohan Under the Banner of Mythri Movie Makers.','featured',1,'2015-09-25 09:27:20','2015-09-25 13:25:05','youtube','4kYfcwZCbiw'),(18,9,60,' Dheere Dheere Se Meri Zindagi Video Song (OFFICIAL) Hrithik Roshan, Sonam Kapoor | Yo Yo Honey Singh','https://www.youtube.com/watch?v=nCD2hj6zJEc','http://i.ytimg.com/vi/nCD2hj6zJEc/default.jpg','In Loving Memory of Shri GULSHAN KUMAR, we present to you Bhushan Kumar\'s \"Dheere Dheere Se Meri Zindagi\" Song recreated by YO YO HONEY SINGH directed by Ahmed Khan featuring HRITHIK ROSHAN & SONAM KAPOOR exclusively on T-Series.\r\nClick to share it on FB: http://bit.ly/DheereDh','normal',1,'2015-09-25 09:28:55','2015-09-25 13:25:14','youtube','nCD2hj6zJEc'),(19,9,62,'20 Perfectly Timed Sports Photos ','https://www.youtube.com/watch?v=QeXXImhgXFo','http://i.ytimg.com/vi/QeXXImhgXFo/default.jpg','Electro Cabello\" Kevin MacLeod (incompetech.com)\r\nLicensed under Creative Commons: By Attribution 3.0','featured',1,'2015-09-25 09:30:58','2015-09-25 13:25:23','youtube','QeXXImhgXFo'),(20,9,62,'Manchester United Vs Ipswich 3-0 - All Goals & Match Highlights - September 23 2015 - [HD] ','https://www.youtube.com/watch?v=U8pmgW-lk-M','http://i.ytimg.com/vi/U8pmgW-lk-M/default.jpg','Manchester United Vs Ipswich 3-0 - All Goals & Match Highlights - September 23 2015 - [HD] ','featured',1,'2015-09-25 14:01:13',NULL,'youtube','U8pmgW-lk-M'),(21,9,62,'Usain Bolt Knocked Over By Cameraman On Segway After Winning World Championship 200m Gold ','https://www.youtube.com/watch?v=NSo8sfJnLgU','http://i.ytimg.com/vi/NSo8sfJnLgU/default.jpg','Usain Bolt Knocked Over By Cameraman On Segway After Winning World Championship 200m Gold ','normal',1,'2015-09-25 14:02:04',NULL,'youtube','NSo8sfJnLgU'),(22,9,62,'Ronnie O\'Sullivan Incredible Fluke Shot On The Yellow To Equal Record 775 Century Breaks ','https://www.youtube.com/watch?v=ANjmLfoLiA0','http://i.ytimg.com/vi/ANjmLfoLiA0/default.jpg','Ronnie O\'Sullivan Incredible Fluke Shot On The Yellow To Equal Record 775 Century Breaks ','normal',1,'2015-09-25 14:02:41',NULL,'youtube','ANjmLfoLiA0'),(23,9,64,'Minecraft: CHANCE CUBES! (THE NEW LUCKY BLOCK?!) Mod Showcase ','https://www.youtube.com/watch?v=5thr3eGmh6k','http://i.ytimg.com/vi/5thr3eGmh6k/default.jpg','Minecraft: CHANCE CUBES! (THE NEW LUCKY BLOCK?!) Mod Showcase ','featured',0,'2015-09-25 14:03:28','2015-09-25 14:18:10','youtube','5thr3eGmh6k'),(24,9,64,'Minecraft: MUTANT SPIDER! (THE BEAST IS HERE!) Mod Showcase ','https://www.youtube.com/watch?v=cj480Y7Rs2k','http://i.ytimg.com/vi/cj480Y7Rs2k/default.jpg','Minecraft: MUTANT SPIDER! (THE BEAST IS HERE!) Mod Showcase ','featured',1,'2015-09-25 14:04:14',NULL,'youtube','cj480Y7Rs2k'),(25,9,68,'Devon Ke Dev... Mahadev - 12th December 2014 : Ep 818 ','https://www.youtube.com/watch?v=rRnTyVf8EUs','http://i.ytimg.com/vi/rRnTyVf8EUs/default.jpg','Devon Ke Dev... Mahadev - 12th December 2014 : Ep 818 ','normal',1,'2015-09-25 14:05:39',NULL,'youtube','rRnTyVf8EUs'),(26,9,68,'Devon Ke Dev... Mahadev - 24th October 2012 ','https://www.youtube.com/watch?v=eA7S8ITc6Xs','http://i.ytimg.com/vi/eA7S8ITc6Xs/default.jpg','Devon Ke Dev... Mahadev - 24th October 2012 ','normal',1,'2015-09-25 14:06:29',NULL,'youtube','eA7S8ITc6Xs'),(27,9,70,'NTV - Live Now ','https://www.youtube.com/watch?v=SXA_DHQb0_s','http://i.ytimg.com/vi/SXA_DHQb0_s/default.jpg','NTV - Live Now ','normal',1,'2015-09-25 14:07:41',NULL,'youtube','SXA_DHQb0_s'),(28,9,70,'Posani Krishna Murali Comedy Scenes | Vol 1 | Back to Back Comedy Scenes | Sri Balaji Video','https://www.youtube.com/watch?v=Nu_Sy9idjco','http://i.ytimg.com/vi/Nu_Sy9idjco/default.jpg','Posani Krishna Murali Comedy Scenes | Vol 1 | Back to Back Comedy Scenes | Sri Balaji Video','featured',1,'2015-09-25 14:08:25',NULL,'youtube','Nu_Sy9idjco'),(29,9,62,'Top 15 Saddest Sports Deaths','https://www.youtube.com/watch?v=6v990GwgzZI','http://i.ytimg.com/vi/6v990GwgzZI/default.jpg','Top 15 Saddest Sports Deaths','normal',1,'2015-09-25 14:09:30',NULL,'youtube','6v990GwgzZI'),(30,9,70,'Authorities take back autographed tricolour from Vikas Khanna after violation of flag code ','https://www.youtube.com/watch?v=K0AxEb2xX5c','http://i.ytimg.com/vi/K0AxEb2xX5c/default.jpg','Authorities take back autographed tricolour from Vikas Khanna after violation of flag code ','normal',1,'2015-09-25 14:29:41',NULL,'youtube','K0AxEb2xX5c'),(31,9,70,'PC: Will support BJP if CM suspends accused police officers, says Hardik Patel ','https://www.youtube.com/watch?v=dLKvtIZyhcc','http://i.ytimg.com/vi/dLKvtIZyhcc/default.jpg','PC: Will support BJP if CM suspends accused police officers, says Hardik Patel ','normal',1,'2015-09-25 14:34:18',NULL,'youtube','dLKvtIZyhcc'),(32,9,58,'GhoshanaPatra: Neither Chirag nor me are CM candidate in Bihar, says Ram Vilas Paswan ','https://www.youtube.com/watch?v=qf0CReQ-wLg','http://i.ytimg.com/vi/qf0CReQ-wLg/default.jpg','GhoshanaPatra: Neither Chirag nor me are CM candidate in Bihar, says Ram Vilas Paswan ','normal',1,'2015-09-25 14:36:22',NULL,'youtube','qf0CReQ-wLg'),(33,9,60,'News24 Bihar Conclave: Ram Vilas Paswan ','https://www.youtube.com/watch?v=DWJ8M5irJSE','http://i.ytimg.com/vi/DWJ8M5irJSE/default.jpg','News24 Bihar Conclave: Ram Vilas Paswan ','normal',1,'2015-09-25 14:37:18',NULL,'youtube','DWJ8M5irJSE'),(34,9,66,'Aap Ki Adalat - Ram Vilas Paswan, Chirag Paswan, Part 1 ','https://www.youtube.com/watch?v=iAmi3GcfvFc','http://i.ytimg.com/vi/iAmi3GcfvFc/default.jpg','Aap Ki Adalat - Ram Vilas Paswan, Chirag Paswan, Part 1 ','normal',1,'2015-09-25 14:37:54',NULL,'youtube','iAmi3GcfvFc'),(35,9,68,'Aap Ki Adalat - Ram Vilas Paswan, Chirag Paswan, Part 2','https://www.youtube.com/watch?v=NtR3Hw7lc3s','http://i.ytimg.com/vi/NtR3Hw7lc3s/default.jpg','Aap Ki Adalat - Ram Vilas Paswan, Chirag Paswan, Part 2','normal',1,'2015-09-25 14:38:26',NULL,'youtube','NtR3Hw7lc3s'),(36,9,70,'Aap Ki Adalat - Ram Vilas Paswan, Chirag Paswan, Part 3 ','https://www.youtube.com/watch?v=xT9n7XEUYdI','http://i.ytimg.com/vi/xT9n7XEUYdI/default.jpg','Aap Ki Adalat - Ram Vilas Paswan, Chirag Paswan, Part 3 ','normal',1,'2015-09-25 14:38:58',NULL,'youtube','xT9n7XEUYdI'),(37,9,62,'News24 Bihar Conclave: Ram Vilas Paswan','https://www.youtube.com/watch?v=DWJ8M5irJSE','http://i.ytimg.com/vi/DWJ8M5irJSE/default.jpg','News24 Bihar Conclave: Ram Vilas Paswan','normal',1,'2015-09-25 14:40:00',NULL,'youtube','DWJ8M5irJSE'),(38,9,70,'Srimanthudu Full Songs Jukebox || Mahesh Babu, Shruthi Hasan, Devi Sri Prasad ','https://www.youtube.com/watch?v=4kYfcwZCbiw','http://i.ytimg.com/vi/4kYfcwZCbiw/default.jpg','Srimanthudu Full Songs Jukebox || Mahesh Babu, Shruthi Hasan, Devi Sri Prasad ','normal',1,'2015-09-25 14:40:32',NULL,'youtube','4kYfcwZCbiw'),(39,9,70,'S/o Satyamurthy Telugu Movie || Full Songs Jukebox || Allu Arjun,Samantha,Nithya Menon ','https://www.youtube.com/watch?v=I_OedGjNByY','http://i.ytimg.com/vi/I_OedGjNByY/default.jpg','S/o Satyamurthy Telugu Movie || Full Songs Jukebox || Allu Arjun,Samantha,Nithya Menon ','normal',1,'2015-09-25 14:41:13',NULL,'youtube','I_OedGjNByY'),(40,9,64,'Manam Movie Songs Jukebox || Telugu Songs || Nageswara Rao,Nagarjuna,Naga Chaitanya,Samantha,Shreya ','https://www.youtube.com/watch?v=uCHGnpp_sGE','http://i.ytimg.com/vi/uCHGnpp_sGE/default.jpg','Manam Movie Songs Jukebox || Telugu Songs || Nageswara Rao,Nagarjuna,Naga Chaitanya,Samantha,Shreya ','normal',1,'2015-09-25 14:42:13',NULL,'youtube','uCHGnpp_sGE'),(41,9,70,'Dheere Dheere Se Meri Zindagi Video Song (OFFICIAL) Hrithik Roshan, Sonam Kapoor | Yo Yo Honey Singh','https://www.youtube.com/watch?v=nCD2hj6zJEc','http://i.ytimg.com/vi/nCD2hj6zJEc/default.jpg','Dheere Dheere Se Meri Zindagi Video Song (OFFICIAL) Hrithik Roshan, Sonam Kapoor | Yo Yo Honey Singh','normal',1,'2015-09-25 15:01:23',NULL,'youtube','nCD2hj6zJEc'),(42,9,70,'Chal Wahan Jaate Hain Full VIDEO Song - Arijit Singh | Tiger Shroff, Kriti Sanon | T-Series','https://www.youtube.com/watch?v=NerQs_SOwRo','http://i.ytimg.com/vi/NerQs_SOwRo/default.jpg','Chal Wahan Jaate Hain Full VIDEO Song - Arijit Singh | Tiger Shroff, Kriti Sanon | T-Series','normal',1,'2015-09-25 15:01:58',NULL,'youtube','NerQs_SOwRo'),(43,9,70,'Zindagi Aa Raha Hoon Main FULL VIDEO Song | Atif Aslam, Tiger Shroff | T-Series','https://www.youtube.com/watch?v=82eM7QRtoRo','http://i.ytimg.com/vi/82eM7QRtoRo/default.jpg','Zindagi Aa Raha Hoon Main FULL VIDEO Song | Atif Aslam, Tiger Shroff | T-Series','normal',1,'2015-09-25 15:02:26',NULL,'youtube','82eM7QRtoRo'),(44,9,64,'Sun Saathiya - Disney\'s ABCD 2 | Varun Dhawan - Shraddha Kapoor | Sachin - Jigar','https://www.youtube.com/watch?v=WyFNSkaoUqo','http://i.ytimg.com/vi/WyFNSkaoUqo/default.jpg','Sun Saathiya - Disney\'s ABCD 2 | Varun Dhawan - Shraddha Kapoor | Sachin - Jigar','normal',1,'2015-09-25 15:03:02',NULL,'youtube','WyFNSkaoUqo'),(45,9,70,'Teri Meri Kahaani Full Video | Gabbar Is Back | Akshay Kumar & Kareena Kapoor','https://www.youtube.com/watch?v=ZWAGn4yyRMM','http://i.ytimg.com/vi/ZWAGn4yyRMM/default.jpg','Teri Meri Kahaani Full Video | Gabbar Is Back | Akshay Kumar & Kareena Kapoor','normal',1,'2015-09-25 15:03:27',NULL,'youtube','ZWAGn4yyRMM'),(46,9,70,'Teri Meri Kahaani Full Video | Gabbar Is Back | Akshay Kumar & Kareena Kapoor','https://www.youtube.com/watch?v=ZWAGn4yyRMM&list=RDZWAGn4yyRMM#t=24','http://i.ytimg.com/vi/ZWAGn4yyRMM&list/default.jpg','Teri Meri Kahaani Full Video | Gabbar Is Back | Akshay Kumar & Kareena Kapoor','normal',1,'2015-09-25 15:03:52',NULL,'youtube','ZWAGn4yyRMM&list'),(47,9,70,'Aao Raja Full Video - Gabbar Is Back | Chitrangada Singh | Yo Yo Honey Singh & Neha Kakkar','https://www.youtube.com/watch?v=66VN2ZIWPnw','http://i.ytimg.com/vi/66VN2ZIWPnw/default.jpg','Aao Raja Full Video - Gabbar Is Back | Chitrangada Singh | Yo Yo Honey Singh & Neha Kakkar','normal',1,'2015-09-25 15:04:15',NULL,'youtube','66VN2ZIWPnw'),(48,9,70,'Coffee Peetey Peetey Full Video - Gabbar Is Back | Akshay Kumar & Shruti Haasan','https://www.youtube.com/watch?v=ZWAGn4yyRMM','http://i.ytimg.com/vi/ZWAGn4yyRMM/default.jpg','Coffee Peetey Peetey Full Video - Gabbar Is Back | Akshay Kumar & Shruti Haasan','normal',1,'2015-09-25 15:05:04',NULL,'youtube','ZWAGn4yyRMM'),(49,9,68,'Coffee Peetey Peetey Full Video - Gabbar Is Back | Akshay Kumar & Shruti Haasan','https://www.youtube.com/watch?v=uZheKCBWMlo','http://i.ytimg.com/vi/uZheKCBWMlo/default.jpg','Coffee Peetey Peetey Full Video - Gabbar Is Back | Akshay Kumar & Shruti Haasan','normal',1,'2015-09-25 15:05:31',NULL,'youtube','uZheKCBWMlo'),(50,9,70,'Madamiyan | Full Video Song | Tevar','https://www.youtube.com/watch?v=gdmMCmbvWB4','http://i.ytimg.com/vi/gdmMCmbvWB4/default.jpg','Madamiyan | Full Video Song | Tevar','normal',1,'2015-09-25 15:06:00',NULL,'youtube','gdmMCmbvWB4');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

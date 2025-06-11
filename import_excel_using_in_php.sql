/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - import_excel_using_in_php
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`import_excel_using_in_php` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `import_excel_using_in_php`;

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(11) DEFAULT '0',
  `product_category` varchar(50) DEFAULT NULL,
  `product_model_no` varchar(255) DEFAULT NULL,
  `product_desc` text DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `add_by_user_id` int(11) DEFAULT NULL,
  `add_ip` varchar(15) DEFAULT NULL,
  `add_timezone` varchar(255) DEFAULT NULL,
  `added_from_module_id` int(11) DEFAULT 0,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(255) DEFAULT NULL,
  `update_by_user_id` int(11) DEFAULT NULL,
  `update_ip` varchar(15) DEFAULT NULL,
  `update_timezone` varchar(255) DEFAULT NULL,
  `update_from_module_id` int(11) DEFAULT 0,
  `subscriber_users_id` int(11) DEFAULT 0,
  `enabled` smallint(6) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`product_id`,`product_category`,`product_model_no`,`product_desc`,`add_date`,`add_by`,`add_by_user_id`,`add_ip`,`add_timezone`,`added_from_module_id`,`update_date`,`update_by`,`update_by_user_id`,`update_ip`,`update_timezone`,`update_from_module_id`,`subscriber_users_id`,`enabled`) values 
(1,'product_id1','product_category1','product_model_no1','product_desc1',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(2,'product_id2','product_category2','product_model_no2','product_desc2',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(3,'product_id3','product_category3','product_model_no3','product_desc3',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(4,'product_id4','product_category4','product_model_no4','product_desc4',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(5,'product_id5','product_category5','product_model_no5','product_desc5',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(6,'product_id6','product_category6','product_model_no6','product_desc6',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(7,'product_id1','product_category1','product_model_no1','product_desc1',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(8,'product_id2','product_category2','product_model_no2','product_desc2',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(9,'product_id3','product_category3','product_model_no3','product_desc3',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(10,'product_id4','product_category4','product_model_no4','product_desc4',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(11,'product_id5','product_category5','product_model_no5','product_desc5',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(12,'product_id6','product_category6','product_model_no6','product_desc6',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(13,'product_id1','product_category1','product_model_no1','product_desc1',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(14,'product_id2','product_category2','product_model_no2','product_desc2',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(15,'product_id3','product_category3','product_model_no3','product_desc3',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(16,'product_id4','product_category4','product_model_no4','product_desc4',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(17,'product_id5','product_category5','product_model_no5','product_desc5',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(18,'product_id6','product_category6','product_model_no6','product_desc6',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(19,'product_id1','product_category1','product_model_no1','product_desc1',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(20,'product_id2','product_category2','product_model_no2','product_desc2',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(21,'product_id3','product_category3','product_model_no3','product_desc3',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(22,'product_id4','product_category4','product_model_no4','product_desc4',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(23,'product_id5','product_category5','product_model_no5','product_desc5',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1),
(24,'product_id6','product_category6','product_model_no6','product_desc6',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,0,0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

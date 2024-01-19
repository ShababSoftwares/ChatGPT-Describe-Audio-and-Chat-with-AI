/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 10.4.22-MariaDB : Database - chatgtp_audio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `chat_history` */

DROP TABLE IF EXISTS `chat_history`;

CREATE TABLE `chat_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_msg` longtext DEFAULT NULL,
  `ai_msg` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `chat_history` */

insert  into `chat_history`(`id`,`user_id`,`user_msg`,`ai_msg`,`created_at`,`updated_at`) values (1,1,'Where do you live','As an AI assistant, I don\'t have a physical presence or location. I exist in digital form to assist users like you through online platforms.','2023-11-06 23:32:57','2023-11-06 23:32:59');
insert  into `chat_history`(`id`,`user_id`,`user_msg`,`ai_msg`,`created_at`,`updated_at`) values (2,1,'do you know me?','As an AI assistant, I don\'t have access to personal information unless shared with me during our conversation. I can only provide general information and assist with your queries.','2023-11-06 23:35:28','2023-11-06 23:35:29');
insert  into `chat_history`(`id`,`user_id`,`user_msg`,`ai_msg`,`created_at`,`updated_at`) values (3,1,'yes, My name is John.','Nice to meet you, John! How can I assist you today?','2023-11-06 23:36:58','2023-11-06 23:37:00');

/*Table structure for table `describe_audio` */

DROP TABLE IF EXISTS `describe_audio`;

CREATE TABLE `describe_audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_msg` longtext DEFAULT NULL,
  `ai_msg` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

/*Data for the table `describe_audio` */

insert  into `describe_audio`(`id`,`file_id`,`user_id`,`user_msg`,`ai_msg`,`created_at`,`updated_at`) values (40,1,1,'give me text from this audio',NULL,'2024-01-19 20:03:20','2024-01-19 20:03:20');
insert  into `describe_audio`(`id`,`file_id`,`user_id`,`user_msg`,`ai_msg`,`created_at`,`updated_at`) values (41,1,1,'give me text from this audio.',NULL,'2024-01-19 20:03:45','2024-01-19 20:03:45');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (2,'2014_10_12_100000_create_password_resets_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (3,'2019_08_19_000000_create_failed_jobs_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `uploaded_files` */

DROP TABLE IF EXISTS `uploaded_files`;

CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `transcript` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `uploaded_files` */

insert  into `uploaded_files`(`id`,`file_name`,`file_path`,`transcript`,`created_at`,`updated_at`) values (1,'voice_demo1.mp3','uploads/translate/voice_demo1.mp3','Welcome to Shabab Softwares, this is the software company. You can request for free Qoutation prices.','2024-01-19 20:01:51','2024-01-19 20:01:51');
insert  into `uploaded_files`(`id`,`file_name`,`file_path`,`transcript`,`created_at`,`updated_at`) values (2,'voice_demo2.wav','uploads/translate/voice_demo2.wav','Hello World!','2024-01-19 20:01:51','2024-01-19 20:01:51');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'chatgpt','chatgpt@test.com',NULL,'$2y$10$2o10br1zurKqBvnr9nquS.t6tXmLVBgiNx06bCClLimT/rSiVdg2q',NULL,'2023-11-06 15:54:44','2023-11-06 15:54:44');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

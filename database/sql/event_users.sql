DROP TABLE event_users;

CREATE TABLE `event_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `remark` varchar(255),
  `status` varchar(255) NOT NULL,
  `attendance` varchar(255) NOT NULL,
  `amount` int DEFAULT NULL,
  `amount_remark` varchar(255) ,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
) ;
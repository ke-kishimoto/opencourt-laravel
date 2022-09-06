DROP TABLE inquiries;

CREATE TABLE `inquiries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int ,
  `title` varchar(255),
  `content` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
) ;
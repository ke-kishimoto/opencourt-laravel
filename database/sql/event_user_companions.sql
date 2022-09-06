DROP TABLE event_user_companions;

CREATE TABLE `event_user_companions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `event_user_id` int,
  `user_category_id` int NOT NULL,
  `gender` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `attendance` varchar(255),
  `amount` int ,
  `amount_remark` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp,
  PRIMARY KEY (`id`)
) ;
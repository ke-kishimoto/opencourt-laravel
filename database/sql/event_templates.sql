DROP TABLE event_templates;

CREATE TABLE `event_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_title` varchar(255) NOT NULL,
  `place` varchar(255)  NOT NULL,
  `limit_number` int NOT NULL,
  `description` text,
  `price1` int ,
  `price2` int ,
  `price3` int ,
  `price4` int ,
  `price5` int ,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
) ;
drop table news;

CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
) ;
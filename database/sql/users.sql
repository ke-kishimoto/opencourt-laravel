DROP TABLE users;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_level` varchar(255) NOT NULL,
  `user_name` varchar(255),
  `email` varchar(255) ,
  `name` varchar(255) NOT NULL,
  `tel` varchar(255) ,
  `password` varchar(255) ,
  `gender` varchar(255) ,
  `user_category_id` int ,
  `status` varchar(255),
  `description` text ,
  `image_path` varchar(255),
  `line_id` varchar(255) ,
  `line_access_token` varchar(255) ,
  `line_refresh_token` varchar(255) ,
  `remember_token` varchar(255) ,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
);

INSERT INTO `users` (`id`,`role_level`,`email`,`name`,`tel`,`password`,`gender`,`user_category_id`,`status`,`description`,`line_id`,`line_access_token`,`line_refresh_token`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) 
VALUES (1,1,'super@test.com','super',NULL,'$2y$10$SspyQi1wP3yS/PeKXZObj.voxzk8esrmOFZUZTQp1Pig6HYbaJ/La','men',1,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

INSERT INTO `users` (`id`,`role_level`,`email`,`name`,`tel`,`password`,`gender`,`user_category_id`,`status`,`description`,`line_id`,`line_access_token`,`line_refresh_token`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) 
VALUES (2,1,'nebinosuk@gmail.com','kishimoto keisuke',NULL,'$2y$10$mNW3afKscLQkvTsVWV.z8OztTYmCvLmgeNLyZcubkhQthWaSmhUxm','men',1,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

INSERT INTO `users` (`id`,`role_level`,`email`,`name`,`tel`,`password`,`gender`,`user_category_id`,`status`,`description`,`line_id`,`line_access_token`,`line_refresh_token`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) 
VALUES (3,1,'k.kishimoto@tc-tech.co.jp','tc-kishimoto',NULL,'$2y$10$fjw4kzXfbNyBV9MVtAIJE.ZIp8SI57TycIWNGpmekS7uwAup2lwku','men',1,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

INSERT INTO `users` (`id`,`role_level`,`email`,`name`,`tel`,`password`,`gender`,`user_category_id`,`status`,`description`,`line_id`,`line_access_token`,`line_refresh_token`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) 
VALUES (4,2,'admin@admin.com','admin',NULL,'$2y$10$U4b9CKTjp1iSTUmWNNCPwem/C4bnPjAj9bL3r8BMqx4mVuaQFjak6','men',1,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

INSERT INTO `users` (`id`,`role_level`,`email`,`name`,`tel`,`password`,`gender`,`user_category_id`,`status`,`description`,`line_id`,`line_access_token`,`line_refresh_token`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) 
VALUES (5,3,'test1@test.com','test1',NULL,'$2y$10$GAdL9AVFp4xDWKTXaZDN8eN12Ed3RCsTXb6536s.13oNH5K5q4ABe','men',1,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

INSERT INTO `users` (`id`,`role_level`,`email`,`name`,`tel`,`password`,`gender`,`user_category_id`,`status`,`description`,`line_id`,`line_access_token`,`line_refresh_token`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) 
VALUES (6,3,'test2@test.com','test2',NULL,'$2y$10$Fj1BpAXK8ICCsijUXIsxK.6YVwXD/4dUFZkJpH0wgslqUDsoy6wRq','men',1,'active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
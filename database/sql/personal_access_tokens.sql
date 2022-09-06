DROP TABLE personal_access_tokens;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255)  NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255)  NOT NULL,
  `token` varchar(64)  NOT NULL,
  `abilities` text ,
  `last_used_at` timestamp ,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ;
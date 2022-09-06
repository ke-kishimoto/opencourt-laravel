DROP TABLE user_categories;

CREATE TABLE `user_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
);

insert into user_categories (category_name, created_at) 
values ('社会人', now());

insert into user_categories (category_name, created_at) 
values ('大学生', now());

insert into user_categories (category_name, created_at) 
values ('高校生', now());
drop table events;

CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_title` varchar(255) ,
  `event_date` date NOT NULL,
  `start_time` varchar(255) ,
  `end_time` varchar(255),
  `place` varchar(255)  NOT NULL,
  `limit_number` int ,
  `description` varchar(255) ,
  `expenses` int ,
  `amount` int ,
  `number_of_user` int ,
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
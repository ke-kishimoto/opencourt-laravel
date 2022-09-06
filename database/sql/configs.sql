drop table configs;

create table configs (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `line_notify_flag` varchar(10),
  `waiting_status_auto_update_flag` varchar(10),
  `participant_border_number` int,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp ,
  PRIMARY KEY (`id`)
);
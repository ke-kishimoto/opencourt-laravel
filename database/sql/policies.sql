drop table policies;

create table policies (
  id serial primary key,
  policy_type varchar(255),
  content text,
  `created_at` timestamp ,
  `updated_at` timestamp ,
  `deleted_at` timestamp 
);
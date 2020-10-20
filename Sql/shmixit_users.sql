create table users
(
    user_id int(10) auto_increment
        primary key,
    name    varchar(100)            null,
    avatar  varchar(255) default '' not null,
    constraint users_name_uindex
        unique (name)
);
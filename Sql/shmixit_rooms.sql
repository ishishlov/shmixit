create table rooms
(
    room_id       int(10) auto_increment
        primary key,
    status        tinyint      default 0  not null,
    name          varchar(100) default '' not null,
    admin_user_id int                     not null,
    date_create   datetime                null
);
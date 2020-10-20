create table room_users
(
    id      int(10) auto_increment
        primary key,
    room_id int(10) not null,
    user_id int(10) not null,
    constraint room_users
        unique (room_id, user_id)
);
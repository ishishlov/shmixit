create table games
(
    game_id        int auto_increment
        primary key,
    room_id        int      not null,
    date_start     datetime null,
    date_end       datetime null,
    status         smallint not null,
    winner_user_id int      null
)
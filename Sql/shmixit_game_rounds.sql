create table game_rounds
(
    game_round_id          int(10) auto_increment
        primary key,
    round                  int(10)      not null,
    game_id                int          not null,
    date_start             datetime     not null,
    date_of_word_selection datetime     null,
    date_finish            datetime     null,
    word                   varchar(150) null,
    status                 smallint     not null
);
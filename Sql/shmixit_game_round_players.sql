create table game_round_players
(
    game_round_player_id          int(10) auto_increment
        primary key,
    round                  int(10)      not null,
    game_id                int          not null,
    player_id              int          not null,
    cards                  text         null,
    score                  int          not null
);
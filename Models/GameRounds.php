<?php

namespace Models;

use Domain\CardPlayers;
use Domain\Game;
use Domain\ScorePlayers;
use PDO;

class GameRounds extends Main {

    private const TABLE_NAME = 'game_rounds';
    private const ID_FIELD_NAME = 'game_round_id';
    private const FIRST_ROUND = 1;

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function save(Game $game, CardPlayers $playersCards, ScorePlayers $scorePlayers)
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (round, game_id,
            date_start, date_of_word_selection, date_finish, word, status, card_players, score_players)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $res = $stmt->execute(
            [
                self::FIRST_ROUND,
                $game->getGameId(),
                $game->getDateStart(),
                null,
                null,
                null,
                $game->getStatus(), // ToDo пересмотреть
                $playersCards->toJson(),
                $scorePlayers->toJson()
            ]
        );
        $roomId = $res ? $this->_db->lastInsertId() : 0;
        $room->setRoomId($roomId);

        return $room;
    }

    public function getRooms(array $statuses): array
    {
        $sqlStatuses = implode(', ', $statuses);
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE status IN(' . $sqlStatuses . ') ORDER BY room_id DESC'
        );
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

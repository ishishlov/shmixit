<?php

namespace Models;

use Domain\Game;

class Games extends Main {

    private const TABLE_NAME = 'games';
    private const ID_FIELD_NAME = 'game_id';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function save(Game $game): Game
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (room_id, date_start, status) VALUES (?, ?, ?)'
        );
        $res = $stmt->execute([$game->getRoom()->getRoomId(), $game->getDateStart(), $game->getStatus()]);
        $gameId = $res ? $this->_db->lastInsertId() : 0;
        $game->setGameId($gameId);

        return $game;
    }
}

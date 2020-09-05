<?php

namespace Models;

use Domain\Game;
use PDO;

class Games extends Main {

    private const TABLE_NAME = 'games';

    public function get(int $gameId): array
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE game_id = ?'
        );
        $sth->execute([$gameId]);

        return $sth->fetch(PDO::FETCH_ASSOC);
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

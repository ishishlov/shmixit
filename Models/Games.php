<?php

namespace Models;

use Domain\Game;
use Services\RoomContract;
use DateTimeImmutable;

class Games extends Main {

    private const TABLE_NAME = 'games';
    private const ID_FIELD_NAME = 'game_id';

    /** @var RoomContract  */
    private $roomService;

    public function __construct(RoomContract $roomService)
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
        $this->roomService = $roomService;
    }

    public function getById(int $gameId): Game
    {
        $gameModel = parent::get($gameId);
        $room = $this->roomService->getRoom($gameModel['room_id']);

        return new Game(
            $room,
            $gameModel['status'],
            $gameModel['move_order'],
            $gameModel['date_start'] ? new DateTimeImmutable($gameModel['date_start']) : null,
            $gameModel['date_end'] ? new DateTimeImmutable($gameModel['date_end']) : null,
            $gameId
        );
    }

    public function save(Game $game): Game
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (room_id, date_start, status, move_order) VALUES (?, ?, ?, ?)'
        );
        $res = $stmt->execute([
            $game->getRoom()->getRoomId(),
            $game->getDateStart()->format('Y-m-d H:i:s'),
            $game->getStatus(),
            $game->getMoveOrder()
        ]);
        $gameId = $res ? $this->_db->lastInsertId() : 0;
        $game->setGameId($gameId);

        return $game;
    }
}

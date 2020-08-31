<?php

namespace Models;

use Domain\User;
use PDO;

class RoomUsers extends Main {

    private const TABLE_NAME = 'room_users';

    public function get(int $roomId): array
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE room_id = ?'
        );
        $sth->execute([$roomId]);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(User $user, int $roomId): bool
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (room_id, user_id) VALUES (?, ?)'
        );

        return $stmt->execute([$roomId, $user->getUserId()]);
    }
}

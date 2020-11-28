<?php

namespace Models;

use Domain\User;

class RoomUsers extends Main {

    private const TABLE_NAME = 'room_users';
    private const ID_FIELD_NAME = 'room_id';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function save(User $user, int $roomId): bool
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (room_id, user_id) VALUES (?, ?)'
        );

        return $stmt->execute([$roomId, $user->getUserId()]);
    }

    public function delete(int $userId, int $roomId): bool
    {
        $stmt = $this->_db->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE user_id = ? AND room_id = ?'
        );

        return $stmt->execute([$userId, $roomId]);
    }
}

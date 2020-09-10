<?php

namespace Models;

use Domain\User;
use PDO;

class RoomUsers extends Main {

    private const TABLE_NAME = 'room_users';
    private const ID_FIELD_NAME = 'room_id';

    public function __construct()
    {
        $this->tableName = self::TABLE_NAME;
        $this->idFieldName = self::ID_FIELD_NAME;
        parent::__construct();
    }

    public function save(User $user, int $roomId): bool
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (room_id, user_id) VALUES (?, ?)'
        );

        return $stmt->execute([$roomId, $user->getUserId()]);
    }
}

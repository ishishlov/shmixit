<?php

namespace Models;

use Domain\Room as Domain;
use Domain\User;
use PDO;

class Room extends Main {

    private const TABLE_NAME = 'room';

    public function get(int $roomId): array
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE room_id = ?'
        );
        $sth->execute([$roomId]);

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function save(Domain $room): Domain
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (status, name, admin_user_id) VALUES (?, ?, ?)'
        );
        $res = $stmt->execute([$room->getStatus(), $room->getName(), $room->getAdminUser()->getUserId()]);
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

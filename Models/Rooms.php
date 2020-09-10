<?php

namespace Models;

use Domain\Room as Domain;
use PDO;

class Rooms extends Main {

    private const TABLE_NAME = 'rooms';
    private const ID_FIELD_NAME = 'room_id';

    public function __construct()
    {
        $this->tableName = self::TABLE_NAME;
        $this->idFieldName = self::ID_FIELD_NAME;
        parent::__construct();
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

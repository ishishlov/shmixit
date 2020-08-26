<?php

namespace Models;

use PDO;

class Room extends Main {

    private const TABLE_NAME = 'room';
    private const STATUS_CREATED = 1;
    private const STATUS_ACTIVE = 2;
    private const STATUS_FINISHED = 3;

    public function getRooms(?array $statuses = [self::STATUS_CREATED]): array
    {
        $sqlStatuses = implode(', ', $statuses);
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE status IN(' . $sqlStatuses . ')'
        );
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

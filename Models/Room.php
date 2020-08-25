<?php

namespace Models;

use PDO;

class Room extends Main {

    private const TABLE_NAME = 'room';

    public function getRooms(): array
    {
        $sth = $this->_db->prepare('SELECT * FROM ' . self::TABLE_NAME);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

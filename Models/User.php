<?php

namespace Models;

use PDO;

class User extends Main {

    private const TABLE_NAME = 'users';

    public function get(int $id)
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = ?'
        );
        $sth->execute([$id]);

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIds(array $ids): array
    {
        if (!$ids) {
            return [];
        }

        $sqlIds = implode(',', $ids);
        $sth = $this->_db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id IN(' . $sqlIds . ')'
        );

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return \Domain\User[]
     */
    public function getAll(): array
    {
        $sth = $this->_db->query('SELECT * FROM ' . self::TABLE_NAME);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(array $id): bool
    {
        $stmt = $this->_db->prepare('DELETE FROM ' . self::TABLE_NAME. ' WHERE `user_id` = ?');

        return $stmt->execute([$id]);
    }
}

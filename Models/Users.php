<?php

namespace Models;

use Domain\User;
use Domain\User as Domain;
use Domain\Users as UsersList;
use PDO;

class Users extends Main implements UsersModels {

    private const TABLE_NAME = 'users';
    private const ID_FIELD_NAME = 'user_id';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function getByIds(array $ids): UsersList
    {
        if (!$ids) {
            return UsersList::createEmpty();
        }

        $sqlIds = implode(',', $ids);
        $sth = $this->_db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id IN(' . $sqlIds . ')'
        );
        $users = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($users);
    }

    /**
     * @return User[]
     */
    public function getAll(): UsersList
    {
        $sth = $this->_db->query('SELECT * FROM ' . self::TABLE_NAME);
        $users = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($users);
    }

    public function delete(array $id): bool
    {
        $stmt = $this->_db->prepare('DELETE FROM ' . self::TABLE_NAME. ' WHERE `user_id` = ?');

        return $stmt->execute([$id]);
    }

    public function save(User $user): void
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (name, avatar) VALUES (?, ?)'
        );

        $stmt->execute([$user->getName(), $user->getAvatar()]);
        $user->setUserId((int) $this->_db->lastInsertId());
    }

    public function isNameExist(string $name): bool
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE name = ?'
        );
        $sth->execute([$name]);

        return (bool) $sth->rowCount();
    }

    /**
     * @param array $data
     * @return Domain[]
     */
    private function map(array $data): UsersList
    {
        $users = [];
        foreach ($data as $user) {
            $users[] = new Domain($user['user_id'], $user['name'], $user['avatar']);
        }

        return UsersList::create($users);
    }
}

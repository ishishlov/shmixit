<?php

namespace Services;

use Models\User as Model;
use Domain\User as Domain;

class User
{
    public function get(?int $userId): Domain
    {
        if(!$userId) {
            return new Domain();
        }

        $user = (new Model())->get($userId);
        if (!$user) {
            return new Domain();
        }

        return new Domain($user['user_id'], $user['name'], $user['avatar']);
    }

    /**
     * @param array|null $userIds
     * @return Domain[]
     */
    public function getByIds(?array $userIds): array
    {
        if(!$userIds) {
            return [];
        }
        $users = (new Model())->getByIds($userIds);

        return $this->map($users);
    }

    /**
     * @return Domain[]
     */
    public function getAll(): array
    {
        $users = (new Model())->getAll();

        return $this->map($users);
    }

    /**
     * @param array $result
     * @return Domain[]
     */
    private function map(array $result): array
    {
        $users = [];
        foreach ($result as $user) {
            $users[] = new Domain($user['user_id'], $user['name'], $user['avatar']);
        }

        return $users;
    }
}

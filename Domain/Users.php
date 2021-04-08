<?php

namespace Domain;

class Users
{
    /** @var User[] */
    private $users;

    private function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @param User[] $users
     * @return Users
     */
    public static function create(array $users)
    {
        return new self($users);
    }

    public static function createEmpty()
    {
        return new self([]);
    }

    public function add(User $user): void
    {
        $this->users[] = $user;
    }

    public function toArray()
    {
        return $this->users;
    }

    public function isExists(User $user): bool
    {
        foreach ($this->users as $currentUser) {
            if ($currentUser->isEqual($user->getUserId())) {
                return true;
            }
        }

        return false;
    }

    public function getRenderData(): array
    {
        $data = [];
        foreach ($this->users as $user) {
            $userId = $user->getUserId();
            $data[$userId] = [
                'id' => $userId,
                'avatar' => $user->getAvatar(),
                'name' => $user->getName(),
            ];
        }

        return $data;
    }

    public function getUserIds(): array
    {
        return array_map(
            static function(User $user) {
                return $user->getUserId();
            },
            $this->users
        );
    }

    public function getByUserId(int $userId): ?User
    {
        foreach ($this->users as $user) {
            if ($user->isEqual($userId)) {
                return $user;
            }
        }

        return null;
    }
}

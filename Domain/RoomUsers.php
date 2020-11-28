<?php

namespace Domain;

class RoomUsers
{
    private $roomId;
    private $users;

    /**
     * @param int|null $roomId
     * @param User[]|null $users
     */
    public function __construct(?int $roomId = null, ?array $users = [])
    {
        $this->roomId = $roomId;
        $this->users = $users;
    }

    /**
     * @return int|null
     */
    public function getRoomId(): ?int
    {
        return $this->roomId;
    }

    /**
     * @return User[]|null
     */
    public function getUsers(): ?array
    {
        return $this->users;
    }

    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    public function userInRoom(User $user): bool
    {
        foreach ($this->users as $userInRoom) {
            if ($userInRoom->isEqual($user->getUserId())) {
                return true;
            }
        }

        return false;
    }

    public function getCount(): int
    {
        return count($this->users);
    }

    public function getMessages(): array
    {
        $messages = [];
        foreach ($this->users as $user) {
            $messages[] = sprintf('%s присоединился к игре', $user->getName());
        }

        return $messages;
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
}

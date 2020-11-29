<?php

namespace Domain;

class RoomUsers
{
    private $roomId;
    private $users;

    /**
     * @param int $roomId
     * @param Users $users
     */
    public function __construct(int $roomId, Users $users)
    {
        $this->roomId = $roomId;
        $this->users = $users;
    }

    /**
     * @return int
     */
    public function getRoomId(): int
    {
        return $this->roomId;
    }

    /**
     * @return User[]|null
     */
    public function getUsersRenderData(): ?array
    {
        return $this->users->getRenderData();
    }

    public function addUser(User $user): void
    {
        $this->users->add($user);
    }

    public function userInRoom(User $user): bool
    {
        return $this->users->isExists($user);
    }

    public function getMessages(): array
    {
        $messages = [];
        foreach ($this->users->toArray() as $user) {
            $messages[] = sprintf('%s присоединился к игре', $user->getName());
        }

        return $messages;
    }

    public function getUserIds(): array
    {
        return $this->users->getUserIds();
    }
}

<?php

namespace Domain;

class Room
{
    private $roomId;
    private $status;
    private $name;
    private $adminUser;
    private $statusName;

    public function __construct(?int $roomId = null, ?int $status = null, ?string $name = null, ?User $adminUser = null, ?string $statusName = '')
    {
        $this->roomId = $roomId;
        $this->status = $status;
        $this->name = $name;
        $this->adminUser = $adminUser;
        $this->statusName = $statusName;
    }

    /**
     * @param int|null $roomId
     */
    public function setRoomId(?int $roomId): void
    {
        $this->roomId = $roomId;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getRoomId(): ?int
    {
        return $this->roomId;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return User|null
     */
    public function getAdminUser(): ?User
    {
        return $this->adminUser;
    }

    /**
     * @return string|null
     */
    public function getStatusName(): ?string
    {
        return $this->statusName;
    }

    public function isAdmin(User $user): bool
    {
        return $user->getUserId() === $this->adminUser->getUserId();
    }
}

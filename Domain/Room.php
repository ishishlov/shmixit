<?php

namespace Domain;

class Room
{
    private $status;
    private $name;
    private $adminUser;
    private $statusName;
    private $dateCreate;
    private $roomId;

    public function __construct(int $status, string $name, User $adminUser, string $statusName, ?string $dateCreate = '', ?int $roomId = null)
    {
        $this->status = $status;
        $this->name = $name;
        $this->adminUser = $adminUser;
        $this->statusName = $statusName;
        $this->dateCreate = $dateCreate;
        $this->roomId = $roomId;
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

    /**
     * @return string|null
     */
    public function getDateCreate(): ?string
    {
        return $this->dateCreate;
    }

    public function isAdmin(int $userId): bool
    {
        return $userId === $this->adminUser->getUserId();
    }
}

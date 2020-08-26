<?php

namespace Domain;

class Room
{
    private $roomId;
    private $status;
    private $name;
    private $adminUser;

    public function __construct(?int $roomId = null, ?int $status = null, ?string $name = null, ?User $adminUser = null)
    {
        $this->roomId = $roomId;
        $this->status = $status;
        $this->name = $name;
        $this->adminUser = $adminUser;
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
}

<?php

namespace Domain;

class User
{
    private $userId;
    private $name;
    private $avatar;

    public function __construct(?int $userId = null, ?string $name = null, ?string $avatar = '')
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->avatar = $avatar;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name ?: 'Гость';
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function isGuest(): bool
    {
        return !(bool) $this->userId;
    }

    public function isEqual(User $user): bool
    {
        return $user->getUserId() === $this->userId;
    }
}

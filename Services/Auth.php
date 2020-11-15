<?php

namespace Services;

class Auth
{
    private const STORAGE_USER_KEY = 'shmixit_user_id';

    public function getUserId(): ?int
    {
        return $_COOKIE[self::STORAGE_USER_KEY] ?? null;
    }

    public function logIn(int $userId): void
    {
        setcookie(self::STORAGE_USER_KEY, $userId, time() + 3600, '/');
    }

    public function logOut(): void
    {
        setcookie(self::STORAGE_USER_KEY, '', time() - 3600, '/');
    }
}

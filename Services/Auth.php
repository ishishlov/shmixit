<?php

namespace Services;

class Auth
{
    public function getUserId(): ?int
    {
        return $_COOKIE['user_id'] ?? null;
    }
}

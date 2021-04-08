<?php

namespace Models;

use Domain\Users;

interface UsersModels
{
    public function getByIds(array $ids): Users;
}

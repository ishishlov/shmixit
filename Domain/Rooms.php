<?php

namespace Domain;

class Rooms
{
    /** @var Room[]  */
    private $rooms;

    public function __construct(array $rooms)
    {
        $this->rooms = $rooms;
    }

    public function get()
    {
        return $this->rooms;
    }

    public function isExists(): bool
    {
        return count($this->rooms) > 0;
    }
}

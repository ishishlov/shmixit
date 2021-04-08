<?php

namespace Services;

use Domain\Room;

interface RoomContract
{
    public function getRoom(int $roomId): Room;
}

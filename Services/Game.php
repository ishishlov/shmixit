<?php

namespace Services;

use Domain\GameStatuses;
use Models\Games as Model;
use Domain\Game as Domain;
use Domain\Room;

class Game
{
    private $gameModel;

    public function __construct()
    {
        $this->gameModel = new Model();
    }

    public function start(Room $room): Domain
    {
        $date = date('Y-m-d H:i:s');
        $game = new Domain(null, $room, GameStatuses::getActiveStatus(), $date);

        return $this->gameModel->save($game);
    }
}
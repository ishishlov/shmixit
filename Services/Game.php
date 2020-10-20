<?php

namespace Services;

use Domain\CardPlayers;
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

    public function create(Room $room): Domain
    {
        $date = date('Y-m-d H:i:s');
        $game = new Domain(null, $room, GameStatuses::getActiveStatus(), $date);

        return $this->gameModel->save($game);
    }

    /**
     * @param Domain $game
     * @param CardPlayers $playersCards
     * @return bool
     */
    public function start(Domain $game, CardPlayers $playersCards)
    {

        //ToDo сделать логику сохранения первого раунда
        return true;
    }

    public function getGame(): Domain
    {

    }
}

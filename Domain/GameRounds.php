<?php

namespace Domain;

class GameRounds
{
    private $gameRounds;

    /**
     * @param GameRound[] $gameRounds
     */
    public function __construct(array $gameRounds)
    {
        $this->gameRounds = $gameRounds;
    }
}
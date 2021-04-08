<?php

namespace Domain;

use http\Exception\RuntimeException;

class GameRoundPlayers
{
    /** @var GameRoundPlayer[] */
    private $gameRoundPlayers;

    private function __construct(array $gameRoundPlayers)
    {
        $this->gameRoundPlayers = $gameRoundPlayers;
    }

    public static function create(array $gameRoundPlayers): self
    {
        return new self($gameRoundPlayers);
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    public function getByRound(int $round): GameRoundPlayer
    {
        foreach ($this->gameRoundPlayers as $gameRoundPlayer) {
            if ($gameRoundPlayer->isEqualRound($round)) {
                return $gameRoundPlayer;
            }
        }

        throw new RuntimeException('Round not exists');
    }
}

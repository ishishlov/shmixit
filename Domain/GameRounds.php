<?php

namespace Domain;

class GameRounds
{
    private $gameRounds;

    /**
     * @param GameRound[] $gameRounds
     */
    private function __construct(array $gameRounds)
    {
        $this->gameRounds = $gameRounds;
    }

    public static function create(array $gameRounds): self
    {
        return new self($gameRounds);
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    public function isMyMove(): bool
    {

    }

    public function getStep(): int
    {

    }
}
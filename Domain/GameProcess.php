<?php

namespace Domain;

class GameProcess
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

    public function isMyMove(User $user): bool
    {
        $lastRound = $this->getLastRound();

        return $lastRound->isMyMove($user);
    }

    public function getStep(): int
    {
        return 1; // ToDo need to fix
    }

    public function getWord(): ?string
    {
        $lastRound = $this->getLastRound();

        return $lastRound->getWord();
    }

    public function getRound(): int
    {
        $lastRound = $this->getLastRound();

        return $lastRound->getRound();
    }

    public function getStatus(): int
    {
        $lastRound = $this->getLastRound();

        return $lastRound->getStatus();
    }

    private function getLastRound(): GameRound
    {
        return end($this->gameRounds);
    }
}

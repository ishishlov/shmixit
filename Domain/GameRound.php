<?php

namespace Domain;

use DateTimeInterface;

class GameRound
{
    private $gameRoundId;
    private $round;
    private $gameId;
    private $movePlayerId;
    private $dateStart;
    private $dateOfWordSelection;
    private $dateFinish;
    private $word;
    private $status;
    private $gameRoundPlayers;

    private function __construct(
        int $gameRoundId,
        int $round,
        int $gameId,
        int $movePlayerId,
        int $status,
        $gameRoundPlayers,
        DateTimeInterface $dateStart,
        ?DateTimeInterface $dateOfWordSelection,
        ?DateTimeInterface $dateFinish,
        ?string $word
    ) {
        $this->gameRoundId = $gameRoundId;
        $this->round = $round;
        $this->gameId = $gameId;
        $this->movePlayerId = $movePlayerId;
        $this->dateStart = $dateStart;
        $this->dateOfWordSelection = $dateOfWordSelection;
        $this->dateFinish = $dateFinish;
        $this->word = $word;
        $this->status = $status;
        $this->gameRoundPlayers = $gameRoundPlayers;
    }

    public static function create(
        int $gameRoundId,
        int $round,
        int $gameId,
        int $movePlayerId,
        int $status,
        $gameRoundPlayers,
        DateTimeInterface $dateStart,
        ?DateTimeInterface $dateOfWordSelection,
        ?DateTimeInterface $dateFinish,
        ?string $word
    ): self {
        return new self(
            $gameRoundId,
            $round,
            $gameId,
            $movePlayerId,
            $status,
            $gameRoundPlayers,
            $dateStart,
            $dateOfWordSelection,
            $dateFinish,
            $word
        );
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function getRound(): int
    {
        return $this->round;
    }

    public function getStatus(): int
    {
        return $this->round;
    }

    public function isMyMove(User $user): bool
    {
        return $user->isEqual($this->movePlayerId);
    }
}

<?php

namespace Domain;

use DateTimeInterface;

class GameRound
{
    private $gameRoundId;
    private $round;
    private $gameId;
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
            $status,
            $gameRoundPlayers,
            $dateStart,
            $dateOfWordSelection,
            $dateFinish,
            $word
        );
    }
}

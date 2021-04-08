<?php

namespace Domain;

class GameRoundPlayer
{
    private $gameRoundPlayerId;
    private $round;
    private $playerId;
    private $cards;
    private $score;

    private function __construct(
        int $gameRoundPlayerId,
        int $round,
        int $playerId,
        ?CardPlayers $cards,
        ?ScorePlayers $score
    ) {
        $this->gameRoundPlayerId = $gameRoundPlayerId;
        $this->round = $round;
        $this->playerId = $playerId;
        $this->cards = $cards;
        $this->score = $score;
    }

    public static function create(
        int $gameRoundPlayerId,
        int $round,
        int $playerId,
        ?CardPlayers $cards,
        ?ScorePlayers $score
    ): self {
        return new self(
            $gameRoundPlayerId,
            $round,
            $playerId,
            $cards,
            $score
        );
    }

    public function isEqualRound(int $round): bool
    {
        return $this->round === $round;
    }
}

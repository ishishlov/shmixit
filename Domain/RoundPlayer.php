<?php

namespace Domain;

class RoundPlayer
{
    private $playerRoundId;
    private $round;
    private $gameId;
    private $userId;
    private $cards;
    private $scores;

    private function __construct(?int $playerRoundId, int $round, int $gameId, int $userId, CardPlayer $playerCards, ScorePlayer $playerScores)
    {
        $this->playerRoundId = $playerRoundId;
        $this->round = $round;
        $this->gameId = $gameId;
        $this->userId = $userId;
        $this->cards = $playerCards;
        $this->scores = $playerScores;
    }

    public static function create(?int $playerRoundId, int $round, int $gameId, int $userId, CardPlayer $playerCards, ScorePlayer $playerScores): self
    {
        return new self($playerRoundId, $round, $gameId, $userId, $playerCards, $playerScores);
    }

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCards(): CardPlayer
    {
        return $this->cards;
    }

    public function getScores(): ScorePlayer
    {
        return $this->scores;
    }
}
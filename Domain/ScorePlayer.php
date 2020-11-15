<?php

namespace Domain;

class ScorePlayer
{
    /** @var int  */
    private $playerId;
    /** @var int  */
    private $score;

    /**
     * @param int $playerId
     * @param int $score
     */
    private function __construct(int $playerId, int $score)
    {
        $this->playerId = $playerId;
        $this->score = $score;
    }

    public static function fromArray(array $scorePlayer): ?self
    {
        if ($scorePlayer['playerId'] && $scorePlayer['score']) {
            return new self($scorePlayer['playerId'], $scorePlayer['score']);
        }

        return null;
    }

    /**
     * @param int $playerId
     * @param int $score
     * @return static
     */
    public static function create(int $playerId, int $score): self
    {
        return new self($playerId, $score);
    }
}

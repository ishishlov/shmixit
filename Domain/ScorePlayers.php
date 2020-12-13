<?php

namespace Domain;

class ScorePlayers
{
    private $scorePlayers;

    private const DEFAULT_SCORE = 0;

    /**
     * @param ScorePlayer[] $scorePlayers
     */
    private function __construct(array $scorePlayers)
    {
        $this->scorePlayers = $scorePlayers;
    }

    public function toJson(): string
    {
        return json_encode($this->scorePlayers);
    }

    public static function fromJson(string $scorePlayers): self
    {
        //ToDo обработать ошибку Json
        return new self(json_decode($scorePlayers, true));
    }

    /**
     * @param ScorePlayer[] $scorePlayers
     * @return self
     */
    public static function create(array $scorePlayers): self
    {
        return new self($scorePlayers);
    }

    /**
     * @param int[] $userIds
     * @return self
     */
    public static function createForStart(array $userIds): self
    {
        $scorePlayers = [];
        foreach ($userIds as $userId) {
            $scorePlayers = ScorePlayer::create($userId, self::DEFAULT_SCORE);
        }

        return self::create($scorePlayers);
    }

    public function getByUserId(int $userId): ScorePlayer
    {
        foreach ($this->scorePlayers as $playerScores) {
            if ($playerScores->isUserScores($userId)) {
                return $playerScores;
            }
        }

        return 'ERROR';// ToDo need to refactoring
    }
}

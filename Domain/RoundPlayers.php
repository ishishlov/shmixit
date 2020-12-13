<?php

namespace Domain;

class RoundPlayers
{
    private const FIRST_ROUND = 1;

    /** @var RoundPlayer[] */
    private $roundPlayers;

    private function __construct(array $roundPlayers)
    {
        $this->roundPlayers = $roundPlayers;
    }

    public static function create(array $roundPlayers): self
    {
        return new self($roundPlayers);
    }

    public static function createFromCardsAndScores(Game $game, RoomUsers $roomUsers, CardPlayers $cardPlayers, ScorePlayers $scorePlayers): self
    {
        $roundPlayers = [];
        foreach ($roomUsers->getUserIds() as $userId) {
            $playerCards = $cardPlayers->getByUserId($userId);
            $playerScores = $scorePlayers->getByUserId($userId);
            $roundPlayers[] = RoundPlayer::create(
                null,
                self::FIRST_ROUND,
                $game->getGameId(),
                $userId,
                $playerCards,
                $playerScores
            );
        }

        return new self($roundPlayers);
    }

    public function toArray(): array
    {
        return $this->roundPlayers;
    }
}

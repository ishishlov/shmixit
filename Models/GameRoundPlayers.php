<?php

namespace Models;

use Domain\RoundPlayers;
use PDO;

class GameRoundPlayers extends Main {

    private const TABLE_NAME = 'game_round_players';
    private const ID_FIELD_NAME = 'game_round_player_id';
    private const FIRST_ROUND = 1;

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function create(RoundPlayers $roundPlayers): bool
    {
        $data = [];
        foreach ($roundPlayers->toArray() as $roundPlayer) {
            $data[] = [
                'round' => self::FIRST_ROUND,
                'game_id' => $roundPlayer->getGameId(),
                'player_id' => $roundPlayer->getUserId(),
                'cards' => $roundPlayer->getCards()->toJson(),
                'score' => $roundPlayer->getScores()->getScore(), // ToDo need to refactoring, а то хрень какая-то
            ];
        }

        return $this->insert($data);
    }
}

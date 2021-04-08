<?php

namespace Models;

use Domain\CardPlayers;
use Domain\GameRoundPlayer;
use Domain\RoundPlayers;
use Domain\GameRoundPlayers as Domain;
use Domain\ScorePlayers;
use PDO;

class GameRoundPlayers extends Main {

    private const TABLE_NAME = 'game_round_players';
    private const ID_FIELD_NAME = 'game_round_player_id';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function getByGameId(int $gameId): Domain
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE game_id = ?'
        );
        $sth->execute([$gameId]);
        $models = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!$models) {
            return Domain::createEmpty();
        }

        $gameRoundPlayer = [];
        foreach ($models as $model) {
            $gameRoundPlayer[] = GameRoundPlayer::create(
                $model['game_round_player_id'],
                $model['round'],
                $model['player_id'],
                $model['cards'] ? CardPlayers::fromJson($model['cards']) : null,
                $model['score'] ? ScorePlayers::fromJson($model['score']) : null
            );
        }

        return Domain::create($gameRoundPlayer);
    }

    public function save(RoundPlayers $roundPlayers): bool
    {
        $data = [];
        foreach ($roundPlayers->toArray() as $roundPlayer) {
            $data[] = [
                'round' => $roundPlayer->getRound(),
                'game_id' => $roundPlayer->getGameId(),
                'player_id' => $roundPlayer->getUserId(),
                'cards' => $roundPlayer->getCards()->toJson(),
                'score' => $roundPlayer->getScores()->getScore(), // ToDo need to refactoring, а то хрень какая-то
            ];
        }

        return $this->insert($data);
    }
}

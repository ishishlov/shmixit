<?php

namespace Models;

use Domain\Game;
use Domain\GameRound;
use Domain\GameRounds as GameRoundsCollection;
use PDO;
use DateTimeImmutable;

class GameRounds extends Main {

    private const TABLE_NAME = 'game_rounds';
    private const ID_FIELD_NAME = 'game_round_id';
    private const FIRST_ROUND = 1;

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
    }

    public function getByGameId(int $gameId): GameRoundsCollection
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE game_id = ?'
        );
        $sth->execute([$gameId]);
        $models = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!$models) {
            return GameRoundsCollection::createEmpty();
        }

        $gameRoundPlayers = (new GameRoundPlayers())->getByGameId($models[0]['game_id']);
        $gameRounds = [];
        foreach ($models as $model) {
            $dateOfWordSelection = $model['date_of_word_selection']
                ? new DateTimeImmutable($model['date_of_word_selection'])
                : null;
            $dateFinish = $model['date_finish']
                ? new DateTimeImmutable($model['date_finish'])
                : null;

            $gameRounds[] = GameRound::create(
                $model['game_round_id'],
                $model['round'],
                $model['game_id'],
                $model['status'],
                $gameRoundPlayers->getByRound($model['round']),
                new DateTimeImmutable($model['date_start']),
                $dateOfWordSelection,
                $dateFinish,
                $model['word'] ?: null
            );
        }

        return GameRoundsCollection::create($gameRounds);
    }

    public function save(Game $game)
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (round, game_id,
            date_start, date_of_word_selection, date_finish, word, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $res = $stmt->execute(
            [
                self::FIRST_ROUND,
                $game->getGameId(),
                $game->getDateStart()->format('Y-m-d H:i:s'),
                null,
                null,
                null,
                $game->getStatus() // ToDo пересмотреть
            ]
        );

        return $res ? $this->_db->lastInsertId() : 0;
    }
}

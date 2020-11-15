<?php

namespace Services;

use Domain\GameStatuses;
use Domain\RoomUsers;
use Domain\ScorePlayers;
use Domain\Word;
use Models\GameRounds;
use Models\Games as Model;
use Domain\Game as Domain;
use Domain\Room;
use Domain\User;

class Game
{
    /** @var Model  */
    private $gameModel;
    /** @var GameRounds  */
    private $roundModel;
    /** @var CardService  */
    private $cardService;
    /** @var User  */
    private $user;

    public function __construct()
    {
        $this->gameModel = new Model();
        $this->roundModel = new GameRounds();
        $this->cardService = new CardService();
    }

    public function create(Room $room, RoomUsers $roomUsers): Domain
    {
        $date = date('Y-m-d H:i:s');
        $game = new Domain(null, $room, GameStatuses::getActiveStatus(), $date);
        $this->gameModel->save($game);

        $cardPlayers = $this->cardService->generatePlayersCards($roomUsers->getUserIds());
        $scorePlayers = ScorePlayers::createForStart($roomUsers->getUserIds());
        $this->roundModel->save($game, $cardPlayers, $scorePlayers);

        return $game;
    }

    public function play()
    {
        $gameId = (int) $_GET('game_id');
    }

    public function getGameProcess(User $user, int $gameId): Domain
    {

    }

    public function saveWord(Word $word, int $gameId): Word
    {
        $word->cutDangerousCharacters()
            ->checkLength();

        if (!$word->getErrors()) {
            // сохраняем в БД
        }

        return $word;
    }
}

<?php

namespace Services;

use Services\Room as RoomService;
use Domain\GameStatuses;
use Domain\RoomUsers;
use Domain\RoundPlayers;
use Domain\ScorePlayers;
use Domain\Word;
use Models\GameRoundPlayers;
use Models\GameRounds;
use Models\Games as Model;
use Domain\Game as Domain;
use Domain\Room;
use Domain\User;
use DateTimeImmutable;

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
        $this->gameModel = new Model(new RoomService());
        $this->roundModel = new GameRounds();
        $this->roundPlayerModel = new GameRoundPlayers();
        $this->cardService = new CardService();
    }

    public function create(Room $room, RoomUsers $roomUsers): Domain
    {
        $game = new Domain($room, GameStatuses::getActiveStatus(), new DateTimeImmutable());
        $this->gameModel->save($game);
        $this->roundModel->save($game);

        $cardPlayers = $this->cardService->generatePlayersCards($roomUsers->getUserIds());
        $scorePlayers = ScorePlayers::createForStart($roomUsers->getUserIds());
        $roundPlayers = RoundPlayers::createFromCardsAndScores($game, $roomUsers, $cardPlayers, $scorePlayers);
        $this->roundPlayerModel->save($roundPlayers);

        return $game;
    }

    public function play()
    {
        $gameId = (int) $_GET('game_id');
    }

    public function getGameProcess(User $user, int $gameId): Domain
    {
        $gameRounds = $this->roundModel->getByGameId($gameId);
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

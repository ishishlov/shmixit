<?php

namespace Services;

use Domain\GameProcess;
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
        $moveOrder = $roomUsers->createMoveOrder();
        $game = new Domain($room, GameStatuses::getActiveStatus(), $moveOrder, new DateTimeImmutable());
        $this->gameModel->save($game);
        $this->roundModel->save($game);

        $cardPlayers = $this->cardService->generatePlayersCards($roomUsers->getUserIds());
        $scorePlayers = ScorePlayers::createForStart($roomUsers->getUserIds());
        $roundPlayers = RoundPlayers::createFromCardsAndScores($game, $roomUsers, $cardPlayers, $scorePlayers);
        $this->roundPlayerModel->save($roundPlayers);

        return $game;
    }

    public function getGameProcess(User $user, int $gameId, bool $needToUpdate, ?array $errors = []): array
    {
        $gameProcess = $this->roundModel->getByGameId($gameId);

        return $this->getResponse($needToUpdate, $user, $errors, $gameProcess);
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

    public function getLastRoundStatus(int $gameId): int
    {
        return $this->roundModel->getLastRoundStatus($gameId);
    }

    public function getResponse(bool $needToUpdate, User $user, ?array $errors = [], ?GameProcess $gameProcess = null): array
    {
        $gameProcessData = [];
        if ($gameProcess) {
            $gameProcessData = [
                'myMove' => $gameProcess->isMyMove($user),
                'word' => $gameProcess->getWord(),
                'round' => $gameProcess->getRound(),
                'guest' => $user->isGuest(),
                'players' => [],
                'cards' => 0,
                'status' => $gameProcess->getStatus(),
            ];
        }

        return [
            'needToUpdate' => $needToUpdate,
            'gameProcess' => $gameProcessData,
            'errors' => $errors
        ];
    }
}

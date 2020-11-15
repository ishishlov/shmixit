<?php

namespace Services;

use Domain\ScorePlayers;
use Models\RoomUsers;
use Models\Rooms as Model;
use Domain\Room as Domain;
use Domain\RoomStatuses;
use Domain\User;
use Domain\RoomUsers as RoomUsersDomain;
use Services\User as UserService;
use Services\Game as GameService;
use Exception;

class Room
{
    private const DEFAULT_ROOM_ID = 0;
    private const DEFAULT_GAME_ID = 0;

    private $roomModel;
    private $roomUsersModel;
    private $userService;
    private $gameService;
    private $cardService;

    public function __construct()
    {
        $this->roomModel = new Model();
        $this->roomUsersModel = new RoomUsers();
        $this->userService = new UserService();
        $this->gameService = new GameService();
        $this->cardService = new CardService();
    }

    public function getAllRooms(): array
    {
        $rooms = $this->roomModel->getRooms(RoomStatuses::getAllStatuses());

        if (!$rooms) {
            return [];
        }

        $roomsWithAdditionalData = $this->getAdditionalData($rooms);

        return $this->map($roomsWithAdditionalData);
    }

    public function createRoom(User $user, ?string $roomName = ''): array
    {
        if ($user->isGuest()) {
            return $this->getAnswerForCreate('Необходимо авторизоваться');
        }

        $roomName = htmlentities(trim($roomName));
        $dateCreate = date('Y-m-d H:i:s');
        if (!$roomName) {
            $roomName = (string) $dateCreate;
        }

        try {
            $room = new Domain(
                null,
                RoomStatuses::getCreateStatus(),
                $roomName,
                $user,
                RoomStatuses::getName(RoomStatuses::getCreateStatus()),
                $dateCreate
            );
            $savedRoom = $this->roomModel->save($room);
            if ($savedRoom->getRoomId()) {
                $this->roomUsersModel->save($user, $savedRoom->getRoomId());
            }

            return $this->getAnswerForCreate('', $savedRoom->getRoomId());
        } catch (Exception $e) {
            return $this->getAnswerForCreate('Ошибка при сохранении. ' . $e->getMessage());
        }
    }

    public function connecting(User $user, int $roomId): array
    {
        if (!$roomId) {
            return $this->getAnswerForConnecting('Ошибка входа в игру. Не удалось подключиться');
        }

        $roomData = $this->roomModel->get($roomId);
        if (!$roomData) {
            return $this->getAnswerForConnecting('Игра не была создана');
        }

        if ($user->isGuest()) {
            return $this->getAnswerForConnecting('Необходимо авторизоваться');
        }

        $roomUsers = $this->getRoomUsers($roomId);
        if (!$roomUsers->userInRoom($user)) {
            $this->roomUsersModel->save($user, $roomId);
            $roomUsers->addUser($user);
        }

        return $this->getAnswerForConnecting('', $roomUsers->getCount(), $roomUsers->getUsers());
    }

    public function update(User $user, ?int $roomId): array
    {
        $roomUsers = $this->getRoomUsers($roomId);
        $room = $this->getRoom($roomId);
        $startGame = RoomStatuses::isActive($room->getStatus());

        return $this->getAnswerForConnecting('', $roomUsers->getCount(), $roomUsers->getUsers(), $startGame);
    }

    public function start(User $user, ?int $roomId): array
    {
        $room = $this->getRoom($roomId);
        if (!$room->isAdmin($user)) {
            return $this->getAnswerForStart('Лишь избранный наделен властью запускать игру. Зовите создателя');
        }

        $gameId = $this->startGame($room);

        return $this->getAnswerForStart('', $gameId);
    }

    private function getAdditionalData(array $rooms): array
    {
        $userIds = [];
        foreach ($rooms as $room) {
            $userIds[] = $room['admin_user_id'];
        }

        $users = $this->userService->getByIds($userIds);

        foreach ($rooms as &$room) {
            $room['status_name'] = RoomStatuses::getName($room['status']);
            foreach ($users as $user) {
                if ($user->getUserId() === (int) $room['admin_user_id']) {
                    $room['admin_user'] = $user;
                    break;
                }
            }

            if (empty($room['admin_user'])) {
                $room['admin_user'] = new User();
            }
        }

        return $rooms;
    }

    /**
     * @param array $data
     * @return Domain[]
     */
    private function map(array $data): array
    {
        $users = [];
        foreach ($data as $room) {
            $users[] = new Domain(
                $room['room_id'],
                $room['status'],
                $room['name'],
                $room['admin_user'],
                $room['status_name'],
                $room['date_create']
            );
        }

        return $users;
    }

    private function getRoom(int $roomId): Domain
    {
        $roomData = $this->roomModel->get($roomId);
        $roomDataWithAdditionalData = $this->getAdditionalData([$roomData]);
        $room = $this->map($roomDataWithAdditionalData);

        return $room[0];
    }

    private function getRoomUsers(int $roomId): RoomUsersDomain
    {
        $roomUsersFromDB = $this->roomUsersModel->get($roomId, true);
        $roomUserIds = [];
        foreach ($roomUsersFromDB as $roomUser) {
            $roomUserIds[] = (int) $roomUser['user_id'];
        }
        $usersInRoom = $this->userService->getByIds($roomUserIds);

        return new RoomUsersDomain($roomId, $usersInRoom);
    }

    private function startGame(Domain $room): int
    {
        $room->setStatus(RoomStatuses::getActiveStatus());
        $savedRoom = $this->roomModel->save($room);

        $roomUsers = $this->getRoomUsers($room->getRoomId());
        $game = $this->gameService->create($savedRoom, $roomUsers);

        //ToDo доделать логику
        return $game->getGameId();
    }

    private function getAnswerForCreate(string $error, ?int $roomId = self::DEFAULT_ROOM_ID): array
    {
        return [
            'error' => $error,
            'room_id' => $roomId
        ];
    }

    private function getAnswerForConnecting(string $error, ?int $countPlayers = 0, ?array $users = [], ?bool $startGame = false): array
    {
        return [
            'error' => $error,
            'count_players' => $countPlayers,
            'users' => $users,
            'start_game' => $startGame
        ];
    }

    private function getAnswerForStart(string $error, ?int $gameId = self::DEFAULT_GAME_ID): array
    {
        return [
            'error' => $error,
            'game_id' => $gameId
        ];
    }
}

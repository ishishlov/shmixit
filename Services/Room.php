<?php

namespace Services;

use Models\RoomUsers;
use Models\Room as Model;
use Domain\Room as Domain;
use Domain\RoomStatuses;
use Domain\User;
use Domain\RoomUsers as RoomUsersDomain;
use Services\User as UserService;
use Exception;

class Room
{
    private const DEFAULT_ROOM_ID = 0;

    private $model;
    private $roomUsersModel;
    private $userService;

    public function __construct()
    {
        $this->model = new Model();
        $this->roomUsersModel = new RoomUsers();
        $this->userService = new UserService();
    }

    public function getAllRooms(): array
    {
        $rooms = $this->model->getRooms(RoomStatuses::getAllStatuses());

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
        if (!$roomName) {
            return $this->getAnswerForCreate('Необходимо задать название для игры');
        }

        try {
            $roomId = $this->model->save($user, RoomStatuses::getCreateStatus(), $roomName);
            if ($roomId) {
                $this->roomUsersModel->save($user, $roomId);
            }

            return $this->getAnswerForCreate('', $roomId);
        } catch (Exception $e) {
            return $this->getAnswerForCreate('Ошибка при сохранении. ' . $e->getMessage());
        }
    }

    public function connecting(User $user, ?int $roomId): array
    {
        if (!$roomId) {
            return $this->getAnswerForConnecting('Ошибка входа в игру. Не удалось подключиться');
        }

        $roomData = $this->model->get($roomId);
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

        return $this->getAnswerForConnecting('', $roomUsers->getCount(), $roomUsers->getMessages());
    }

    public function update(User $user, ?int $roomId): array
    {
        $roomUsers = $this->getRoomUsers($roomId);
        $roomData = $this->model->get($roomId);
        $startGame = RoomStatuses::isActive($roomData['status']);

        return $this->getAnswerForConnecting('', $roomUsers->getCount(), $roomUsers->getMessages(), $startGame);
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
                $room['status_name']
            );
        }

        return $users;
    }

    private function getRoomUsers(int $roomId): RoomUsersDomain
    {
        $roomUsersFromDB = $this->roomUsersModel->get($roomId);
        $roomUserIds = [];
        foreach ($roomUsersFromDB as $roomUser) {
            $roomUserIds[] = (int) $roomUser['user_id'];
        }
        $usersInRoom = $this->userService->getByIds($roomUserIds);

        return new RoomUsersDomain($roomId, $usersInRoom);
    }

    private function getAnswerForCreate(string $error, ?int $roomId = self::DEFAULT_ROOM_ID): array
    {
        return [
            'error' => $error,
            'room_id' => $roomId
        ];
    }

    private function getAnswerForConnecting(string $error, ?int $countPlayers = 0, ?array $messages = [], ?bool $startGame = false): array
    {
        return [
            'error' => $error,
            'count_players' => $countPlayers,
            'messages' => $messages,
            'start_game' => $startGame
        ];
    }
}

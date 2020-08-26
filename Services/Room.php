<?php

namespace Services;

use Models\Room as Model;
use Domain\Room as Domain;
use Domain\RoomStatuses;

class Room
{
    public function getAllRooms(): array
    {
        $rooms = (new Model())->getRooms(RoomStatuses::getAllStatuses());

        if (!$rooms) {
            return [];
        }

        $roomsWithAdditionalData = $this->getAdditionalData($rooms);

        return $this->map($roomsWithAdditionalData);
    }

    private function getAdditionalData(array $rooms): array
    {
        $userIds = [];
        foreach ($rooms as $room) {
            $userIds[] = $room['admin_user_id'];
        }

        $users = (new User)->getByIds($userIds);

        foreach ($rooms as &$room) {
            $room['status_name'] = RoomStatuses::getName($room['status']);
            foreach ($users as $user) {
                if ($user->getUserId() === (int) $room['admin_user_id']) {
                    $room['admin_user'] = $user;
                    break;
                }
            }

            if (empty($room['admin_user'])) {
                $room['admin_user'] = new \Domain\User();
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
}

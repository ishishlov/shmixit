<?php

namespace Models;

use Domain\Room as Domain;
use Domain\Rooms as RoomCollection;
use Domain\RoomStatuses;
use PDO;

class Rooms extends Main {

    private const TABLE_NAME = 'rooms';
    private const ID_FIELD_NAME = 'room_id';

    /** @var null  */
    private $usersModel = null;

    public function __construct(UsersModels $usersModel)
    {
        parent::__construct(self::TABLE_NAME, self::ID_FIELD_NAME);
        $this->usersModel = $usersModel;
    }

    public function save(Domain $room): Domain
    {
        $stmt = $this->_db->prepare(
            'INSERT INTO ' . self::TABLE_NAME . ' (status, name, admin_user_id) VALUES (?, ?, ?)'
        );
        $res = $stmt->execute([$room->getStatus(), $room->getName(), $room->getAdminUser()->getUserId()]);
        $roomId = $res ? $this->_db->lastInsertId() : 0;
        $room->setRoomId($roomId);

        return $room;
    }

    /**
     * @param int[] $statuses
     * @return RoomCollection
     */
    public function getRooms(array $statuses): RoomCollection
    {
        $sqlStatuses = implode(', ', $statuses);
        $sth = $this->_db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE status IN(' . $sqlStatuses . ') ORDER BY room_id DESC'
        );

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $rooms = [];

        if ($result) {
            $adminUserIds = array_column($result, 'admin_user_id');
            $adminUsers = $this->usersModel->getByIds($adminUserIds);

            foreach ($result as $room) {
                $rooms[] = new Domain(
                    $room['status'],
                    $room['name'],
                    $adminUsers->getByUserId($room['admin_user_id']),
                    RoomStatuses::getName($room['status']),
                    $room['date_create'],
                    $room['room_id']);
            }
        }

        return new RoomCollection($rooms);
    }
}

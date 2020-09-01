<?php

namespace Domain;

class RoomStatuses
{
    private const STATUS_CREATED = 1;
    private const STATUS_ACTIVE = 2;
    private const STATUS_FINISHED = 3;

    private const STATUS_CREATED_NAME = 'Набор игроков';
    private const STATUS_ACTIVE_NAME = 'В процессе игры';
    private const STATUS_FINISHED_NAME = 'Окончена';

    private const STATUSES = [
        self::STATUS_CREATED => self::STATUS_CREATED_NAME,
        self::STATUS_ACTIVE => self::STATUS_ACTIVE_NAME,
        self::STATUS_FINISHED => self::STATUS_FINISHED_NAME,
    ];

    public static function getName(int $id): string
    {
        if (array_key_exists($id, self::STATUSES)) {

            return self::STATUSES[$id];
        }

        trigger_error('incorrect status ' . $id);
        return 'Ошибка';
    }

    public static function getAllStatuses(): array
    {
        return array_keys(self::STATUSES);
    }

    public static function getCreateStatus(): int
    {
        return self::STATUS_CREATED;
    }

    public static function getActiveStatus(): int
    {
        return self::STATUS_ACTIVE;
    }

    public static function getFinishedStatus(): int
    {
        return self::STATUS_FINISHED;
    }

    public static function isActive(int $status): int
    {
        return self::STATUS_ACTIVE === $status;
    }
}

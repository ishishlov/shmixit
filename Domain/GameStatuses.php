<?php

namespace Domain;

class GameStatuses
{
    private const STATUS_ACTIVE = 1;
    private const STATUS_FINISH = 2;

    private const STATUS_ACTIVE_NAME = 'В процессе игры';
    private const STATUS_FINISH_NAME = 'Игра окончена';

    private const STATUSES = [
        self::STATUS_ACTIVE => self::STATUS_ACTIVE_NAME,
        self::STATUS_FINISH => self::STATUS_FINISH_NAME,
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

    public static function getActiveStatus(): int
    {
        return self::STATUS_ACTIVE;
    }

    public static function getFinishStatus(): int
    {
        return self::STATUS_FINISH;
    }

    public static function isActive(int $status): int
    {
        return self::STATUS_ACTIVE === $status;
    }
}

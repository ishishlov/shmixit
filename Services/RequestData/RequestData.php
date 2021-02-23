<?php

namespace Services\RequestData;

class RequestData
{
    public const STRING = 'string';
    public const INT = 'int';

    public static function get(array $storage, string $key, ?string $type = self::STRING, ?array $settings = [])
    {
        $result = null;
        if (isset($storage[$key])) {
            $result = $storage[$key];

            if ($type === self::STRING) {
                $result = (string) $result;
            } elseif ($type === self::INT) {
                $result = (int) $result;
            }
        }

        return $result;
    }
}

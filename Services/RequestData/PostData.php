<?php

namespace Services\RequestData;

class PostData
{
    public static function get(string $key, ?string $type = RequestData::STRING, ?array $settings = [])
    {
        return RequestData::get($_POST, $key, $type, $settings);
    }
}

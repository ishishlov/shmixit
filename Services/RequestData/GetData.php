<?php

namespace Services\RequestData;

class GetData
{
    public static function get(string $key, ?string $type = RequestData::STRING, ?array $settings = [])
    {
        return RequestData::get($_GET, $key, $type, $settings);
    }
}

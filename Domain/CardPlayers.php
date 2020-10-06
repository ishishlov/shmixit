<?php

namespace Domain;

class CardPlayers
{
    private $cardPlayers = [];

    private function __construct($data)
    {
        foreach ($data as $cardPlayer) {
            $this->cardPlayers[] = CardPlayer::fromArray($cardPlayer);
        }
    }

    public function toJson(): string
    {
        return json_encode($this->cardPlayers);
    }

    public static function fromJson(string $cardPlayers): self
    {
        //ToDo обработать ошибку Json
        return new self(json_decode($cardPlayers, true));
    }
}
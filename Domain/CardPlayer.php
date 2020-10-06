<?php

namespace Domain;

class CardPlayer
{
    private $playerId;
    private $cards = [];

    private function __construct(int $playerId, array $cards)
    {
        $this->playerId = $playerId;
        foreach ($cards as $card) {
            $this->cards[] = Card::create($card['id'], $card['status']);
        }
    }

    public static function fromArray(array $cardPlayer): ?self
    {
        if ($cardPlayer['playerId'] && $cardPlayer['cards']) {
            return new self($cardPlayer['playerId'], $cardPlayer['cards']);
        }

        return null;
    }
}
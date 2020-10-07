<?php

namespace Domain;

class Card
{
    private const CARD_STATUS_ACTIVE = 1;
    private const CARD_STATUS_INACTIVE = 2;
    private const CARD_STATUS_OUT_OF_GAME = 3;

    private $id;
    private $status;
    private $extension;

    private function __construct(int $id, int $status, string $extension)
    {
        $this->id = $id;
        $this->status = $status;
        $this->extension = $extension;
    }

    public static function create(int $id, string $extension, int $status = self::CARD_STATUS_ACTIVE): self
    {
        return new self($id, $status, $extension);
    }

    public function inactive(): void
    {
        $this->status = self::CARD_STATUS_INACTIVE;
    }

    public function outOfGame(): void
    {
        $this->status = self::CARD_STATUS_OUT_OF_GAME;
    }
}
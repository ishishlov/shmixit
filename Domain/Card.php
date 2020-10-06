<?php

namespace Domain;

class Card
{
    private $id;
    private $status;

    private function __construct(int $id, int $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public static function create(int $id, int $status): self
    {
        return new self($id, $status);
    }
}
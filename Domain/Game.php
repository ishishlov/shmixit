<?php

namespace Domain;

use DateTimeInterface;

class Game
{
    private $gameId;
    private $room;
    private $status;
    private $dateStart;
    private $dateEnd;
    private $moveOrder;

    public function __construct(
        Room $room,
        int $status,
        string $moveOrder,
        DateTimeInterface $dateStart,
        ?DateTimeInterface $dateEnd = null,
        ?int $gameId = null
    ) {
        $this->gameId = $gameId;
        $this->room = $room;
        $this->status = $status;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->moveOrder = $moveOrder;
    }

    /**
     * @param int|null $gameId
     */
    public function setGameId(?int $gameId): void
    {
        $this->gameId = $gameId;
    }

    /**
     * @return int|null
     */
    public function getGameId(): ?int
    {
        return $this->gameId;
    }

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateStart(): DateTimeInterface
    {
        return $this->dateStart;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateEnd(): ?DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function getMoveOrder(): string
    {
        return $this->moveOrder;
    }
}

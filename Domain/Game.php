<?php

namespace Domain;

class Game
{
    private $gameId;
    private $room;
    private $status;
    private $dateStart;
    private $dateEnd;

    public function __construct(
        ?int $gameId,
        ?Room $room,
        ?int $status,
        ?string $dateStart,
        ?string $dateEnd = ''
    ) {
        $this->gameId = $gameId;
        $this->room = $room;
        $this->status = $status;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
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
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    /**
     * @return string|null
     */
    public function getDateEnd(): ?string
    {
        return $this->dateEnd;
    }
}

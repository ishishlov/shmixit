<?php

namespace Domain;

class CardPlayers
{
    private $cardPlayers;

    /**
     * @param CardPlayer[] $cardPlayers
     */
    private function __construct(array $cardPlayers)
    {
        $this->cardPlayers = $cardPlayers;
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

    /**
     * @param CardPlayer[] $cardPlayers
     * @return self
     */
    public static function create(array $cardPlayers): self
    {
        return new self($cardPlayers);
    }

    public function getByUserId(int $userId): CardPlayer
    {
        foreach ($this->cardPlayers as $playerCards) {
            if ($playerCards->isUserCards($userId)) {
                return $playerCards;
            }
        }

        return 'ERROR';// ToDo need to refactoring
    }

    public function suspendExtraCards(): void
    {
        foreach ($this->cardPlayers as $cardPlayer) {
            $cardPlayer->suspendExtraCards();
        }
    }

    public function takeNextCard(): void
    {

    }
}

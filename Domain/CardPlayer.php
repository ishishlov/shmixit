<?php

namespace Domain;

class CardPlayer
{
    private const COUNT_ACTIVE_PLAYER_CARDS = 6;

    /** @var int  */
    private $playerId;
    /** @var Card[]  */
    private $cards;

    /**
     * @param int $playerId
     * @param Card[] $cards
     */
    private function __construct(int $playerId, array $cards)
    {
        $this->playerId = $playerId;
        $this->cards = $cards;
    }

    public static function fromArray(array $cardPlayer): ?self
    {
        if ($cardPlayer['playerId'] && $cardPlayer['cards']) {
            return new self($cardPlayer['playerId'], $cardPlayer['cards']);
        }

        return null;
    }

    /**
     * @param int $playerId
     * @param Card[] $cards
     * @return static
     */
    public static function create(int $playerId, array $cards): self
    {
        return new self($playerId, $cards);
    }

    public function suspendExtraCards(): void
    {
        $counter = 1;
        foreach ($this->cards as $card) {
            if ($counter > self::COUNT_ACTIVE_PLAYER_CARDS) {
                $card->inactive();
            }
            $counter++;
        }
    }

    public function isUserCards(int $userId): bool
    {
        return $this->playerId === $userId;
    }

    public function toJson(): string
    {
        return json_encode($this->cards);
    }
}

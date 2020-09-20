<?php

namespace Services;

class CardService
{
    private const CARD_STATUS_ACTIVE = 1;
    private const CARD_STATUS_INACTIVE = 2;
    private const CARD_STATUS_OUT_OF_GAME = 3;
    private const COUNT_ACTIVE_PLAYER_CARDS = 6;

    public function generatePlayersCards(array $userIds): array
    {
        $allCardIds = $this->getAllCards();
        shuffle($allCards);
        $cardIds = $this->removeExtraCards($allCardIds, $userIds);

        $playersCards = $this->getPlayersCards($cardIds, $userIds);


        // Достать все карты, перемешать, равномерно распределить среди игроков
        // с правильными статусами
        return [
            0 => [
                'userId' => 1,
                'cards' => [
                    0 => [
                        'cardId' => 1,
                        'status' => self::CARD_STATUS_ACTIVE
                    ],
                    1 => [
                        'cardId' => 2,
                        'status' => self::CARD_STATUS_ACTIVE
                    ],
                    2 => [
                        'cardId' => 3,
                        'status' => self::CARD_STATUS_ACTIVE
                    ],
                    3 => [
                        'cardId' => 4,
                        'status' => self::CARD_STATUS_ACTIVE
                    ],
                    4 => [
                        'cardId' => 5,
                        'status' => self::CARD_STATUS_ACTIVE
                    ],
                    5 => [
                        'cardId' => 6,
                        'status' => self::CARD_STATUS_ACTIVE
                    ],
                    6 => [
                        'cardId' => 7,
                        'status' => self::CARD_STATUS_INACTIVE
                    ],
                    7 => [
                        'cardId' => 8,
                        'status' => self::CARD_STATUS_INACTIVE
                    ],
                    8 => [
                        'cardId' => 9,
                        'status' => self::CARD_STATUS_INACTIVE
                    ],
                ]
            ],
        ];
    }

    private function getAllCards(): array
    {
        //Todo Добавить проверку на корректное имя карты
        return [1,2,3,4,5,6,7,8,9,10];
    }

    private function removeExtraCards(array $cardIds, array $userIds): array
    {
        $remains = count($cardIds) % count($userIds);
        $countCardForGame = count($cardIds) - $remains;

        return array_splice($cardIds, 0, $countCardForGame);
    }

    private function getPlayersCards(array $cardIds, array $userIds): array
    {
        $cards = [];
        $playersCards = [];
        $countUsers = count($userIds);
        $countCards = count($cardIds);
        $totalCountPlayerCards = $countCards / $countUsers;
        $countPlayerCards = 0;

        foreach ($cardIds as $id => $cardId) {

            $status = self::CARD_STATUS_INACTIVE;
            if ($countPlayerCards < self::COUNT_ACTIVE_PLAYER_CARDS) {
                $status = self::CARD_STATUS_ACTIVE;
            }

            $playersCards[$id] = [
                'cardId' => $cardId,
                'status' => $status
            ];

            $countPlayerCards++;
        }

        return $playersCards;
    }
}
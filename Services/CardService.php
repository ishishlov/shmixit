<?php

namespace Services;

use Domain\Card;
use Domain\CardPlayer;
use Domain\CardPlayers;
use Models\Cards;

class CardService
{
    /** @var Cards  */
    private $model;

    public function __construct()
    {
        $this->model = new Cards();
    }

    public function generatePlayersCards(array $userIds): CardPlayers
    {
        $cards = $this->model->getAllCards();
        shuffle($cards);
        $allCards = $this->removeExtraCards($cards, $userIds);
        $playersCards = $this->getPlayersCards($allCards, $userIds);
        $playersCards->suspendExtraCards();

        return $playersCards;
    }

    private function removeExtraCards(array $cardIds, array $userIds): array
    {
        $remains = count($cardIds) % count($userIds);
        $countCardForGame = count($cardIds) - $remains;

        return array_splice($cardIds, 0, $countCardForGame);
    }

    /**
     * @param Card[] $cards
     * @param array $userIds
     * @return CardPlayers
     */
    private function getPlayersCards(array $cards, array $userIds): CardPlayers
    {
        $playersCards = [];
        $countUsers = count($userIds);
        $countCards = count($cards);
        $totalCountPlayerCards = $countCards / $countUsers;
        $cardChunks = array_chunk($cards, $totalCountPlayerCards);

        foreach ($cardChunks as $cardChunk) {
            $playersCards[] = CardPlayer::create(array_shift($userIds), $cardChunk);
        }

        return CardPlayers::create($playersCards);
    }
}
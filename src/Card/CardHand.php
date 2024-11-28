<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function addCardsArray($cards)
    {
        foreach ($cards as $card) {
            $this->add($card);
        }
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function getNumCards(): int
    {
        return count($this->hand);
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}

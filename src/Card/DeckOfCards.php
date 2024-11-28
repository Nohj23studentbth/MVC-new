<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;

class DeckOfCards
{
    private $deck = [];

    public function __construct()
    {
      
    }

    public function setupDeck(): void
    {
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->deck[] = new CardGraphic($rank, $suit);
            }
        }
    }

    public function setupDeckText(): void
    {
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->deck[] = new Card($rank, $suit);
            }
        }
    }

    public function draw($amount): array
    {
        $drawnCards = [];

        for ($i = $amount; 0 < $i; $i--) {
            $drawnCard = array_pop($this->deck);
            $drawnCards[] = $drawnCard;
        }
        return $drawnCards;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);

    }

    public function countCards(): int
    {
        return count($this->deck);
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}

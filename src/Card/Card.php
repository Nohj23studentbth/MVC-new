<?php

namespace App\Card;

class Card
{
    protected $rank;
    protected $suit;

    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    // Baserat på tärning, ser om det behövs
    public function getSuit()
    {
        return $this->suit;
    }

    public function getRank()
    {
        return $this->rank;
    }

    // Return as string
    public function getAsString(): string
    {
        return "{$this->rank} {$this->suit}";
    }
}

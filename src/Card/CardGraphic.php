<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $representation = [
        'Spades' => '♠',
        'Hearts' => '♥',
        'Diamonds' => '♦',
        'Clubs' => '♣',
    ];

    public function __construct($rank, $suit)
    {
        parent::__construct($rank, $suit);
    }

    public function getAsString(): string
    {
        $ranks = $this->getRank();
        $suits = $this->representation[$this->getSuit()];

        return "{$ranks} {$suits}";
    }

}

<?php

namespace App\Card;

class CardGraphic extends Card
{   
    private array $korten = [
        'Klöver' => '♣',
        'Spader' => '♠',
        'Ruter' => '♦',
        'Hjärter' => '♥'
    ];

    public function __construct(string $colour, string $rang, int $val)
    {
        parent::__construct($colour, $rang, $val);
    }

    public function getAsStr(): string
    {
        $colours = $this->korten[$this->getColour()];
        $rangs = $this->getRang();

        return "{$colours} {$rangs}";
    }

}

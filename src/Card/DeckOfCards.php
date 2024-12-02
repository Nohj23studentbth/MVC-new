<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{   
    private array $kortlek = [];

    public function __construct()
    {

    }

    public function setupDeck(): void
    {
        $colours = ['Klöver', 'Spader', 'Ruter', 'Hjärter'];
        $rangs = ['Ess', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Knekt', 'Dam', 'Kung'];

        foreach ($colours as $colour) {
            foreach ($rangs as $rang) {
                $val = $this->setVal($rang);
                $this->kortlek[] = new CardGraphic($colour, $rang, $val);
            }
        }
    }

    public function setupDeckText(): void
    {
        $rangs = ['Ess', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Knekt', 'Dam', 'Kung'];
        $colours = ['Klöver', 'Spader', 'Ruter', 'Hjärter'];

        foreach ($colours as $colour) {
            foreach ($rangs as $rang) {
                $val = $this->setVal($rang);
                $this->kortlek[] = new Card($colour, $rang, $val);
            }
        }
    }

    public function setVal(string $rang): int
    {
        if (is_numeric($rang)) {
            return (int)$rang;
        }

        if ($rang === 'Ess') {
            return 14;
        }

        if ($rang === 'Knekt') {
            return 11;
        }

        if ($rang === 'Dam') {
            return 12;
        }

        if ($rang === 'Kung') {
            return 13;
        }

        return 0;
    }

    public function draw(int $summa): array
    {
        $dragnaKort = [];

        for ($i = $summa; $i > 0 && !empty($this->kortlek); $i--) {
            $dragetKort = array_shift($this->kortlek);
            $dragnaKort[] = $dragetKort;
        }
        return $dragnaKort;
    }

    public function shuffle(): void
    {
        shuffle($this->kortlek);

    }

    public function countCards(): int
    {
        return count($this->kortlek);
    }

    public function getDeck(): array
    {
        return $this->kortlek;
    }

    public function getString(): array
    {
        $vals = [];
        foreach ($this->kortlek as $kort) {
            $vals[] = $kort->getAsStr();
        }
        return $vals;
    }
}

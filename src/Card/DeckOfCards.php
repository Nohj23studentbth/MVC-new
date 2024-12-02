<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    /**
     * @var array<Card|CardGraphic> $kortlek The collection of cards in the deck
     */
    private array $kortlek = [];

    public function __construct()
    {
        // Constructor logic (if any) can go here
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

        return match ($rang) {
            'Ess' => 14,
            'Knekt' => 11,
            'Dam' => 12,
            'Kung' => 13,
            default => 0,
        };
    }

    /**
     * @param int $summa Number of cards to draw
     * @return array<Card|CardGraphic> The drawn cards
     */
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

    /**
     * @return array<Card|CardGraphic> The deck of cards
     */
    public function getDeck(): array
    {
        return $this->kortlek;
    }

    /**
     * @return array<string> String representations of all cards in the deck
     */
    public function getString(): array
    {
        $vals = [];
        foreach ($this->kortlek as $kort) {
            $vals[] = $kort->getAsStr();
        }
        return $vals;
    }
}

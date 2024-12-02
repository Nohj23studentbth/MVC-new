<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var Card[] $hand The collection of Card objects in the hand
     */
    private array $hand = [];

    public function add(Card $kort): void
    {
        $this->hand[] = $kort;
    }

    /**
     * @param Card[] $korten An array of Card objects to add to the hand
     */
    public function addCardsArray(array $korten): void
    {
        foreach ($korten as $kort) {
            $this->add($kort);
        }
    }

    public function handValue(): int
    {
        $val = 0;
        foreach ($this->hand as $kort) {
            $val += $kort->getVal();
        }
        return $val;
    }

    /**
     * @return Card[] The collection of Card objects in the hand
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    public function getNumCards(): int
    {
        return count($this->hand);
    }

    /**
     * @return string[] Array of string representations of cards
     */
    public function getString(): array
    {
        $vals = [];
        foreach ($this->hand as $kort) {
            $vals[] = $kort->getAsStr();
        }
        return $vals;
    }

    public function ess(): int
    {
        $ess = 0;
        foreach ($this->hand as $kort) {
            if ($kort->getRang() === 'Ess') {
                $ess++;
            }
        }
        return $ess;
    }
}

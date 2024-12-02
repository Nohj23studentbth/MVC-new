<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{   
    private array $hand = []; // Renamed from $handen to $hand for consistency

    public function add(Card $kort): void
    {
        $this->hand[] = $kort; // Updated to use $hand
    }

    public function addCardsArray(array $korten): void
    {
        foreach ($korten as $kort) {
            $this->add($kort); // No change needed here
        }
    }

    public function handValue(): int
    {
        $val = 0;
        foreach ($this->hand as $kort) { // Updated to use $hand
            $val += $kort->getVal();
        }
        return (int)$val;
    }

    public function getHand(): array
    {
        return $this->hand; // Updated to use $hand
    }

    public function getNumCards(): int
    {
        return count($this->hand); // Updated to use $hand
    }
    
    public function getString(): array
    {
        $vals = [];
        foreach ($this->hand as $kort) { // Updated to use $hand
            $vals[] = $kort->getAsStr();
        }
        return $vals;
    }

    public function Ess(): int
    {
        $Ess = 0;
        foreach($this->hand as $kort) { // Updated to use $hand
            if ($kort->getRang() === 'Ess') {
                $Ess++;
            }
        }
        return $Ess;
    }
}

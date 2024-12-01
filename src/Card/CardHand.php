<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{   
    private array $handen = [];

    public function add(Card $kort): void
    {
        $this->hand[] = $kort;
    }

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
        return (int)$val;
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
        $vals = [];
        foreach ($this->hand as $kort) {
            $vals[] = $kort->getAsStr();
        }
        return $vals;
    }

    public function Ess(): int
    {
        $Ess = 0;
        foreach($this->hand as $kort) {
            if ($kort->getRang() === 'Ess') {
                $Ess++;
            }
        }
        return $Ess;
    }
}

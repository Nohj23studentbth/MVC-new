<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class Game21
{
    private DeckOfCards $kortlek;
    private CardHand $spelare;
    private CardHand $banken;

    public function __construct(DeckOfCards $kortlek, CardHand $spelare, CardHand $banken)
    {
        $this->kortlek = $kortlek;
        $this->spelare = $spelare;
        $this->banken = $banken;
    }

    public function getDeck(): DeckOfCards
    {
        return $this->kortlek;
    }

    public function getPlayerHand(): CardHand
    {
        return $this->spelare;
    }

    public function getBankHand(): CardHand
    {
        return $this->banken;
    }

    public function start21(): void
    {
        $this->kortlek->setupDeck();
        $this->kortlek->shuffle();

        $spelaresKort = $this->kortlek->draw(1);

        $this->spelare->addCardsArray($spelaresKort);
    }

    public function bankDraw(): int
    {
        $bankenHandVal = $this->checkAceValue($this->banken);

        while ($bankenHandVal < 17) {
            $kort = $this->kortlek->draw(1);
            $this->banken->add($kort[0]);

            $bankenHandVal = $this->checkAceValue($this->banken);
        }

        return $bankenHandVal;
    }

    public function checkAceValue(CardHand $kort): int
    {
        $totalVal = $kort->handValue();
        $Ess = $kort->Ess();

        while ($totalVal > 21 && 0 < $Ess) {
            $totalVal -= 13;
            $Ess--;
        }

        return (int)$totalVal;
    }

    public function comparePoints(): string
    {
        $bankenTotal = $this->checkAceValue($this->banken);
        $spelareTotal = $this->checkAceValue($this->spelare);

        switch (true) {
            case $spelareTotal > 21:
                return 'Banken vinner. Spelare över 21';
            case $bankenTotal > 21:
                return 'Spelare vinner, Banken över 21';
            case $spelareTotal < $bankenTotal:
                return 'Banken vinner på poäng';
            case $spelareTotal > $bankenTotal:
                return 'Spelare vinner på poäng';
            default:
                return 'Banken vinner genom lika';
        }
    }

}

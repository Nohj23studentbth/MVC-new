<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class Game21
{
    private DeckOfCards $deck;
    private CardHand $player;
    private CardHand $bank;

    public function __construct(DeckOfCards $deck, CardHand $player, CardHand $bank)
    {
        $this->deck = $deck;
        $this->player = $player;
        $this->bank = $bank;
    }

    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    public function getPlayerHand(): CardHand
    {
        return $this->player;
    }

    public function getBankHand(): CardHand
    {
        return $this->bank;
    }

    public function start21(): void
    {
        $this->deck->setupDeck();
        $this->deck->shuffle();

        $playersCard = $this->deck->draw(1);

        $this->player->addCardsArray($playersCard);
    }

    public function bankDraw(): int
    {
        $bankHandValue = $this->checkAceValue($this->bank);

        while ($bankHandValue < 17) {
            $card = $this->deck->draw(1);
            $this->bank->add($card[0]);

            $bankHandValue = $this->checkAceValue($this->bank);
        }

        return $bankHandValue;
    }

    public function checkAceValue(CardHand $cards): int
    {
        $totValue = $cards->handValue();
        $aces = $cards->aces();

        while ($totValue > 21 && 0 < $aces) {
            $totValue -= 13;
            $aces--;
        }

        return (int)$totValue;
    }

    public function comparePoints(): string
    {
        $bankTotal = $this->checkAceValue($this->bank);
        $playerTotal = $this->checkAceValue($this->player);

        switch (true) {
            case $playerTotal > 21:
                return 'Bank Wins, Player get bust';
            case $bankTotal > 21:
                return 'Player Wins, Bank get bust';
            case $playerTotal < $bankTotal:
                return 'Bank Wins by points';
            case $playerTotal > $bankTotal:
                return 'Player wins by points';
            default:
                return 'Bank wins thru a Tie';
        }
    }

}

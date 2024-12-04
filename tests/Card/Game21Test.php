<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Testfall för klassen Game21.
 */
class Game21Test extends TestCase
{
    public function test__constructor(): void
    {
        // Skapa mock-objekt för bankens hand, spelarens hand och kortlek
        $bankensHand = $this->createMock(CardHand::class);
        $spelarensHand = $this->createMock(CardHand::class);
        $kortlek = $this->createMock(DeckOfCards::class);

        // Skapa ett nytt Game21-objekt
        $spel = new Game21($kortlek, $spelarensHand, $bankensHand);

        // Kontrollera att kortleken och händerna har ställts in korrekt
        $this->assertEquals($kortlek, $spel->getDeck());
        $this->assertEquals($spelarensHand, $spel->getPlayerHand());
        $this->assertEquals($bankensHand, $spel->getBankHand());
    }

    public function testStart21(): void
    {
        // Skapa mock-objekt för kortlek och hand
        $stubKortlek = $this->createMock(DeckOfCards::class);
        $stubHand = $this->createMock(CardHand::class);

        // Förvänta oss att vissa metoder anropas en gång
        $stubKortlek->expects($this->once())
            ->method('setupDeck');
        $stubKortlek->expects($this->once())
            ->method('shuffle');
        $stubKortlek->expects($this->once())
            ->method('draw');

        // Förvänta oss att addCardsArray anropas en gång
        $stubHand->expects($this->once())
            ->method('addCardsArray');

        // Skapa ett nytt Game21-objekt och starta spelet
        $spel21 = new Game21($stubKortlek, $stubHand, $stubHand);
        $spel21->start21();
    }

    public function testBankDraw(): void
    {
        // Skapa en kortlek och starta den
        $kortlek = new DeckOfCards();
        $kortlek->setupDeck();

        // Skapa händer för spelaren och banken
        $spelarensHand = new CardHand();
        $bankensHand = new CardHand();

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($kortlek, $spelarensHand, $bankensHand);

        // Hämta värdet för bankens hand
        $bankensHandValue = $spel21->bankDraw();

        // Kontrollera att bankens handvärde är ett heltal och är större än eller lika med 17
        $this->assertIsInt($bankensHandValue);
        $this->assertGreaterThanOrEqual(17, $bankensHandValue);
    }

    public function testCheckAceValue(): void
    {
        // Skapa en kortlek och starta den
        $kortlek = new DeckOfCards();
        $kortlek->setupDeck();

        // Skapa en hand med kort
        $kortHand = new CardHand();
        $kort = new Card('Ess', 'Ruter', 1);
        $kort2 = new Card('10', 'Spader', 10);
        $kort3 = new Card('10', 'Klöver', 10);

        $testCards = [$kort, $kort2, $kort3];

        // Lägg till korten i handen
        $kortHand->addCardsArray($testCards);

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($kortlek, $kortHand, $kortHand);

        // Kontrollera att värdet på handen inte är mer än 21 efter att ha räknat Ess
        $valcheck = $spel21->checkAceValue($kortHand);
        $this->assertLessThanOrEqual(21, $valcheck);
    }

    public function testComparePointsPlayerBust(): void
    {
        // Skapa mock-objekt för kortlek, bank och spelare
        $stubKortlek = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubSpelare = $this->createMock(CardHand::class);

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($stubKortlek, $stubSpelare, $stubBank);

        // Simulera att spelarens handvärde är 25 och bankens handvärde är 17
        $stubSpelare->method('handValue')
            ->willReturn(25);
        $stubBank->method('handValue')
            ->willReturn(17);

        // Jämför poängen
        $resultstr = $spel21->comparePoints();

        // Kontrollera att resultatet är korrekt
        $this->assertEquals('Banken vinner. Spelare över 21', $resultstr);
    }

    public function testComparePointsBankBust(): void
    {
        // Skapa mock-objekt för kortlek, bank och spelare
        $stubKortlek = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubSpelare = $this->createMock(CardHand::class);

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($stubKortlek, $stubSpelare, $stubBank);

        // Simulera att spelarens handvärde är 17 och bankens handvärde är 25
        $stubSpelare->method('handValue')
            ->willReturn(17);
        $stubBank->method('handValue')
            ->willReturn(25);

        // Jämför poängen
        $resultstr = $spel21->comparePoints();

        // Kontrollera att resultatet är korrekt
        $this->assertEquals('Spelare vinner, Banken över 21', $resultstr);
    }

    public function testComparePointsBankWinsByPoints(): void
    {
        // Skapa mock-objekt för kortlek, bank och spelare
        $stubKortlek = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubSpelare = $this->createMock(CardHand::class);

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($stubKortlek, $stubSpelare, $stubBank);

        // Simulera att spelarens handvärde är 20 och bankens handvärde är 21
        $stubSpelare->method('handValue')
            ->willReturn(20);
        $stubBank->method('handValue')
            ->willReturn(21);

        // Jämför poängen
        $resultstr = $spel21->comparePoints();

        // Kontrollera att resultatet är korrekt
        $this->assertEquals('Banken vinner på poäng', $resultstr);
    }

    public function testComparePointsPlayerWinsByPoints(): void
    {
        // Skapa mock-objekt för kortlek, bank och spelare
        $stubKortlek = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubSpelare = $this->createMock(CardHand::class);

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($stubKortlek, $stubSpelare, $stubBank);

        // Simulera att spelarens handvärde är 21 och bankens handvärde är 20
        $stubSpelare->method('handValue')
            ->willReturn(21);
        $stubBank->method('handValue')
            ->willReturn(20);

        // Jämför poängen
        $resultstr = $spel21->comparePoints();

        // Kontrollera att resultatet är korrekt
        $this->assertEquals('Spelare vinner på poäng', $resultstr);
    }

    public function testComparePointsTie(): void
    {
        // Skapa mock-objekt för kortlek, bank och spelare
        $stubKortlek = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubSpelare = $this->createMock(CardHand::class);

        // Skapa ett nytt Game21-objekt
        $spel21 = new Game21($stubKortlek, $stubSpelare, $stubBank);

        // Simulera att både spelarens och bankens handvärde är 21
        $stubSpelare->method('handValue')
            ->willReturn(21);
        $stubBank->method('handValue')
            ->willReturn(21);

        // Jämför poängen
        $resultstr = $spel21->comparePoints();

        // Kontrollera att resultatet är korrekt
        $this->assertEquals('Banken vinner genom lika', $resultstr);
    }

}

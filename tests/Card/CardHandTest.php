<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    public function testCreateCardHand(): void
    {
        // mock för kort klass
        $stub = $this->createMock(Card::class);

        // mock metoder
        $stub->method('getRang')
            ->willReturn('Ess');
        $stub->method('getColour')
            ->willReturn('Ruter');  // korrekt färg
        $stub->method('getVal')
            ->willReturn(14);

        $kortHand = new CardHand();
        $kortHand->add(clone $stub);

        $korts = $kortHand->getHand();

        foreach ($korts as $testCard) {
            $this->assertInstanceOf(Card::class, $testCard);  // Instace av kort?
            $this->assertEquals('Ess', $testCard->getRang());  // korrekt rang
            $this->assertEquals('Ruter', $testCard->getColour());  // korrekt färg
            $this->assertEquals(14, $testCard->getVal());  // korrekt värde
        }
    }

    public function testAddCardHandThruArray(): void
    {
        // Initisera kort objekt
        $kort = new Card('Ess', 'Ruter', 14);
        $kort2 = new Card('Knekt', 'Spader', 11);
        $kort3 = new Card('10', 'Klöver', 10);

        // Array av kort objekt
        $testCards = [$kort, $kort2, $kort3];

        $kortHand = new CardHand();

        // lägg kort fråbn array till hand
        $kortHand->addCardsArray($testCards);
        $getCardHand = $kortHand->getHand();

        // matchning
        $this->assertEquals($kort, $getCardHand[0]);
        $this->assertEquals($kort2, $getCardHand[1]);
        $this->assertEquals($kort3, $getCardHand[2]);
    }

    public function testHandValue(): void
    {
        // skapa kort och hand
        $kort = new Card('10', 'Klöver', 10);
        $kortHand = new CardHand();

        // lägg till kort 
        $kortHand->add($kort);
        $kortHandValue = $kortHand->handValue();

        // matchning
        $this->assertEquals(10, $kortHandValue);
    }

    public function testGetNumCards(): void
    {
        $kort = new Card('10', 'Klöver', 10);
        $kortHand = new CardHand();

        // lägg till kort och hand
        $kortHand->add($kort);

        // nummer av kort på hand
        $this->assertSame(1, $kortHand->getNumCards());
        $this->assertIsInt($kortHand->getNumCards());
    }

    public function testGetStringHand(): void
    {
        $kort = new Card('10', 'Klöver', 10);
        $kortHand = new CardHand();
    
        // Lägg till kort och hand
        $kortHand->add($kort);
        $kortString = $kortHand->getString();
    
        // Kontrollera innehåll
        $this->assertEquals('10 Klöver', $kortString[0], "The first card string should match the expected format.");
    }
    
}

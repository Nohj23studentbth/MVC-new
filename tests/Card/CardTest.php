<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Test creation of a Card object and verify that the object has the expected properties.
     */
    public function testCreateCard(): void
    {
        $colour = 'Ruter';
        $rang = 'Kung';
        $val = 13;

        $kort = new Card($colour, $rang, $val);

        $this->assertInstanceOf(Card::class, $kort);
    }

    // Test konstruktor och getter metod
    public function testCardConstructorAndGetters(): void
    {
        $colour = 'Ruter';
        $rang = 'Kung';
        $val = 13;
        
        $kort = new Card($colour, $rang, $val);
        
        // Test getColour() metod
        $this->assertEquals($colour, $kort->getColour());
        
        // Test getRang() metod
        $this->assertEquals($rang, $kort->getRang());
        
        // Test getVal() metod
        $this->assertEquals($val, $kort->getVal());
    }

    // Test edge case
    public function testCardWithDifferentValues(): void
    {
        $colour = 'Klöver';
        $rang = 'Kung';
        $val = 13;

        $kort = new Card($colour, $rang, $val);

        // Test värde set korrekt
        $this->assertEquals($colour, $kort->getColour());
        $this->assertEquals($rang, $kort->getRang());
        $this->assertEquals($val, $kort->getVal());

        // Test getAsStr() med annan input
        $this->assertEquals("Klöver Kung", $kort->getAsStr());
    }

    // Test the getAsStr() metod
    public function testGetAsStr(): void
    {
        $colour = 'Ruter';
        $rang = 'Kung';
        $val = 13;
        
        $kort = new Card($colour, $rang, $val);
        
        // Test if getAsStr() returnerar korrekt
        $this->assertEquals("Ruter Kung", $kort->getAsStr());
    }
}

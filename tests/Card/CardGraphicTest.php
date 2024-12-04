<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class CardGraphicTest extends TestCase
{
    // Testa konstruktorn och getAsStr() för varje färg
    public function testCardGraphicConstructorAndGetAsStr()
    {
        // Test för Klöver (♣)
        $kort = new CardGraphic('Klöver', 'Kung', 13);
        $this->assertEquals('♣ Kung', $kort->getAsStr());

        // Test för Spader (♠)
        $kort = new CardGraphic('Spader', 'Dam', 12);
        $this->assertEquals('♠ Dam', $kort->getAsStr());

        // Test för Ruter (♦)
        $kort = new CardGraphic('Ruter', 'Ess', 1);
        $this->assertEquals('♦ Ess', $kort->getAsStr());

        // Test för Hjärter (♥)
        $kort = new CardGraphic('Hjärter', 'Knekt', 11);
        $this->assertEquals('♥ Knekt', $kort->getAsStr());
    }

    // Testa om parent fungerar
    public function testCardGraphicGetters()
    {
        //  Skapa kort
        $kort = new CardGraphic('Spader', 'Kung', 13);

        $this->assertEquals('Spader', $kort->getColour());
        $this->assertEquals('Kung', $kort->getRang());
        $this->assertEquals(13, $kort->getVal());
    }
   
}

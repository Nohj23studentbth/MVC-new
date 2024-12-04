<?php

use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCardsTest extends TestCase
{
    private DeckOfCards $deck;

    protected function setUp(): void
    {
        // skapa ny kortlek efter varje
        $this->deck = new DeckOfCards();
    }

    public function testDeckCountAfterSetupDeck(): void
    {
        // Setup kortlek med CardGraphics
        $this->deck->setupDeck();
        $this->assertCount(52, $this->deck->getDeck(), "Deck should contain 52 cards after setupDeck.");
    }

    public function testDeckCountAfterSetupDeckText(): void
    {
        // Setup kortlek med kort
        $this->deck->setupDeckText();
        $this->assertCount(52, $this->deck->getDeck(), "Deck should contain 52 cards after setupDeckText.");
    }

    public function testShuffleDeck(): void
    {
        // Setup kort
        $this->deck->setupDeck();
        $originalDeck = $this->deck->getDeck();

        // blanda koirt
        $this->deck->shuffle();
        $shuffledDeck = $this->deck->getDeck();

        $this->assertNotEquals($originalDeck, $shuffledDeck, "Deck should be shuffled.");
    }

    public function testDrawCards(): void
    {
        // Setup kort
        $this->deck->setupDeck();
        $originalCount = $this->deck->countCards();

        // Dra 5 kort
        $drawnCards = $this->deck->draw(5);

        $this->assertCount(5, $drawnCards, "Should draw exactly 5 cards.");
        $this->assertEquals($originalCount - 5, $this->deck->countCards(), "Deck count should decrease by 5.");
    }

    public function testDrawMoreCardsThanAvailable(): void
    {
        // Setup kort
        $this->deck->setupDeck();
        $this->deck->draw(52); // Draw all 52 cards
        $drawnCards = $this->deck->draw(10); // Try to draw more than available

        // returenerar remainging cards
        $this->assertEmpty($drawnCards, "Should not be able to draw more cards than available.");
    }

    public function testCardValueConversion(): void
    {
        // Test kort värde
        $this->assertEquals(14, $this->deck->setVal('Ess'), "Ess should be worth 14.");
        $this->assertEquals(11, $this->deck->setVal('Knekt'), "Knekt should be worth 11.");
        $this->assertEquals(12, $this->deck->setVal('Dam'), "Dam should be worth 12.");
        $this->assertEquals(13, $this->deck->setVal('Kung'), "Kung should be worth 13.");
        $this->assertEquals(2, $this->deck->setVal('2'), "Numeric values should be returned as integers.");
    }

    public function testGetStringRepresentations(): void
    {
        // Setup kortlek med CardGraphics
        $this->deck->setupDeck();

        $cardStrings = $this->deck->getString();
        $this->assertCount(52, $cardStrings, "There should be 52 string representations of cards.");
        $this->assertIsArray($cardStrings, "getString should return an array.");
    }
}

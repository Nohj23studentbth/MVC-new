<?php

namespace App\Card;

class Card
{
    protected string $colour;
    protected string $rang;
    protected int $val;

    public function __construct(string $colour, string $rang, int $val)
    {
        $this->colour = $colour;
        $this->rang = $rang;
        $this->val = $val;
    }
    
    public function getRang(): string
    {
        return $this->rang;
    }

    public function getColour(): string
    {
        return $this->colour;
    }

    public function getVal(): int
    {
        return $this->val;
    }

    public function getAsStr(): string
    {
        return "{$this->colour} {$this->rang}";
    }
}

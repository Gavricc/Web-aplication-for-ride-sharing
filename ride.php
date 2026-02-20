<?php
declare(strict_types=1);

class Ride
{
    private string $from;
    private string $to;
    private string $time;
    private int $freeSpaces;
    private float $price;

    public function __construct(string $from, string $to, string $time, int $freeSpaces, float $price)
    {
        $this->from = $from;
        $this->to = $to;
        $this->time = $time;
        $this->freeSpaces = $freeSpaces;
        $this->price = $price;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    public function getFreeSpaces(): int
    {
        return $this->freeSpaces;
    }

    public function setFreeSpaces(int $freeSpaces): void
    {
        $this->freeSpaces = $freeSpaces;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
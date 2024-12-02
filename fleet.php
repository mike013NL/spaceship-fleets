<?php

require_once 'spaceship.php';

class Fleet
{
    public $name;
    public $spaceships = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addSpaceship($spaceship)
    {
        $this->spaceships[] = $spaceship;
    }

    public function calculateTotalDamage()
    {
        $totalDamage = 0;
        foreach ($this->spaceships as $spaceship) {
            $totalDamage += $spaceship->damage;
        }
        return $totalDamage;
    }

    public function calculateTotalHits()
    {
        $totalHits = 0;
        foreach ($this->spaceships as $spaceship) {
            $totalHits += $spaceship->hits;
        }
        return $totalHits;
    }
}

function generateRandomFleet($name, $spaceshipTypes, $maxShips = 5)
{
    $fleet = new Fleet($name);
    $numShips = rand(1, $maxShips);

    for ($i = 0; $i < $numShips; $i++) {
        $typeIndex = array_rand($spaceshipTypes);
        $spaceship = new $spaceshipTypes[$typeIndex]();
        $fleet->addSpaceship($spaceship);
    }
    return $fleet;
}

function battleFleets($fleet1, $fleet2)
{
    $fleet1Damage = $fleet1->calculateTotalDamage();
    $fleet2Damage = $fleet2->calculateTotalDamage();

    if ($fleet1Damage > $fleet2Damage) {
        return $fleet1;
    } elseif ($fleet2Damage > $fleet1Damage) {
        return $fleet2;
    } else {
        return null;
    }
}

function calculateFleetRanking($fleets)
{
    $rankings = [];
    foreach ($fleets as $fleet) {
        $score = $fleet->calculateTotalDamage() * 2 + $fleet->calculateTotalHits();
        $rankings[$fleet->name] = $score;
    }
    arsort($rankings);
    return $rankings;
}

<?php


class Spaceship
{
    public $name;
    public $damage;
    public $hits;

    public function __construct($name, $damage = 0, $hits = 0)
    {
        $this->name = $name;
        $this->damage = $damage;
        $this->hits = $hits;
    }

    public function attack()
    {
        $this->hits++;
        $this->damage += rand(10, 50); // Random damage per hit
    }
}

// Specifieke soorten spaceships
class LightSpaceship extends Spaceship
{
    public function __construct()
    {
        parent::__construct('Light Spaceship', rand(20, 40), 0);
    }
}

class HeavySpaceship extends Spaceship
{
    public function __construct()
    {
        parent::__construct('Heavy Spaceship', rand(40, 70), 0);
    }
}

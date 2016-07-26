<?php

namespace Tiixstone\Game;

abstract class Hero
{
    /**
     * @var int
     */
    protected $health;

    public function __construct()
    {
        $this->health = $this->maximumHealth();
    }

    /**
     * @return bool
     */
    public function isAlive() : bool
    {
        return $this->health > 0;
    }

    /**
     * @return int
     */
    public function health() : int
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function maximumHealth() : int
    {
        return 30;
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function addHealth(int $amount)
    {
        $this->health = $this->health + $amount;

        if($this->health > $this->maximumHealth()) {
            $this->health = $this->maximumHealth();
        }

        return $this;
    }

    /**
     * @param int $amount
     * @return Hero
     */
    public function reduceHealth(int $amount) : self
    {
        $this->health = $this->health - $amount;

        return $this;
    }

    /**
     * @param int $amount
     * @return Hero
     */
    public function setHealth(int $amount) : self
    {
        if($amount > $this->maximumHealth()) {
            throw new Exception("Overheal");
        }

        $this->health = $amount;

        return $this;
    }
}
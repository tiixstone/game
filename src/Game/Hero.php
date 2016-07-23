<?php

namespace Tiixstone\Game;

abstract class Hero
{
    /**
     * @var
     */
    protected $health = 30;

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
        $this->health = $amount;

        return $this;
    }
}
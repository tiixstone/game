<?php

namespace Tiixstone\Game;

abstract class Hero
{
    /**
     * @var
     */
    protected $maximumHealth;

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
    public function health()
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function maximumHealth()
    {
        return $this->health;
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
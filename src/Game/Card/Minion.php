<?php

namespace Tiixstone\Game\Card;

use Tiixstone\Game;
use Tiixstone\Game\Card;

abstract class Minion extends Card
{
    const ABILITY_ONGOING_EFFECT = 1;

    protected $ongoingEffectApplied = false;

    /**
     * @var array
     */
    protected $abilities = [];

    /**
     * @var int
     */
    protected $health;

    /**
     * @var int
     */
    protected $attackRate;

    /**
     * @var int
     */
    protected $damage = 0;

    /**
     * @var bool
     */
    protected $exhausted = true;

    final public function __construct()
    {
        parent::__construct();

        $this->health = $this->defaultHealth();
        $this->attackRate = $this->defaultAttackRate();
    }

    /**
     * @param Game $game
     * @return $this
     * @throws Game\Exception
     */
    final public function play(Game $game)
    {
        return $this;
    }

    /**
     * @return array
     */
    final public function abilities() : array
    {
        return $this->abilities;
    }

    /**
     * @return int
     */
    abstract public function defaultHealth() : int;

    /**
     * @return int
     */
    abstract public function defaultAttackRate() : int;

    /**
     * @param int $damage
     * @return $this
     * @throws Game\Exception
     */
    public function addDamage(int $damage)
    {
        if($damage <= 0) {
            throw new Game\Exception("Damage should be greater than zero");
        }

        $this->damage = $this->damage + $damage;

        return $this;
    }

    /**
     * @return int
     */
    public function health(Game $game) : int
    {
        return $this->health - $this->damage;
    }

    /**
     * @param int $health
     * @return $this
     */
    final public function setHealth(int $health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * @return int
     */
    public function attackRate(Game $game) : int
    {
        return $this->attackRate;
    }

    /**
     * @param int $attackRate
     * @return $this
     */
    final public function setAttackRate(int $attackRate)
    {
        $this->attackRate = $attackRate >= 0 ? $attackRate : 0;

        return $this;
    }

    /**
     * Условие при котором существо может атаковать
     *
     * @param Game $game
     * @return bool
     */
    public function attackCondition(Game $game) : bool
    {
        return true;
    }

    /**
     * @param Game $game
     * @return bool
     */
    public function isDead(Game $game)
    {
        return $this->health($game) <= 0;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        parent::reset();

        $this->health = $this->defaultHealth();
        $this->attackRate = $this->defaultAttackRate();

        return $this;
    }

    /**
     * @return bool
     */
    public function isExhausted() : bool
    {
        return $this->exhausted;
    }

    /**
     * @param bool $exhausted
     * @return $this
     */
    public function setExhausted(bool $exhausted)
    {
        $this->exhausted = $exhausted;

        return $this;
    }
}
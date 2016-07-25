<?php declare(strict_types=1);

namespace Tiixstone\Game;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Card\Spell;

abstract class Card
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var
     */
    protected $cost;

    public function __construct()
    {
        $this->id = uniqid();
        $this->cost = $this->defaultCost();
    }

    /**
     * @param Game $game
     * @return mixed
     */
    abstract public function play(Game $game);

    /**
     * @return int
     */
    abstract public function defaultCost() : int;

    /**
     * @return int
     */
    public function cost(Game $game) : int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     * @return $this
     */
    final public function setCost(int $cost)
    {
        if($cost < 0) {
            throw new Exception("Card mana cost can not less than zero");
        }

        $this->cost = $cost;

        return $this;
    }

    /**
     * @param int $cost
     * @return $this
     */
    final public function reduceCost(int $cost)
    {
        $cost = $this->cost - $cost;

        $this->cost = $cost >= 0 ? $cost : 0;

        return $this;
    }

    /**
     * @param int $cost
     * @return $this
     */
    final public function addCost(int $cost)
    {
        $this->cost = $this->cost + $cost;

        return $this;
    }

    /**
     * @return string
     */
    final public function id()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isSpell()
    {
        return $this instanceof Spell;
    }

    /**
     * @return bool
     */
    public function isMinion()
    {
        return $this instanceof Minion;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->cost = $this->defaultCost();

        return $this;
    }
}
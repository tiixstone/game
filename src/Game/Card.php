<?php

namespace Tiixstone\Game;

use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Card\Spell;

abstract class Card
{
    protected $id;

    final public function __construct()
    {
        $this->id = uniqid();
    }

    /**
     * @return int
     */
    abstract public function cost() : int;

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
}
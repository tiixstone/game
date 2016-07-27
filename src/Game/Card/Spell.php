<?php

namespace Tiixstone\Game\Card;

use Tiixstone\Game;
use Tiixstone\Game\Card;

abstract class Spell extends Card
{
    final public function __construct()
    {
        parent::__construct();
    }

    abstract public function cast(Game $game);

    /**
     * @param Game $game
     */
    final public function play(Game $game)
    {
        $this->cast($game);

        return $this;
    }
}
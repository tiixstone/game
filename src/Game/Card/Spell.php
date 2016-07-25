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

    public function play(Game $game)
    {
        $this->cast($game);
    }
}
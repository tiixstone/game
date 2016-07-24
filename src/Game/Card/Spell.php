<?php

namespace Tiixstone\Game\Card;

use Tiixstone\Game;
use Tiixstone\Game\Card;

abstract class Spell extends Card
{
    abstract public function cast(Game $game);
}
<?php

namespace Tiixstone\Game\Card;

use Tiixstone\Game\Card;

abstract class Minion extends Card
{
    /**
     * @return int
     */
    abstract public function health() : int;

    /**
     * @return int
     */
    abstract public function attackRate() : int;
}
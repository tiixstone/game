<?php

namespace Tiixstone\Game\Card\Minion;

use Tiixstone\Game\Card;

class Sheep extends Card\Minion
{
    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 1;
    }
}
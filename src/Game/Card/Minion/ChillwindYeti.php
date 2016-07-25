<?php

namespace Tiixstone\Game\Card\Minion;

use Tiixstone\Game\Card\Minion;

class ChillwindYeti extends Minion
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 4;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 5;
    }

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 4;
    }
}
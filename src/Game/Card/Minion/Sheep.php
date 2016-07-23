<?php

namespace Tiixstone\Game\Card\Minion;

use Tiixstone\Game\Card;

class Sheep extends Card\Minion
{
    /**
     * @return int
     */
    public function attackRate() : int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function health() : int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function cost() : int
    {
        return 1;
    }
}
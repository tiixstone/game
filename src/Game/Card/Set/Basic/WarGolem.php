<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game\Card\Minion;

class WarGolem extends Minion
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 7;
    }

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 7;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 7;
    }
}
<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game\Card\Minion;

class BoulderfistOgre extends Minion
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 6;
    }

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 6;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 7;
    }
}
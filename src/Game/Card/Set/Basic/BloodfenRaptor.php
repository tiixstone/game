<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game\Card\Minion;

class BloodfenRaptor extends Minion
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 2;
    }

    /**
     * @return int
     */
    public function defaultAttackRate() : int
    {
        return 3;
    }

    /**
     * @return int
     */
    public function defaultHealth() : int
    {
        return 2;
    }
}
<?php declare(strict_types=1);

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;

/**
 * Class AttackManager
 *
 * @package Tiixstone\Game\Manager
 */
class AttackManager
{
    public function minionTakeDamage(Game $game, Minion $minion, int $damage)
    {
        $minion->addDamage($damage);
    }
}
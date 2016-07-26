<?php declare(strict_types=1);

namespace Tiixstone\Game\Manager;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Hero;

/**
 * Class AttackManager
 *
 * @package Tiixstone\Game\Manager
 */
class AttackManager
{
    /**
     * @param Game $game
     * @param Minion $minion
     * @param int $damage
     * @return $this
     * @throws Game\Exception
     */
    public function minionTakeDamage(Game $game, Minion $minion, int $damage)
    {
        $minion->addDamage($damage);

        return $this;
    }

    /**
     * @param Game $game
     * @param Hero $hero
     * @param int $damage
     * @return $this
     */
    public function heroTakeDamage(Game $game, Hero $hero, int $damage)
    {
        $hero->reduceHealth($damage);

        return $this;
    }
}
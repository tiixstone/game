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

        $game->eventDispatcher->dispatch(
            Game\Event\MinionTookDamage::NAME,
            new Game\Event\MinionTookDamage($minion, $damage)
        );

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

    /**
     * @param Game $game
     * @param Minion $minion
     * @return $this
     */
    public function destroyMinion(Game $game, Game\Player $player, Minion $minion)
    {
        $player->board->remove($minion->id());

        $game->eventDispatcher->dispatch(Game\Event\MinionDestroyed::NAME, new Game\Event\MinionDestroyed($minion));

        $minion->reset();

        $player->graveyard->append($minion);
        
        return $this;
    }
}
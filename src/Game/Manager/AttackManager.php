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
        $game->eventDispatcher->dispatch(
            Game\Event\MinionTookDamage::NAME,
            new Game\Event\MinionTookDamage($minion, $damage)
        );

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

        if(!$hero->isAlive()) {
            $game->eventDispatcher->dispatch(Game\Event\HeroDestroyed::NAME, new Game\Event\HeroDestroyed($game, $hero));
        }

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

    /**
     * @param Game $game
     * @param Game\Player $player
     * @param Hero $hero
     * @return $this
     */
    public function fatigue(Game $game, Game\Player $player)
    {
        $fatigue = $player->fatigue();

        $game->eventDispatcher->dispatch(
            Game\Event\FatigueDealt::NAME,
            new Game\Event\FatigueDealt($game, $player->hero, $fatigue)
        );

        $this->heroTakeDamage($game, $player->hero, $fatigue);

        $player->incrementFatigue();

        return $this;
    }

    /**
     * @param Game $game
     * @return int
     */
    public function spellDamageBoost(Game $game) : int
    {
        return 0;
    }
}
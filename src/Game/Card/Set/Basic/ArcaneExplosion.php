<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Card\Spell;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ArcaneExplosion
 *
 * @package Tiixstone\Game\Card\Set\Basic
 */
class ArcaneExplosion extends Spell
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 2;
    }

    /**
     * @param Game $game
     * @return $this
     */
    public function cast(Game $game, Minion $target = null)
    {
        /** @var Game\Card\Minion $minion */
        foreach($game->idlePlayer()->board->all() as $minion) {
            $game->attackManager->minionTakeDamage($game, $minion, $game->attackManager->spellDamageBoost($game) + 1);
        }

        return $this;
    }
}
<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game;
use Tiixstone\Game\Card\Spell;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ArcaneMissiles
 *
 * @package Tiixstone\Game\Card\Set\Basic
 */
class ArcaneMissiles extends Spell
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 1;
    }

    /**
     * @param Game $game
     * @return $this
     */
    public function cast(Game $game)
    {
        $damage = $game->attackManager->spellDamageBoost($game) + $this->damage();

        $targets = array_merge($game->idlePlayer()->board->all(), [$game->idlePlayer()->hero]);

        for($i=0; $i<$damage; $i++) {
            $key = array_rand($targets);

            if($targets[$key] instanceof Game\Card\Minion) {
                $game->attackManager->minionTakeDamage($game, $targets[$key], 1);
            } elseif($targets[$key] instanceof Game\Hero) {
                $game->attackManager->heroTakeDamage($game, $targets[$key], 1);
            }
        }

        $game->cardsManager->drawMany($game, $game->currentPlayer(), 2);

        return $this;
    }

    /**
     * @return int
     */
    private function damage()
    {
        return 3;
    }
}
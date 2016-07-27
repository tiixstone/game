<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Card\Spell;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ArcaneIntellect
 *
 * @package Tiixstone\Game\Card\Set\Basic
 */
class ArcaneIntellect extends Spell
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 3;
    }

    /**
     * @param Game $game
     * @return $this
     */
    public function cast(Game $game, Minion $target = null)
    {
        $game->cardsManager->drawMany($game, $game->currentPlayer(), 2);

        return $this;
    }
}
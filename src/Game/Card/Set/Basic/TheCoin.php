<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Set\Basic;

use Tiixstone\Game;
use Tiixstone\Game\Card\Minion;
use Tiixstone\Game\Card\Spell;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class TheCoin
 *
 * Монетка, добавляею 1 единицу доступной маны
 *
 * @package Tiixstone\Game\Card\Spell
 */
class TheCoin extends Spell
{
    /**
     * @return int
     */
    public function defaultCost() : int
    {
        return 0;
    }

    /**
     * @return TheCoin
     */
    public function cast(Game $game, Minion $target = null)
    {
        $game->gameManager->addPlayerAvailableMana($game, $game->currentPlayer(), 1);

        return $this;
    }
}
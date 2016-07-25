<?php

namespace Tiixstone\Game\Card\Spell;

use Tiixstone\Game;
use Tiixstone\Game\Card\Spell;

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
    public function cast(Game $game)
    {
        $game->gameManager->incrementPlayerMana($game->currentPlayer());

        return $this;
    }
}
<?php

namespace Tiixstone\Game\Card\Spell;

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
    public function cost() : int
    {
        return 0;
    }

    /**
     * @return TheCoin
     */
    public function play()
    {
        return $this;
    }
}
<?php

namespace Tiixstone\Game;

use Tiixstone\Game\Card\Minion\ChillwindYeti;
use Tiixstone\Game\Card\Minion\DireWolfAlpha;
use Tiixstone\Game\Card\Minion\Sheep;
use Tiixstone\Game\Card\Spell\TheCoin;
use Tiixstone\Game\Hero\Jaina;

class Naming
{
    public function get($class)
    {
        switch (get_class($class))
        {
            case Jaina::class:
                return 'Jaina';

            case Sheep::class:
                return 'Sheep';

            case TheCoin::class:
                return 'The Coin';

            case ChillwindYeti::class:
                return 'Yeti';

            case DireWolfAlpha::class:
                return 'Dire Wolf Alpha';

            default:
                $parts = explode('\\', get_class($class));
                return end($parts);
        }
    }
}
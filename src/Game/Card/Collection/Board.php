<?php

namespace Tiixstone\Game\Card\Collection;

use Tiixstone\Game\Card\Collection;

class Board extends Collection
{
    const MAX_PLACES = 7;

    /**
     * @return bool
     */
    public function hasVacantPlace()
    {
        return count($this->cards) < self::MAX_PLACES;
    }
}
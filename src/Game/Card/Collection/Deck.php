<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Collection;

use Tiixstone\Game\Card\Collection;

/**
 * Class Deck
 *
 * Колода карт
 *
 * @package Tiixstone\Game\Card\Collection
 */
class Deck extends Collection
{
    /**
     * @return Deck
     */
    public function shuffle() : self
    {
        shuffle($this->cards);

        return $this;
    }
}
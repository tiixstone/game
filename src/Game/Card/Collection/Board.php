<?php

namespace Tiixstone\Game\Card\Collection;

use Tiixstone\Game\Card;
use Tiixstone\Game\Card\Collection;
use Tiixstone\Game\Exception;

class Board extends Collection
{
    const MAX_PLACES = 7;

    public function __construct(array $cards = [])
    {
        if(count($cards) > self::MAX_PLACES) {
            throw new Exception(
                sprintf("Max number of cards on board %s", self::MAX_PLACES),
                Exception::EXCEEDED_PLACES_ON_BOARD
            );
        }

        parent::__construct($cards);
    }

    /**
     * @param Card $card
     * @return Hand
     * @throws Exception
     */
    public function append(Card $card)
    {
        if($this->count() >= self::MAX_PLACES) {
            throw new Exception(
                sprintf("Max number of cards on board %s", self::MAX_PLACES),
                Exception::EXCEEDED_PLACES_ON_BOARD
            );
        }

        return parent::append($card);
    }

    /**
     * @return bool
     */
    public function hasVacantPlace()
    {
        return count($this->cards) < self::MAX_PLACES;
    }
}
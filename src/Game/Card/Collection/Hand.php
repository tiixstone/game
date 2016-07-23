<?php declare(strict_types=1);

namespace Tiixstone\Game\Card\Collection;

use Tiixstone\Game\Card;
use Tiixstone\Game\Card\Collection;
use Tiixstone\Game\Exception;

class Hand extends Collection
{
    const MAX_CARDS_COUNT = 10;

    public function __construct(array $cards = [])
    {
        if(count($cards) > self::MAX_CARDS_COUNT) {
            throw new Exception(
                sprintf("Max number of cards in hand %s", self::MAX_CARDS_COUNT),
                Exception::EXCEEDED_MAX_NUMBER_CARDS_IN_HAND
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
        if($this->count() >= self::MAX_CARDS_COUNT) {
            throw new Exception(
                sprintf("Max number of cards in hand %s", self::MAX_CARDS_COUNT),
                Exception::EXCEEDED_MAX_NUMBER_CARDS_IN_HAND
            );
        }

        return parent::append($card);
    }

    /**
     * @return bool
     */
    public function maximum()
    {
        return $this->count() >= self::MAX_CARDS_COUNT;
    }
}
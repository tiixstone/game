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
        parent::__construct($cards);

        if($this->count() > self::MAX_CARDS_COUNT) {
            throw new Exception(sprintf("Max number of cards in hand %s", self::MAX_CARDS_COUNT), 3);
        }
    }
}
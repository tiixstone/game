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

    /**
     * @param int $key
     * @return Card
     * @throws Exception
     */
    public function pull(int $key) : Card
    {
        $card = $this->get($key);

        unset($this->cards[$key]);

        $this->reset();

        return $card;
    }

    /**
     * @return Hand
     */
    private function reset() : self
    {
        $this->cards = array_values($this->cards);

        return $this;
    }
}